<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\News\ListRequest;
use App\Http\Resources\News\ListResource;
use App\Jobs\GetNewsJob;
use App\Models\News;
use App\Services\NewsService;
use Carbon\Carbon;
use Event;
use App\Events\GetNewsEvent;
use Illuminate\Http\Request;


class NewsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }


    /**
     * @todo по хорошему нужно сделать авторизацию. Проверка доступа через middleware в маршрутах.
     *
     * @param Request $request
     * @param NewsService $service
     * @return ListResource
     * @throws \Illuminate\Validation\ValidationException
     */
    public function list(Request $request, NewsService $service)
    {
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

        $news = $service->list($request);
        return new ListResource($news);
    }

    //
}
