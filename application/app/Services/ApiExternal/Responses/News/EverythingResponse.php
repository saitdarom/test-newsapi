<?php

namespace App\Services\ApiExternal\Responses\News;

use App\DTO\NewsDTO;
use App\DTO\SourceDTO;
use App\Services\ApiExternal\DTO\News\EverythingDTO;
use App\Services\ApiExternal\Responses\AResponse;
use Carbon\Carbon;

class EverythingResponse extends AResponse
{
    /**
     * @return \App\Services\ApiExternal\DTO\News\EverythingDTO[]
     */
    private array $dto = [];

    protected function setData(): void
    {
        foreach ($this->getByPath('articles') ?? [] as $item) {
            $this->dto[] = new EverythingDTO(
                new NewsDTO(
                    $item['author'] ?? '',
                    $item['title'] ?? '',
                    $item['description'] ?? '',
                    $item['url'] ?? '',
                    $item['urlToImage'] ?? '',
                    Carbon::parse($item['publishedAt'] ?? ''),
                    $item['content'] ?? '',
                ),
                new SourceDTO(
                    $item['source_id']['id'] ?? '',
                    $item['source']['name'] ?? '',
                ),
            );
        }
    }

    public function getPagesCount():int
    {
        $count = (int) $this->getByPath('articles');
        if (!$count) {
            return 0;
        }
        return ceil((int) $this->getByPath('totalResults') / $count);
    }

    /**
     * @return \App\Services\ApiExternal\DTO\News\EverythingDTO[]
     */
    public function getDTO(): array
    {
        return $this->dto;
    }
}
