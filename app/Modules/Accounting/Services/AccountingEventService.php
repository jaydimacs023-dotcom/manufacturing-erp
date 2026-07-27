<?php

namespace Modules\Accounting\Services;

use App\Services\AuditService;
use App\Services\NumberSeriesService;
use Modules\Accounting\Models\AccountingEvent;
use Modules\Accounting\Repositories\AccountingEventRepository;
use Modules\Accounting\Repositories\JournalMappingRepository;
use Modules\Accounting\Repositories\PostingQueueRepository;
use Modules\Accounting\Enums\AccountingEventStatus;

class AccountingEventService
{
    public function __construct(
        protected AccountingEventRepository $eventRepository,
        protected PostingQueueRepository $postingQueueRepository,
        protected JournalMappingRepository $journalMappingRepository,
        protected NumberSeriesService $numberSeriesService,
        protected AuditService $auditService,
    ) {}

    public function getPaginated(int $perPage = 15)
    {
        return $this->eventRepository->paginate($perPage);
    }

    public function create(array $data): AccountingEvent
    {
        if (!isset($data['event_number'])) {
            $data['event_number'] = $this->numberSeriesService->generateNext('AccountingEvent', 'AE');
        }
        if (!isset($data['status'])) {
            $data['status'] = AccountingEventStatus::Pending->value;
        }
        if (!isset($data['posting_date'])) {
            $data['posting_date'] = now()->toDateString();
        }

        $event = $this->eventRepository->create($data);
        $this->auditService->logCreate('accounting', $event->event_number, $data);
        return $event;
    }

    public function update(AccountingEvent $event, array $data): bool
    {
        $old = $event->toArray();
        $result = $this->eventRepository->update($event, $data);
        if ($result) {
            $this->auditService->logUpdate('accounting', $event->event_number, $old, $data);
        }
        return $result;
    }

    public function delete(AccountingEvent $event): bool
    {
        $this->auditService->logDelete('accounting', $event->event_number, $event->toArray());
        return $this->eventRepository->delete($event);
    }

    public function markPosted(AccountingEvent $event): bool
    {
        $event->status = AccountingEventStatus::Posted->value;
        $event->posted_at = now();
        $result = $event->save();
        if ($result) {
            $this->auditService->log('post', 'accounting', $event->event_number);
        }
        return $result;
    }

    public function markFailed(AccountingEvent $event, string $errorMessage): bool
    {
        $event->status = AccountingEventStatus::Failed->value;
        $event->error_message = $errorMessage;
        $event->retry_count = $event->retry_count + 1;
        return $event->save();
    }

    public function markCancelled(AccountingEvent $event): bool
    {
        $event->status = AccountingEventStatus::Cancelled->value;
        $result = $event->save();
        if ($result) {
            $this->auditService->logCancel('accounting', $event->event_number);
        }
        return $result;
    }

    public function repost(AccountingEvent $event): bool
    {
        $event->status = AccountingEventStatus::Reposted->value;
        $event->posted_at = null;
        $event->error_message = null;
        $result = $event->save();
        if ($result) {
            $this->auditService->log('repost', 'accounting', $event->event_number);
        }
        return $result;
    }

    public function getPendingEvents()
    {
        return $this->eventRepository->findPendingEvents();
    }

    public function getTodayPostings()
    {
        return $this->eventRepository->findTodayPostings();
    }
}
