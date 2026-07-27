<?php

namespace Modules\QualityControl\Policies;

use App\Models\User;
use Modules\QualityControl\Models\NonConformance;

class NonConformancePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('non-conformance-view');
    }

    public function view(User $user, NonConformance $nc): bool
    {
        return $user->can('non-conformance-view');
    }

    public function create(User $user): bool
    {
        return $user->can('non-conformance-create');
    }

    public function update(User $user, NonConformance $nc): bool
    {
        return $user->can('non-conformance-create');
    }

    public function resolve(User $user, NonConformance $nc): bool
    {
        return $user->can('non-conformance-create');
    }

    public function delete(User $user, NonConformance $nc): bool
    {
        return $user->can('non-conformance-create');
    }
}

