<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Resources\stores\AdminResource;
use App\Models\Admin;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
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

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required',
            'roles' => 'nullable|array',
        ]);

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

        return $admin->load('roles');
    }

    public function show(string $id)
    {
        return AdminResource::make(Admin::with('roles')->findOrFail($id));
    }

    public function update(Request $request, Admin $admin)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'nullable',
            'roles' => 'nullable|array',
        ]);


        $admin->update($data);

        if (isset($data['roles'])) {
            $admin->syncRoles($data['roles']);
        }

        return $admin->load('roles');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin)
    {
        Gate::authorize('delete-admins');
        $admin->delete();
    }
}
