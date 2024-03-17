<?php

namespace App\Repositories;

use App\DTO\Requests\NewsRequestDTO;
use App\DTO\NewsDTO;
use App\Models\News;
use App\Models\Source;
use Carbon\Carbon;

class NewsRepository implements INewsRepository
{
    public function listWithPaginator(NewsRequestDTO $dto):\Illuminate\Pagination\LengthAwarePaginator
    {
        $news = News::query();
        if ($dto->title)
            $news->searchByTitle($dto->title);
        if ($dto->source)
            $news->searchBySourceName($dto->source);
        if ($dto->to)
            $news->searchByDateTo($dto->to);
        if ($dto->from)
            $news->searchByDateFrom($dto->from);

        $news = $news->paginate(100);
        $news->load('source');
        return $news;
    }

    public function findByUrl(string $url):?News
    {
        /** @var News */
        return News::query()->where('url', $url)->first();
    }

    public function create(Source $source, NewsDTO $newsDTO):News
    {
        return News::create([
            "author"=>$newsDTO->author,
            "title"=>$newsDTO->title,
            "description"=>$newsDTO->description,
            "url"=>$newsDTO->url,
            "url_to_image"=>$newsDTO->urlToImage,
            "published_at"=>$newsDTO->publishedAt,
            "content"=>$newsDTO->content,
            "source_id"=>$source->getId(),
        ]);
    }

}
