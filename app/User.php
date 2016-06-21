<?php
namespace App;

use App\Models\Acl\Role as Role;
use App\Models\Acl\Group as Group;
use App\Models\Acl\Permission as Permission;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Auth\Authenticatable;
use Illuminate\Foundation\Auth\Access\Authorizable;

use Signes\Acl\UserInterface as UserInterface;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;


// use Illuminate\Auth\Passwords\CanResetPassword;
// use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, AuthorizableContract, UserInterface
{
    use Authenticatable, Authorizable;

    /**
     * Get all of the owning delegation models.
     */
    public function delegation()
    {
        return $this->morphTo();
    }

    /**
     * User personal permissions
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function getPermissions()
    {
        return $this->belongsToMany(
            "{$this->namespace}\\Models\\Acl\\Permission",
            'acl_user_permissions',
            'user_id',
            'permission_id'
        )->withPivot('actions')->withTimestamps();
    }

    /**
     * Get user roles
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function getRoles()
    {
        return $this->belongsToMany(
            "{$this->namespace}\\Models\\Acl\\Role",
            'acl_user_roles',
            'user_id',
            'role_id'
        )->withTimestamps();
    }

    /**
     * Get user group
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function getGroup()
    {
        return $this->hasOne("{$this->namespace}\\Models\\Acl\\Group", 'id', 'group_id');
    }


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
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
     * Application namespace
     *
     * @var string
     */
    protected $namespace = "App";

    /**
     * This mutator automatically hashes the password.
     *
     * @var string
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = \Hash::make($value);
    }

}
