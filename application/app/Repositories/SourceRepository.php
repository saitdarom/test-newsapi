<?php

namespace App\Repositories;

use App\DTO\Requests\NewsRequestDTO;
use App\DTO\NewsDTO;
use App\DTO\SourceDTO;
use App\Models\News;
use App\Models\Source;

class SourceRepository implements ISourceRepository
{
    public function firstOrCreate(SourceDTO $sourcesDTO): Source
    {
        if ($sourcesDTO->sourceId) {
            $source = Source::findBySourceId($sourcesDTO->sourceId);
        } else {
            $source = Source::findByName($sourcesDTO->name);
        }
        if (!$source->exists()) {
            $source = Source::create([
                'source_id' => $sourcesDTO->sourceId,
                'name' => $sourcesDTO->name,
            ]);
        }
        return $source;
    }
}
