<?php

namespace Modules\Administration\Repositories;

use App\Models\User;
use App\Repositories\BaseRepository;

class UserRepository extends BaseRepository
{
    protected function modelClass(): string
    {
        return User::class;
    }

    public function findActive()
    {
        return $this->model->where('is_active', true)->get();
    }

    public function findByEmail(string $email): ?User
    {
        return $this->model->where('email', $email)->first();
    }

    public function findLocked()
    {
        return $this->model->where('is_locked', true)->get();
    }
}

