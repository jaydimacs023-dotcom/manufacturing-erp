<?php

namespace Modules\Accounting\Controllers;

use App\Http\Controllers\Controller;
use Modules\Accounting\Repositories\AccountMappingRepository;
use Modules\Accounting\Repositories\JournalMappingRepository;
use Modules\Accounting\Requests\StoreAccountMappingRequest;
use Modules\Accounting\Requests\StoreJournalMappingRequest;
use Modules\Accounting\Models\AccountMapping;
use Modules\Accounting\Models\JournalMapping;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AccountMappingController extends Controller
{
    public function __construct(
        protected AccountMappingRepository $accountMappingRepository,
        protected JournalMappingRepository $journalMappingRepository,
    ) {}

    public function index(): View
    {
        $accountMappings = $this->accountMappingRepository->findActiveMappings();
        $journalMappings = $this->journalMappingRepository->findActiveMappings();
        return view('admin.accounting.mappings.index', compact('accountMappings', 'journalMappings'));
    }

    public function createAccountMapping(): View
    {
        $directions = ['debit' => 'Debit', 'credit' => 'Credit'];
        $mappingTypes = [
            'inventory' => 'Inventory',
            'revenue' => 'Revenue',
            'expense' => 'Expense',
            'asset' => 'Asset',
            'liability' => 'Liability',
        ];
        return view('admin.accounting.mappings.create-account', compact('directions', 'mappingTypes'));
    }

    public function storeAccountMapping(StoreAccountMappingRequest $request): RedirectResponse
    {
        $this->accountMappingRepository->create($request->validated());
        return redirect()->route('admin.accounting.mappings.index')
            ->with('success', 'Account mapping created successfully.');
    }

    public function createJournalMapping(): View
    {
        $transactionTypes = [
            'goods_receipt' => 'Goods Receipt',
            'supplier_return' => 'Supplier Return',
            'material_issue' => 'Material Issue',
            'finished_goods_receipt' => 'Finished Goods Receipt',
            'inventory_adjustment' => 'Inventory Adjustment',
            'shipment' => 'Shipment',
            'sales_invoice' => 'Sales Invoice',
            'credit_memo' => 'Credit Memo',
            'debit_memo' => 'Debit Memo',
        ];
        return view('admin.accounting.mappings.create-journal', compact('transactionTypes'));
    }

    public function storeJournalMapping(StoreJournalMappingRequest $request): RedirectResponse
    {
        $this->journalMappingRepository->create($request->validated());
        return redirect()->route('admin.accounting.mappings.index')
            ->with('success', 'Journal mapping created successfully.');
    }

    public function editJournalMapping(JournalMapping $journalMapping): View
    {
        $transactionTypes = [
            'goods_receipt' => 'Goods Receipt',
            'supplier_return' => 'Supplier Return',
            'material_issue' => 'Material Issue',
            'finished_goods_receipt' => 'Finished Goods Receipt',
            'inventory_adjustment' => 'Inventory Adjustment',
            'shipment' => 'Shipment',
            'sales_invoice' => 'Sales Invoice',
            'credit_memo' => 'Credit Memo',
            'debit_memo' => 'Debit Memo',
        ];
        return view('admin.accounting.mappings.edit-journal', compact('journalMapping', 'transactionTypes'));
    }

    public function updateJournalMapping(StoreJournalMappingRequest $request, JournalMapping $journalMapping): RedirectResponse
    {
        $journalMapping->update($request->validated());
        return redirect()->route('admin.accounting.mappings.index')
            ->with('success', 'Journal mapping updated successfully.');
    }

    public function editAccountMapping(AccountMapping $accountMapping): View
    {
        $directions = ['debit' => 'Debit', 'credit' => 'Credit'];
        $mappingTypes = [
            'inventory' => 'Inventory',
            'revenue' => 'Revenue',
            'expense' => 'Expense',
            'asset' => 'Asset',
            'liability' => 'Liability',
        ];
        return view('admin.accounting.mappings.edit-account', compact('accountMapping', 'directions', 'mappingTypes'));
    }

    public function updateAccountMapping(StoreAccountMappingRequest $request, AccountMapping $accountMapping): RedirectResponse
    {
        $accountMapping->update($request->validated());
        return redirect()->route('admin.accounting.mappings.index')
            ->with('success', 'Account mapping updated successfully.');
    }
}
