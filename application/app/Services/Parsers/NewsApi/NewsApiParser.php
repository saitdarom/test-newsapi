<?php


namespace App\Services\Parsers\NewsApi;

use App\Contracts\Parser;
use App\Models\News;
use Carbon\Carbon;

class NewsApiParser implements Parser
{
    private $connector;

    public function __construct()
    {
        $this->connector = new Connector();
    }

    /**
     * @param string $query
     * @return array|null
     */
    public function getNewItemsByQuery(string $query): array
    {
        $items = [];
        $page = 1;
        $pages = 2;

        while ($page <= $pages) {
            $result = $this->connector->everything(['q' => $query, 'language' => 'ru', 'sortBy' => 'publishedAt', 'searchIn' => 'title', 'page' => $page]);
            $pages = $this->getPagesCount($result->totalResults, count($result->articles));

            foreach ($result->articles as $item) {
                if (!News::findByUrl($item->url)->exists()) {
                    $items[] = $this->itemDTO($item);
                }
            }
            $page++;
        }
        return $items;
    }


    /**
     * @param string $query
     * @return array|null
     */
    public function getLastNewItemsByQuery(string $query): array
    {
        $items = [];
        $page = 1;
        $pages = 2;
        while ($page <= $pages) {
            $result = $this->connector->everything(['q' => $query, 'language' => 'ru', 'from' => Carbon::now()->addHours(-1)->toIso8601String(), 'sortBy' => 'publishedAt', 'searchIn' => 'title', 'page' => $page]);
            $pages = $this->getPagesCount($result->totalResults, count($result->articles));

            foreach ($result->articles as $item) {
                if (!News::findByUrl($item->url)->exists()) {
                    $items[] = $this->itemDTO($item);
                }
            }
            $page++;
        }
        return $items;
    }

    private function getPagesCount($total, $countForPage)
    {
        if (!$countForPage) return 1;
        return ceil($total / $countForPage);
    }

    private function itemDTO($item)
    {
        return [
            "source" => [
                'source_id' => $item->source->id,
                'name' => $item->source->name,
            ],
            'news'=>[
                "author" => $item->author,
                "title" => $item->title,
                "description" => $item->description,
                "url" => $item->url,
                "url_to_image" => $item->urlToImage,
                "published_at" => Carbon::parse($item->publishedAt),
                "content" => $item->content,
            ],
        ];
    }
}
