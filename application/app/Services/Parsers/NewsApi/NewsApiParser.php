<?php


namespace App\Services\Parsers\NewsApi;

use App\Models\News;
use App\Services\Parsers\Parser;
use Carbon\Carbon;

class NewsApiParser implements Parser
{
    private $connector;

    public function __construct()
    {
        $this->connector = new Connector();
    }


    public function getNewItemsByQuery(string $query, array $setting = []): array
    {
        $setting = array_merge(['language' => 'ru', 'sortBy' => 'publishedAt', 'searchIn' => 'title'], $setting);
        $items = [];
        $page = 1;
        $pages = 2;

        while ($page <= $pages) {
            $result = $this->connector->everything(array_merge($setting, ['q' => $query, 'page' => $page]));
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

    public function getLastNewItemsByQuery(string $query): array
    {
        return $this->getNewItemsByQuery($query, ['from' => Carbon::now()->addHours(-1)->toIso8601String()]);
    }

    private function getPagesCount(int $total, int $countForPage): int
    {
        if (!$countForPage) return 1;
        return ceil($total / $countForPage);
    }


    private function itemDTO(\stdClass $item): array
    {
        return [
            "source" => [
                'source_id' => $item->source->id,
                'name' => $item->source->name,
            ],
            'news' => [
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
