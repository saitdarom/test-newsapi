<?php


namespace App\Services;
use App\Models\Source;

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
