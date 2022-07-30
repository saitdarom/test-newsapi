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
    public function getNewsItemByQuery(string $query): ?array
    {
        $page = 1;
        while (1) {
            if (!$result = $this->connector->everything(['q' => $query, 'language' => 'ru', 'sortBy' => 'publishedAt', 'searchIn' => 'title', 'page' => $page])) break;
            foreach ($result->articles as $item) {
                if (!News::findByUrl($item->url)->exists()) {
                    return [
                        "source"       => [
                            'source_id' => $item->source->id,
                            'name'      => $item->source->name,
                        ],
                        "author"       => $item->author,
                        "title"        => $item->title,
                        "description"  => $item->description,
                        "url"          => $item->url,
                        "url_to_image" => $item->urlToImage,
                        "published_at" => Carbon::parse($item->publishedAt),
                        "content"      => $item->content,
                    ];
                }
            }
            $page++;
        }
        return null;
    }
}
