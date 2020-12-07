<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;

    /**
     * Admin role id.
     * 
     * @var int
     */
    public const ROLE_ADMIN = 'Admin';

    /**
     * Puskesmas role id.
     * 
     * @var int
     */
    public const ROLE_PUSKESMAS = 'Puskesmas';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role_name'
    ];

    public function hasPermission($permission)
    {
        if ($this->role_name == 'Admin') return true;

        foreach ($this->permissions as $value) {
            if ($permission == $value->permission_name) {
                return true;
            }
        }

        return false;
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_role', 'role_id', 'permission_id');
    }
}
