<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class News extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'title',
        'description',
        'user_id',
        'slug',
        'content',
        'published_at',];

    protected $dates = [
        'published_at',
    ];
    
    public function publishedBy()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
