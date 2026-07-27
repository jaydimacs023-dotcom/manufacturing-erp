<?php

namespace Modules\Accounting\Services;

use App\Services\AuditService;
use App\Services\NumberSeriesService;
use Modules\Accounting\Models\AccountingEvent;
use Modules\Accounting\Models\PostingQueue;
use Modules\Accounting\Repositories\AccountingEventRepository;
use Modules\Accounting\Repositories\PostingQueueRepository;
use Modules\Accounting\Repositories\JournalMappingRepository;
use Modules\Accounting\Enums\AccountingEventStatus;

class PostingService
{
    public function __construct(
        protected PostingQueueRepository $postingQueueRepository,
        protected AccountingEventRepository $eventRepository,
        protected JournalMappingRepository $journalMappingRepository,
        protected AccountingEventService $eventService,
        protected NumberSeriesService $numberSeriesService,
        protected AuditService $auditService,
    ) {}

    public function getPaginated(int $perPage = 15)
    {
        return $this->postingQueueRepository->paginate($perPage);
    }

    public function getPendingItems()
    {
        return $this->postingQueueRepository->findPendingItems();
    }

    public function getFailedItems()
    {
        return $this->postingQueueRepository->findFailedItems();
    }

    public function enqueue(AccountingEvent $event): PostingQueue
    {
        $data = [
            'queue_number' => $this->numberSeriesService->generateNext('PostingQueue', 'PQ'),
            'accounting_event_id' => $event->id,
            'status' => 'pending',
            'retry_count' => 0,
            'max_retries' => 3,
        ];

        $queue = $this->postingQueueRepository->create($data);
        $this->auditService->log('enqueue', 'accounting', $queue->queue_number);
        return $queue;
    }

    public function process(PostingQueue $queue): bool
    {
        $event = $queue->accountingEvent;
        if (!$event) {
            $queue->status = 'failed';
            $queue->error_message = 'Accounting event not found';
            $queue->save();
            return false;
        }

        try {
            // Validate posting conditions
            $this->validatePosting($event);

            // Mark event as posted
            $this->eventService->markPosted($event);

            // Update queue
            $queue->status = 'posted';
            $queue->processed_at = now();
            $queue->processed_by = auth()->id();
            $queue->save();

            $this->auditService->log('post', 'accounting', $queue->queue_number);
            return true;
        } catch (\Exception $e) {
            $queue->status = 'failed';
            $queue->retry_count = $queue->retry_count + 1;
            $queue->error_message = $e->getMessage();
            $queue->save();

            $this->eventService->markFailed($event, $e->getMessage());
            return false;
        }
    }

    public function retry(PostingQueue $queue): bool
    {
        if ($queue->retry_count >= $queue->max_retries) {
            return false;
        }

        $queue->status = 'pending';
        $queue->error_message = null;
        $queue->save();

        $accountingEvent = $queue->accountingEvent;
        if ($accountingEvent) {
            $accountingEvent->status = AccountingEventStatus::Pending->value;
            $accountingEvent->error_message = null;
            $accountingEvent->save();
        }

        return $this->process($queue);
    }

    public function processAllPending(): array
    {
        $results = ['success' => 0, 'failed' => 0];
        $pendingItems = $this->getPendingItems();

        foreach ($pendingItems as $queue) {
            if ($this->process($queue)) {
                $results['success']++;
            } else {
                $results['failed']++;
            }
        }

        return $results;
    }

    protected function validatePosting(AccountingEvent $event): void
    {
        // Check if already posted
        if ($event->status === AccountingEventStatus::Posted->value) {
            throw new \Exception('Event has already been posted.');
        }

        // Check if cancelled
        if ($event->status === AccountingEventStatus::Cancelled->value) {
            throw new \Exception('Event has been cancelled.');
        }

        // Validate journal mapping exists
        $mapping = $this->journalMappingRepository->findByTransactionType($event->transaction_type);
        if (!$mapping) {
            throw new \Exception("No journal mapping found for transaction type: {$event->transaction_type}");
        }

        // Validate amount
        if ($event->total_amount <= 0) {
            throw new \Exception('Total amount must be greater than zero.');
        }
    }
}
