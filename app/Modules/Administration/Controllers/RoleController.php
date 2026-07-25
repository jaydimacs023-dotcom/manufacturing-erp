<?php

namespace Modules\Administration\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Modules\Administration\Requests\StoreRoleRequest;
use Modules\Administration\Requests\UpdateRoleRequest;
use Modules\Administration\Services\RoleService;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function __construct(
        protected RoleService $roleService,
    ) {}

    public function index(): View
    {
        $this->authorize('viewAny', Role::class);
        $roles = $this->roleService->getPaginated();
        return view('admin.roles.index', compact('roles'));
    }

    public function create(): View
    {
        $this->authorize('create', Role::class);
        $permissions = $this->roleService->getGroupedPermissions();
        return view('admin.roles.create', compact('permissions'));
    }

    public function store(StoreRoleRequest $request): RedirectResponse
    {
        $this->authorize('create', Role::class);
        $data = $request->validated();
        $permissions = $data['permissions'] ?? [];
        unset($data['permissions']);

        $this->roleService->create($data, $permissions);

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role created successfully.');
    }

    public function edit(int $id): View
    {
        $role = $this->roleService->findById($id);
        $this->authorize('update', $role);
        $permissions = $this->roleService->getGroupedPermissions();
        $rolePermissions = $role->permissions->pluck('id')->toArray();
        return view('admin.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(UpdateRoleRequest $request, int $id): RedirectResponse
    {
        $role = $this->roleService->findById($id);
        $this->authorize('update', $role);
        $data = $request->validated();
        $permissions = $data['permissions'] ?? [];
        unset($data['permissions']);

        $this->roleService->update($role, $data, $permissions);

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role updated successfully.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $role = $this->roleService->findById($id);
        $this->authorize('delete', $role);
        $this->roleService->delete($role);
        return redirect()->route('admin.roles.index')
            ->with('success', 'Role deleted successfully.');
    }
}

