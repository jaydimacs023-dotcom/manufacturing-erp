<?php

namespace Modules\Accounting\Controllers;

use App\Http\Controllers\Controller;
use Modules\Accounting\Services\PostingService;
use Modules\Accounting\Models\PostingQueue;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PostingQueueController extends Controller
{
    public function __construct(
        protected PostingService $postingService,
    ) {}

    public function index(): View
    {
        $queueItems = $this->postingService->getPaginated();
        $pendingItems = $this->postingService->getPendingItems();
        $failedItems = $this->postingService->getFailedItems();
        return view('admin.accounting.posting-queue.index', compact('queueItems', 'pendingItems', 'failedItems'));
    }

    public function show(PostingQueue $queue): View
    {
        $queue->load(['accountingEvent', 'processor']);
        return view('admin.accounting.posting-queue.show', compact('queue'));
    }

    public function process(PostingQueue $queue): RedirectResponse
    {
        $this->postingService->process($queue);
        return redirect()->route('admin.accounting.posting-queue.index')
            ->with('success', 'Queue item processed.');
    }

    public function retry(PostingQueue $queue): RedirectResponse
    {
        $result = $this->postingService->retry($queue);
        if ($result) {
            return redirect()->route('admin.accounting.posting-queue.index')
                ->with('success', 'Queue item retried successfully.');
        }
        return redirect()->route('admin.accounting.posting-queue.index')
            ->with('error', 'Max retries reached. Please review the error.');
    }

    public function processAll(): RedirectResponse
    {
        $results = $this->postingService->processAllPending();
        return redirect()->route('admin.accounting.posting-queue.index')
            ->with('success', "Processed: {$results['success']} success, {$results['failed']} failed.");
    }
}
