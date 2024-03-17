<?php

namespace Tests\_data\ApiExternal\News;

class Headers
{
    public static function authV1(): array
    {
        return [
            'X-Api-Key' => config('newsapi.key'),
        ];
    }

    public static function contentTypeV1(): array
    {
        return [
            'content-type' => 'application/json',
        ];
    }

    public static function combinationV1(): array
    {
        return array_merge(self::authV1(),self::contentTypeV1());
    }
}
