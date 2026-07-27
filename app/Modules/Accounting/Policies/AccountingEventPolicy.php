<?php

namespace Modules\Accounting\Policies;

use App\Models\User;
use Modules\Accounting\Models\AccountingEvent;

class AccountingEventPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('accounting-event-view');
    }

    public function view(User $user, AccountingEvent $event): bool
    {
        return $user->can('accounting-event-view');
    }

    public function create(User $user): bool
    {
        return $user->can('accounting-event-view');
    }

    public function post(User $user, AccountingEvent $event): bool
    {
        return $user->can('accounting-event-post');
    }

    public function cancel(User $user, AccountingEvent $event): bool
    {
        return $user->can('accounting-event-post');
    }

    public function repost(User $user, AccountingEvent $event): bool
    {
        return $user->can('accounting-event-post');
    }
}
