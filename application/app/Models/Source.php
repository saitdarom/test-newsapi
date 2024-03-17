<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'source_id',
    ];

    public function getId():int
    {
        return $this->id;
    }

    public function news(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(News::class);
    }

    public function scopeFindBySourceId($query, $source_id)
    {
        return $query->where('source_id', $source_id)->first();
    }

    public function scopeFindByName($query, $name)
    {
        return $query->where('name', $name)->first();
    }
}
