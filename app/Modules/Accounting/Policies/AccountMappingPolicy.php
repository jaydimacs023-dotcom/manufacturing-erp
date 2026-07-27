<?php

namespace Modules\Accounting\Policies;

use App\Models\User;
use Modules\Accounting\Models\AccountMapping;

class AccountMappingPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('accounting-event-view');
    }

    public function view(User $user, AccountMapping $mapping): bool
    {
        return $user->can('accounting-event-view');
    }

    public function create(User $user): bool
    {
        return $user->can('accounting-event-post');
    }

    public function update(User $user, AccountMapping $mapping): bool
    {
        return $user->can('accounting-event-post');
    }

    public function delete(User $user, AccountMapping $mapping): bool
    {
        return $user->can('accounting-event-post');
    }
}
