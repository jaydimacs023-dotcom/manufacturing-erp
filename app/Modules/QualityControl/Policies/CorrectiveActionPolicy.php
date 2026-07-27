<?php

namespace Modules\QualityControl\Policies;

use App\Models\User;
use Modules\QualityControl\Models\CorrectiveAction;

class CorrectiveActionPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('corrective-action-view');
    }

    public function view(User $user, CorrectiveAction $ca): bool
    {
        return $user->can('corrective-action-view');
    }

    public function create(User $user): bool
    {
        return $user->can('corrective-action-create');
    }

    public function update(User $user, CorrectiveAction $ca): bool
    {
        return $user->can('corrective-action-create');
    }

    public function complete(User $user, CorrectiveAction $ca): bool
    {
        return $user->can('corrective-action-create');
    }

    public function approve(User $user, CorrectiveAction $ca): bool
    {
        return $user->can('inspection-approve');
    }

    public function delete(User $user, CorrectiveAction $ca): bool
    {
        return $user->can('corrective-action-create');
    }
}

