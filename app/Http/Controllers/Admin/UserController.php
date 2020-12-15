<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\User\UserRepository;
use App\Repositories\Organisasi\UnitKerjaRepository;

class UserController extends Controller
{
    /**
     * User Repository.
     *
     * @var UserRepository
     */
    private $user;

    /**
     * Unit Kerja Repository.
     *
     * @var UnitKerjaRepository
     */
    private $unitKerja;

    /**
     * Constructor.
     * 
     */
    public function __construct(UserRepository $user, UnitKerjaRepository $unitKerja)
    {
        $this->user = $user;
        $this->unitKerja = $unitKerja;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $where = function ($query) {
            $query->where('id', '<>', Auth::user()->id);
        };
        $users = $this->user->get(['*'], $where, ['role', 'unitKerja']);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $unitKerja = $this->unitKerja->get();
        return view('admin.users.create', compact('unitKerja'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'username' => 'nullable|unique:users,username',
            'email' => 'required_without:username|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'unit_kerja' => 'nullable|string',
            'role' => 'required'
        ]);

        $user = $this->user->create([
            'name'                  => $request->nama,
            'username'              => $request->username,
            'email'                 => $request->email,
            'password'              => Hash::make($request->password),
            'kode_unit_kerja'       => $request->unit_kerja,
            'role_id'               => $request->role,
            'status'                => 'MURNI',
            'status_anggaran_id'    => 1
        ]);

        return redirect()->route('admin.users.index')
                ->with(['success' => "{$user->name} berhasil ditambahkan"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = $this->user->find($id);
        $unitKerja = $this->unitKerja->get();
        return view('admin.users.edit', compact('user', 'unitKerja'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        $user = Auth::user();
        $unitKerja = $this->unitKerja->get();
        return view('admin.users.edit_profile', compact('user', 'unitKerja'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string',
            'username' => 'nullable|unique:users,username,'.$id,
            'email' => 'required_without:username|unique:users,email,'.$id,
            'unit_kerja' => 'nullable|string',
            'role' => 'required'
        ]);

        $user = $this->user->update([
            'name' => $request->nama,
            'username' => $request->username,
            'email' => $request->email,
            'kode_unit_kerja' => $request->unit_kerja,
            'role_id' => $request->role,
            'status' => 'MURNI'
        ], $id);

        return redirect()->route('admin.users.index')
                ->with(['success' => "Pengguna berhasil disimpan"]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function profileUpdate(Request $request)
    {
        $id = Auth::user()->id;
        $request->validate([
            'nama' => 'required|string',
            'username' => 'nullable|unique:users,username,'.$id,
            'email' => 'required_without:username|unique:users,email,'.$id,
            'unit_kerja' => 'nullable|string',
            'role' => 'required'
        ]);

        $user = $this->user->update([
            'name' => $request->nama,
            'username' => $request->username,
            'email' => $request->email,
            'kode_unit_kerja' => $request->unit_kerja,
            'role_id' => $request->role,
            'status' => 'MURNI'
        ], $id);

        return redirect()->route('admin.users.update_profile')
                ->with(['success' => "Pengguna berhasil disimpan"]);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed',
        ]);

        $user = $this->user->update([
            'password' => Hash::make($request->password),
        ], $id);

        return redirect()->route('admin.users.index')
                ->with(['success' => "Password pengguna berhasil disimpan"]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function profilePassword(Request $request)
    {
        $id = Auth::user()->id;
        $request->validate([
            'password' => 'required|min:6|confirmed',
        ]);

        $user = $this->user->update([
            'password' => Hash::make($request->password),
        ], $id);

        return redirect()->route('admin.users.profile')
                ->with(['success' => "Password pengguna berhasil disimpan"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $this->user->delete($request->id);
        return redirect()->back()
                ->with(['success' => 'Pengguna berhasil dihapus']);
    }
}
