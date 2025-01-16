<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Blog extends Model
{
    use HasFactory;

    protected $table = 'blogs';

    protected $with = [
        'creator',
        'image'
    ];

    protected $fillable = [
        'title',
        'body',
        'creator_id'
    ];

    /**
     * Get the creator that owns the Blog
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'creator_id',
            'id'
        );
    }

    /**
     * Blog's Image
     *
     * @return MorphOne
     */
    public function image() :MorphOne
    {
        return $this->morphOne(
            Image::class,
            'owns',
            'image_type',
            'image_id',
            'id'
        );
    }

    /**
     * Blog's Comment
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    // Blog.php
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }   

}
