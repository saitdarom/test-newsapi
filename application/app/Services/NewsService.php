<?php

namespace App\Services;

use App\DTO\Requests\NewsRequestDTO;
use App\Models\News;
use App\Models\Source;
use App\Repositories\NewsRepository;
use App\Repositories\SourceRepository;
use App\Services\ApiExternal\ApiNews;
use App\Services\ApiExternal\Requests\News\EverythingRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NewsService
{
    public function __construct(
        private NewsRepository $newsRepository,
        private SourceRepository $sourceRepository,
        private ApiNews $apiNews
    ) {
    }

    public function addNewsByQueryViaApi(string $query): void
    {
        $page = 1;
        $pages = 2;

        while ($page <= $pages) {
            $response = $this->apiNews->everything(new EverythingRequest($query, $page));
            if (!$response->isServerOK()) {
                dd("Problem request: ", $response->getServerStatus(),$response->getServerBody());
                return;
            }

            $pages = $response->getPagesCount();

            foreach ($response->getDTO() as $item) {
                if (!$this->newsRepository->findByUrl($item->newsDTO->url)) {
                    $source = $this->sourceRepository->firstOrCreate($item->sourceDTO);
                    $this->newsRepository->create($source, $item->newsDTO);
                }
            }
            $page++;
        }
    }
}
