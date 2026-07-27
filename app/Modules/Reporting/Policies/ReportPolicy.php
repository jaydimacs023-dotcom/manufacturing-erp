<?php

namespace Modules\Reporting\Policies;

use App\Models\User;

class ReportPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('report-view') || $user->can('dashboard-view');
    }

    public function view(User $user): bool
    {
        return $user->can('report-view');
    }

    public function export(User $user): bool
    {
        return $user->can('report-export');
    }
}

