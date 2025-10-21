<?php

namespace App\Http\Controllers\Api\Dashboards\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Admin\AdminRequest;
use App\Http\Resources\stores\AdminResource;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Throwable;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $data = $request->validate([
            'search' => 'nullable|string',
            'per_page' => 'nullable|integer',
            'is_active' => 'nullable|in:true,false',
        ]);

        $query = Admin::with('roles');

        if (array_key_exists('is_active', $data)) {
            $query->where('is_active', filter_var($data['is_active'], FILTER_VALIDATE_BOOLEAN));
        }

        if (isset($data['search'])) {
            $query->whereLike('name', '%' . $data['search'] . '%')
                ->orWhereLike('email', '%' . $data['search'] . '%');
        }

        $result = $query->paginate($data['per_page'] ?? 15);

        return $this->successResponse(
            __('fetched successfully'),
            $result->through(fn($admin) => new AdminResource($admin))
        );
    }
    public function show(string $id)
    {
        return $this->successResponse(
            __('fetched successfully'),
            AdminResource::make(Admin::with('roles')->findOrFail($id)),
            200
        );
    }
    public function store(AdminRequest $request)
    {
        $data = $request->validated();

        DB::beginTransaction();
        try {
            $admin = Admin::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password']
            ]);
            if (isset($data['roles'])) {
                $admin->assignRole($data['roles']);
            }
            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }

        return $this->successResponse(
            __('created successfully'),
            new AdminResource($admin->load('roles')),
            201
        );
    }
    public function update(AdminRequest $request, Admin $admin)
    {
        $data = $request->validated();

        $admin->update($data);

        if (isset($data['roles'])) {
            $admin->syncRoles($data['roles']);
        }

        return $this->successResponse(
            __('updated successfully'),
            new AdminResource($admin->load('roles')),
            200
        );
    }
    public function destroy(Admin $admin)
    {
        $admin->delete();
        return $this->successResponse(
            __('deleted successfully'),
            [],
            200
        );
    }
}
