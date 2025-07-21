<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\Gender;
use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements HasMedia, FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    use HasRoles;
    use HasPanelShield;


    use InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'gender',
        'phone',
        'codeforces_handle',
        'atcoder_handle',
        'vjudge_handle',
        'starting_semester',
        'department',
        'student_id',
        'max_cf_rating',

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

    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class, 'team_user', 'user_id', 'team_id');
    }

    public function rankLists(): BelongsToMany
    {
        return $this->belongsToMany(RankList::class, 'rank_list_user', 'user_id', 'rank_list_id')
            ->withPivot('score');
    }

    public function attendedEvents(): BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'event_user_attendance', 'user_id', 'event_id')->withTimestamps();
    }

    public function solveStats(): User|HasMany
    {
        return $this->hasMany(UserSolveStatOnEvent::class, 'user_id', 'id');
    }

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
            'gender' => Gender::class,
        ];
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this
            ->addMediaConversion('preview')
            ->fit(Fit::Contain, 300, 300)
            ->queued();
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('avatar')
            ->useFallbackUrl(asset('images/anonymous-user.webp'))
            ->useFallbackPath(public_path('images/anonymous-user.webp'));
    }
}
