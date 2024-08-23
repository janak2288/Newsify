<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'source_id',
        'title',
        'news_url',
        'thumbnail_url',
        'news_overview',
        'published_date',
    ];

    public function source()
    {
        return $this->belongsTo(Source::class);
    }
}
