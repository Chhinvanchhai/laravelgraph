<?php

namespace App\Models;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

final class Post extends Model
{
    use  HasFactory;
    protected $fillable = [
        'title',
        'content',
        'author_id'
    ];
    protected static function boot()
    {
        parent::boot();

        self::creating(function (Post $post): void {
            if ($post->author_id === null) {
                $user = auth()->user();
                if ($user === null) {
                    throw new AuthenticationException();
                }
                assert($user instanceof User);

                $post->author_id = $user->id;
            }
        });
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
