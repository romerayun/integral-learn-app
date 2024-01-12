<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::orderBy('name')->where('name', '!=', 'super-user')->get();

        return view('manage.roles.index', compact([
            'roles',
        ]));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::orderBy('name')->get();

        return view('manage.roles.create', compact([
            'permissions'
        ]));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'color' => 'required',
            'name' => 'required|max:255',
            'permissions' => 'required',
            'permissions.*' => 'required|exists:permissions,id',
        ]);

        DB::beginTransaction();
        try {
            $newRole = Role::create([
                'name' => $request->name,
                'color' => $request->color
            ]);

            $permissions = Permission::whereIn('id', $request->permissions)->get();
            $newRole->syncPermissions($permissions);

            DB::commit();
            $request->session()->flash('success', 'Данные успешно добавлены 👍');
            return back();
        } catch (\Exception $exception) {
            DB::rollback();
            $request->session()->flash('error', 'При добавлении данных произошла ошибка 😢');
            return back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role = Role::where('name', '!=', 'super-user')->findOrFail($id);
        if (!$role) abort(404);
        $permissions = Permission::orderBy('name')->get();

        return view('manage.roles.edit', compact([
            'permissions',
            'role'
        ]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'color' => 'required',
            'name' => 'required|max:255',
            'permissions' => 'required',
            'permissions.*' => 'required|exists:permissions,id',
        ]);

        $role = Role::where('name', '!=', 'super-user')->findOrFail($id);

        DB::beginTransaction();
        try {

            $role->update([
                'name' => $request->name,
                'color' => $request->color
            ]);

            $permissions = Permission::whereIn('id', $request->permissions)->get();
            $role->syncPermissions($permissions);

            DB::commit();
            $request->session()->flash('success', 'Данные успешно обновлены 👍');
            return back();
        } catch (\Exception $exception) {
            DB::rollback();
            $request->session()->flash('error', 'При добавлении данных произошла ошибка 😢' . $exception);
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
