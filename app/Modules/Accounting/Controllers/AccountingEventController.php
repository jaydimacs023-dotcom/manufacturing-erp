<?php

namespace Modules\Accounting\Controllers;

use App\Http\Controllers\Controller;
use Modules\Accounting\Services\AccountingEventService;
use Modules\Accounting\Services\PostingService;
use Modules\Accounting\Models\AccountingEvent;
use Modules\Accounting\Repositories\JournalMappingRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AccountingEventController extends Controller
{
    public function __construct(
        protected AccountingEventService $accountingEventService,
        protected PostingService $postingService,
        protected JournalMappingRepository $journalMappingRepository,
    ) {}

    public function index(): View
    {
        $events = $this->accountingEventService->getPaginated();
        $todayPostings = $this->accountingEventService->getTodayPostings();
        $pendingCount = $this->accountingEventService->getPendingEvents()->count();
        return view('admin.accounting.events.index', compact('events', 'todayPostings', 'pendingCount'));
    }

    public function show(AccountingEvent $event): View
    {
        $event->load(['branch', 'postingQueue', 'creator']);
        $mapping = $this->journalMappingRepository->findByTransactionType($event->transaction_type);
        return view('admin.accounting.events.show', compact('event', 'mapping'));
    }

    public function post(AccountingEvent $event): RedirectResponse
    {
        $queue = $this->postingService->enqueue($event);
        $this->postingService->process($queue);
        return redirect()->route('admin.accounting.events.index')
            ->with('success', 'Event processed successfully.');
    }

    public function cancel(AccountingEvent $event): RedirectResponse
    {
        $this->accountingEventService->markCancelled($event);
        return redirect()->route('admin.accounting.events.index')
            ->with('success', 'Event cancelled.');
    }

    public function repost(AccountingEvent $event): RedirectResponse
    {
        $this->accountingEventService->repost($event);
        $queue = $this->postingService->enqueue($event);
        $this->postingService->process($queue);
        return redirect()->route('admin.accounting.events.index')
            ->with('success', 'Event reposted successfully.');
    }
}
