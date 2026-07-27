<?php

namespace Modules\QualityControl\Policies;

use App\Models\User;
use Modules\QualityControl\Models\QualityInspection;

class QualityInspectionPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('inspection-view');
    }

    public function view(User $user, QualityInspection $inspection): bool
    {
        return $user->can('inspection-view');
    }

    public function create(User $user): bool
    {
        return $user->can('inspection-create');
    }

    public function update(User $user, QualityInspection $inspection): bool
    {
        return $user->can('inspection-create') && in_array($inspection->status, ['draft']);
    }

    public function delete(User $user, QualityInspection $inspection): bool
    {
        return $user->can('inspection-create') && in_array($inspection->status, ['draft']);
    }

    public function approve(User $user, QualityInspection $inspection): bool
    {
        return $user->can('inspection-approve');
    }

    public function reject(User $user, QualityInspection $inspection): bool
    {
        return $user->can('inspection-approve');
    }
}

