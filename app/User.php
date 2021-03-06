<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user', 'password', 'email', 'foto_usuario', 'privilegio_id', 'remember_token', 'status'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * Check the rol of the current user.
     *
     */
    public function privilegios() 
    {
        return $this->hasOne('App\Privilegio', 'id', 'privilegio_id');
    }

    /**
     * Check the rol of the current user.
     *
     */
    public function role() 
    {
        return $this->hasOne('App\Role', 'id', 'role_id');
    }
    
    /**
     * Check the role of the current user.
     *
     */
    public function checkRole($roles)
    {
        foreach ($roles as $role) {
            if ($this->role->rol == $role) {
                return true;
            }
        }
        return false;
    }

    /**
     * Check the rol of the current user.
     *
     */
    static function validar_username($name, $name_old = false)
    {
        $query = User::where('user', $name);

        $query = $name_old ? $query->where('user', '!=', $name_old) : $query;

        return $query->get();  
    }
}
