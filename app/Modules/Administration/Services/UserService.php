<?php

namespace Modules\Administration\Services;

use App\Models\User;
use App\Services\NumberSeriesService;
use Illuminate\Support\Facades\Hash;
use Modules\Administration\Repositories\UserRepository;

class UserService
{
    public function __construct(
        protected UserRepository $userRepository,
        protected NumberSeriesService $numberSeriesService,
    ) {}

    public function getPaginated(int $perPage = 15)
    {
        return $this->userRepository->paginate($perPage);
    }

    public function findById(int $id): ?User
    {
        return $this->userRepository->find($id);
    }

    public function create(array $data): User
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        return $this->userRepository->create($data);
    }

    public function update(User $user, array $data): bool
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        return $this->userRepository->update($user, $data);
    }

    public function delete(User $user): bool
    {
        return $this->userRepository->delete($user);
    }

    public function toggleActive(User $user): bool
    {
        return $this->userRepository->update($user, [
            'is_active' => !$user->is_active,
        ]);
    }

    public function generateTemporaryPassword(): string
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*';
        return substr(str_shuffle($chars), 0, 12);
    }
}

