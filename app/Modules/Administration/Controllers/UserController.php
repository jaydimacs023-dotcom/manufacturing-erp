<?php

namespace Modules\Administration\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Administration\Requests\StoreUserRequest;
use Modules\Administration\Requests\UpdateUserRequest;
use Modules\Administration\Services\BranchService;
use Modules\Administration\Services\DepartmentService;
use Modules\Administration\Services\RoleService;
use Modules\Administration\Services\UserService;

class UserController extends Controller
{
    public function __construct(
        protected UserService $userService,
        protected BranchService $branchService,
        protected DepartmentService $departmentService,
        protected RoleService $roleService,
    ) {}

    public function index(): View
    {
        $this->authorize('viewAny', User::class);
        $users = $this->userService->getPaginated();
        return view('admin.users.index', compact('users'));
    }

    public function create(): View
    {
        $this->authorize('create', User::class);
        $branches = $this->branchService->getActiveBranches();
        $departments = $this->departmentService->getActiveDepartments();
        $roles = $this->roleService->getAllRoles();
        return view('admin.users.create', compact('branches', 'departments', 'roles'));
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        $this->authorize('create', User::class);
        $data = $request->validated();
        $roles = $data['roles'] ?? [];
        unset($data['roles']);

        $user = $this->userService->create($data);

        if (!empty($roles)) {
            $user->syncRoles($roles);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    public function show(int $id): View
    {
        $user = $this->userService->findById($id);
        $this->authorize('view', $user);
        return view('admin.users.show', compact('user'));
    }

    public function edit(int $id): View
    {
        $user = $this->userService->findById($id);
        $this->authorize('update', $user);
        $branches = $this->branchService->getActiveBranches();
        $departments = $this->departmentService->getActiveDepartments();
        $roles = $this->roleService->getAllRoles();
        $userRoles = $user->roles->pluck('id')->toArray();
        return view('admin.users.edit', compact('user', 'branches', 'departments', 'roles', 'userRoles'));
    }

    public function update(UpdateUserRequest $request, int $id): RedirectResponse
    {
        $user = $this->userService->findById($id);
        $this->authorize('update', $user);
        $data = $request->validated();
        $roles = $data['roles'] ?? [];

        // Remove empty password
        if (empty($data['password'])) {
            unset($data['password']);
        }
        unset($data['roles']);

        $this->userService->update($user, $data);

        if (!empty($roles)) {
            $user->syncRoles($roles);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $user = $this->userService->findById($id);
        $this->authorize('delete', $user);
        $this->userService->delete($user);
        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }
}

