<?php

namespace App\Http\Controllers\Admin;

use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\DataDasar\PermissionRepository;
use App\Repositories\DataDasar\RoleRepository;

class HakAksesController extends Controller
{
    private $role;
    private $permission;

    public function __construct(RoleRepository $role, PermissionRepository $permission)
    {
        $this->role = $role;
        $this->permission = $permission;
    }

    public function index()
    {
        $roles = $this->role->get();
        return view('admin.hak_akses.index', compact('roles'));
    }

    public function edit($id)
    {
        $permissions = $this->permission->get();
        $role = $this->role->findBy('id', '=', $id, ['*'], ['permissions']);
        return view('admin.hak_akses.edit', compact('permissions', 'role'));
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $role = $this->role->findBy('id', '=', $id, ['*'], ['permissions']);
            $role->permissions()->detach();
            $role->permissions()->attach($request->permissions);

            DB::commit();

            return redirect()->route('admin.hak_akses.index')
                ->with(['success' => 'Hak Akses berhasil disimpan']);
        } catch (\Exception $e) {
            DB::rollback();
            return reidrect()->back();
        }
    }
}
