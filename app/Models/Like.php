<?php

namespace App\Models;

use Database\Factories\PostFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class Like extends Model
{
    use HasFactory, Notifiable, HasUuids;

    public $incrementing = false;

    protected $table = 'likes';

    protected $primaryKey = 'like_id';

    public const CREATED_AT = 'created_at';

    public const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'like_id',
        'profile_id',
        'likeable_id',
        'likeable_type',
    ];

    protected $hidden = [
        'profile_id'
    ];

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
            $model->like_id = (string) Str::uuid();
        });
    }

    protected static function newFactory()
    {
    }

    public function likeable(): MorphTo
    {
        return $this->morphTo();
    }

}
