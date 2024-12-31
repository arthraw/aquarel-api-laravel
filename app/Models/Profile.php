<?php

namespace App\Models;

use Database\Factories\PostFactory;
use Database\Factories\ProfileFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class Profile extends Model
{

    use HasFactory, Notifiable, HasUuids;

    public $incrementing = false;

    protected $table = 'profiles';

    protected $primaryKey = 'profile_id';

    public const CREATED_AT = 'created_at';

    public const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'profile_id',
        'bio',
        'name',
        'user_id',
        'avatar_url',
        'banner_url',
        'instagram_profile_url',
        'behance_profile_url',
        'category',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'user_id',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->profile_id = (string) Str::uuid();
        });
    }

    protected static function newFactory(): ProfileFactory
    {
        return ProfileFactory::new();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'post_id', 'post_id');
    }
}
