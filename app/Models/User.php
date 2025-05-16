<?php

namespace App\Models;

use App\Enums\UserRole;
use Illuminate\Support\Arr;
use App\Models\Traits\Searchable;
use Laravel\Passport\HasApiTokens;
use Database\Factories\UserFactory;
use Illuminate\Support\Facades\Mail;
use Illuminate\Notifications\Notifiable;
use Modules\Auth\Mail\PasswordResetMail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @method static UserFactory factory()
 */
final class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Searchable, Notifiable;

    protected $fillable = [
        'role',
        'email',
        'username',
        'password',
        'has_accepted_terms',
    ];

    private $searchable = [
        'email',
        'username',
    ];

    protected $casts = [
        'role' => UserRole::class,
        'has_accepted_terms' => 'boolean',
    ];

    public function hasRole(UserRole ...$role): bool
    {
        return in_array($this->role, $role, true);
    }

    public function scopeRole(Builder $query, UserRole | array $roles): Builder
    {
        return $query->whereIn('users.role', Arr::wrap($roles));
    }

    public function sendPasswordResetNotification($token): void
    {
        Mail::to($this->email)->queue(new PasswordResetMail($this->email, $token));
    }

    public function client(): HasOne
    {
        return $this->hasOne(Client::class);
    }

    public function worker(): HasOne
    {
        return $this->hasOne(Worker::class);
    }

    public function contact(): HasOne
    {
        return $this->hasOne(Contact::class);
    }

    public function files(): HasMany
    {
        return $this->hasMany(File::class);
    }
}
