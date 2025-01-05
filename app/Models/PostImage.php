<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class PostImage extends Model
{
    use HasFactory, Notifiable, HasUuids;

    public $incrementing = false;

    protected $table = 'post_images';

    protected $primaryKey = 'post_image_id';

    public const CREATED_AT = 'created_at';

    public const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'post_image_id',
        'post_image_url',
        'profile_id',
        'post_id',
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
            $model->post_image_id = (string) Str::uuid();
        });
    }
}
