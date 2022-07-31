<?php


namespace App\Services;
use App\Http\Requests\Api\News\ListRequest;
use App\Models\News;
use App\Models\Source;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class SourceService
{
    public function store(array $data):Source
    {
        if ($data['source_id'])
            $source = Source::findBySourceId($data['source_id']);
        else
            $source = Source::findByName($data['name']);
        if (!$source->exists()) $source = Source::create($data);
        return $source;
    }
}
