<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class,'owner_id');
    }


   public function tasks(): HasMany
    {
        return $this->hasMany(Task::class,'assigned_to');
    }


     public function projectMembers(): HasMany
    {
        return $this->hasMany(ProjectMember::class, 'user_id');
    }


     public function activity_logs(): HasMany
    {
        return $this->hasMany(ActivityLog::class,'users_id');
    }

       public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class,'users_id');
    }



    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'role',
        'profile_img',
    ];




    public function isAdmin(){
        return $this->role === 'admin';
    }


    public function isProjectLeader()
{
    return $this->projectMembers()->where('role', 'leader')->exists();
}



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
}
