<?php

namespace Modules\BusinessPartner\Policies;

use App\Models\User;
use Modules\BusinessPartner\Models\ContactPerson;

class ContactPersonPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('business-partner-view');
    }

    public function view(User $user, ContactPerson $contactPerson): bool
    {
        return $user->can('business-partner-view');
    }

    public function create(User $user): bool
    {
        return $user->can('business-partner-create');
    }

    public function update(User $user, ContactPerson $contactPerson): bool
    {
        return $user->can('business-partner-update');
    }

    public function delete(User $user, ContactPerson $contactPerson): bool
    {
        return $user->can('business-partner-delete');
    }
}

