<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'password', 'kode_unit_kerja', 'status', 'role_id', 'status_anggaran_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Check user role.
     *
     * @param string $name
     * @return boolean
     */
    public function hasRole($name)
    {
        $role = Role::where('role_name', $name)->first();
        if (! $role) return false;

        return $this->role->id === $role->id;
    }

    /**
     * Check user permission
     *
     * @param string $permission
     * @return boolean
     */
    public function hasPermission($permission)
    {
        if ($this->hasRole('Admin')) return true;

        foreach ($this->role->permissions as $value) {
            if ($permission == $value->permission_name) {
                return true;
            }
        }

        return false;
    }

    /**
     * Role relationship.
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function unitKerja()
    {
        return $this->belongsTo('App\Models\UnitKerja', 'kode_unit_kerja', 'kode');
    }

    public function statusAnggaran()
    {
        return $this->belongsTo('App\Models\StatusAnggaran', 'status_anggaran_id', 'id');
    }
}
