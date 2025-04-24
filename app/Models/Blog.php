<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'user_id',
        // Add other fillable fields as needed
    ];

    /**
     * Get the comments for the blog post.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get the users who liked this blog post.
     */
    public function likes(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'blog_likes', 'blog_id', 'user_id')->withTimestamps();
    }

    /**
     * Check if the blog post is liked by a specific user.
     * 
     * @param int $userId
     * @return bool
     */
    public function isLikedByUser(int $userId): bool
    {
        return $this->likes()->where('user_id', $userId)->exists();
    }

    /**
     * Toggle like for a user.
     * 
     * @param int $userId
     * @return array
     */
    public function toggleLike(int $userId): array
    {
        if ($this->isLikedByUser($userId)) {
            $this->likes()->detach($userId);
            $liked = false;
        } else {
            $this->likes()->attach($userId);
            $liked = true;
        }

        return [
            'liked' => $liked,
            'likesCount' => $this->likesCount()
        ];
    }

    /**
     * Get the count of likes for this blog post.
     * 
     * @return int
     */
    public function likesCount(): int
    {
        return $this->likes()->count();
    }
}