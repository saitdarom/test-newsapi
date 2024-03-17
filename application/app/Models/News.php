<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        "author",
        "title",
        "description",
        "url",
        "url_to_image",
        "published_at",
        "content",
        "source_id",
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];



    /////////////////////////////// scopes /////////////////////////////////////
    public function scopeFindByUrl($query, $url)
    {
        return $query->where('url', $url);
    }

    public function scopeSearchByTitle($query, $title)
    {
        return $query->where('title', 'ILIKE', '%' . $title . '%');
    }

    public function scopeSearchBySourceName($query, $name)
    {
        return $query->join('sources', function ($join) use ($name) {
            $join->on('sources.id', '=', 'news.source_id')
                ->where('sources.name', 'ILIKE', "%" . $name . "%");
        });
    }

    public function scopeSearchByDateFrom($query, Carbon $date)
    {
        return $query->where('published_at', '>=', $date);
    }

    public function scopeSearchByDateTo($query, Carbon $date)
    {
        return $query->where('published_at', '<=', $date);
    }
    /////////////////////////////// scopes /////////////////////////////////////


    /////////////////////////////// relations /////////////////////////////////////
    public function source(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Source::class);
    }
    /////////////////////////////// relations /////////////////////////////////////

}
