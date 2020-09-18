<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class prog_test extends Model
{
    protected $fillable = [
        'title', 'url', 'content', 'summary', 'article_ts', 'published_date'
    ];
}
