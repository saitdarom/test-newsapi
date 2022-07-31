<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\News\ListResource;
use App\Services\NewsService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NewsController extends Controller
{

    public function list(Request $request, NewsService $service):ListResource
    {
        // https://lumen.laravel.com/docs/9.x/validation
        // По хорошему реквест/валидацию нужно выделить в отдельный класс.
        // В документации написано делать в контроллере, иначе использовать полную версию LARAVEL.
        $this->validate($request, [
            'source' => 'nullable|min:3',
            'from'   => 'nullable|date_format:' . \DateTimeInterface::ATOM,
            'to'     => 'nullable|date_format:' . \DateTimeInterface::ATOM,
            'title'  => 'nullable|min:3',
        ], [
            'from.date_format' => 'Возможно проблема с конвертацией символов. Неверно задано время. from - ATOM - '.Carbon::now()->toAtomString(),
            'to.date_format'   => 'Возможно проблема с конвертацией символов. Неверно задано время. to - ATOM - '.Carbon::now()->toAtomString(),
            'source.min'       => 'source минимум 3 символа',
            'title.min'        => 'title минимум 3 символа',
        ]);

        return new ListResource($service->list($request));
    }

}
