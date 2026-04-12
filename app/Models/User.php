<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\SystemSettingsModel\ManageRolesModel;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $table = 'users';
    protected $fillable = [
        'id',
        'fname',
        'mname',
        'lname',
        'fullname',
        'email',
        'password',
        'user_role',
        'area_code',
        'department_id',
        'organization_id',
        'is_approved',
        'is_admin',
        'remember_token',
        'created_at',
        'updated_at',
        'deleted_at',
        'activated_at',
        'last_login',
        'verification_code',
        'verification_created_at',
        'password_reset_at',
        'created_user_id',
        'deleted_user_id',
        'activated_user_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function adminlte_profile_url()
    {
    // If this is a named route:
    return route('MyAccount_pagination');

    // Or if it’s a plain URL, use:
    // return url('MyAccount_pagination');
    }

    public function adminlte_image()
    {
    // 1) If you have an avatar column in your users table:
    // return $this->avatar ? asset('storage/' . $this->avatar) : asset('images/default-avatar.png');

    // 2) Or just use a single default image for everyone:
    return asset('images/landing/user1-128x128.jpg');
    }
    /**
     * Role relation - map user's `user_role` string to `tbl_roles.name`.
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(ManageRolesModel::class, 'user_role', 'name');
    }

    /**
     * Resolve the user's role name (prefer relation, fallback to `user_role` string).
     */
    public function getRoleName(): ?string
    {
        if ($this->relationLoaded('role') && $this->role) {
            return $this->role->name;
        }
        if ($this->role) {
            return $this->role->name;
        }
        return $this->user_role ?? null;
    }

    /**
     * Check if the user has the given role or any of given roles.
     *
     * @param  string|array  $roles
     * @return bool
     */
    public function hasRole($roles): bool
    {
        $rolesArray = is_array($roles) ? $roles : preg_split('/[|,]/', (string) $roles);
        $name = $this->getRoleName();
        if (! $name) {
            return false;
        }
        foreach ($rolesArray as $r) {
            if (trim($r) === $name) {
                return true;
            }
        }
        return false;
    }

    public function hasAnyRole($roles): bool
    {
        return $this->hasRole($roles);
    }
}
