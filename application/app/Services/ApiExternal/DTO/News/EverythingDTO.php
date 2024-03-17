<?php

namespace App\Services\ApiExternal\DTO\News;

use App\DTO\NewsDTO;
use App\DTO\SourceDTO;

class EverythingDTO
{
    public function __construct(
        public NewsDTO $newsDTO,
        public SourceDTO $sourceDTO
    )
    {

    }
}
