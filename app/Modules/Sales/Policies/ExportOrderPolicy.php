<?php

namespace Modules\Sales\Policies;

use App\Models\User;
use Modules\Sales\Models\ExportOrder;

class ExportOrderPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('export-order-view');
    }

    public function view(User $user, ExportOrder $exportOrder): bool
    {
        return $user->can('export-order-view');
    }

    public function create(User $user): bool
    {
        return $user->can('export-order-create');
    }

    public function update(User $user, ExportOrder $exportOrder): bool
    {
        return $user->can('export-order-update');
    }

    public function delete(User $user, ExportOrder $exportOrder): bool
    {
        return $user->can('export-order-update');
    }

    public function approve(User $user, ExportOrder $exportOrder): bool
    {
        return $user->can('export-order-approve');
    }

    public function cancel(User $user, ExportOrder $exportOrder): bool
    {
        return $user->can('export-order-update');
    }
}

