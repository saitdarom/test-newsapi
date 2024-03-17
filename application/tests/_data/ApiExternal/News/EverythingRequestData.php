<?php

namespace Tests\_data\ApiExternal\News;

use App\Services\ApiExternal\ApiExternalResponse;
use App\Services\ApiExternal\Responses\News\EverythingResponse;

class EverythingRequestData
{
    public static function payloadV1(string $query, int $page): array
    {
        return ['q' => $query, 'page' => $page, 'language' => 'ru', 'sortBy' => 'publishedAt', 'searchIn' => 'title'];
    }

    public static function responseV1(): EverythingResponse
    {
        return new EverythingResponse(new ApiExternalResponse(200,[],[],[],'',[]));
    }
}
