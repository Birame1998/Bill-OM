<?php
namespace App\Models;

use Spatie\Permission\Traits\HasRoles;
use ErrorException;
use Spatie\Permission\Models\Role;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use App\Models\GestionStructure\Structure;
use Illuminate\Database\Eloquent\Collection;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nom', 'prenom', 'email', 'password', 'structure_id', 'login_windows', 'is_active', 'created_by', 'tentative', 'date_login',
        'date_debut_interim', 'date_fin_interim', 'role_base'
    ];

    public function structure()
    {
        return $this->belongsTo(Structure::class);
    }



    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];


    // allows to use "User::notRole('x')" to get users that don't have role x
    public function scopeNotRole(Builder $query, $roles, $guard = null): Builder
    {
         if ($roles instanceof Collection) {
             $roles = $roles->all();
         }

         if (! is_array($roles)) {
             $roles = [$roles];
         }

         $roles = array_map(function ($role) use ($guard) {
             if ($role instanceof Role) {
                 return $role;
             }

             $method = is_numeric($role) ? 'findById' : 'findByName';
             $guard = $guard ?: $this->getDefaultGuardName();

             return $this->getRoleClass()->{$method}($role, $guard);
         }, $roles);

         return $query->whereHas('roles', function ($query) use ($roles) {
             $query->where(function ($query) use ($roles) {
                 foreach ($roles as $role) {
                     $query->where(config('permission.table_names.roles').'.id', '!=' , $role->id);
                 }
             });
         });
    }
}
