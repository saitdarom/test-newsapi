<?php


namespace App\Services;
use App\Models\News;
use App\Models\Source;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NewsService
{

    public function list(Request $request):\Illuminate\Pagination\LengthAwarePaginator
    {
        $news = News::query();
        if ($request->has('title'))
            $news->searchByTitle($request->input('title'));
        if ($request->has('name'))
            $news->searchBySourceName($request->input('name'));
        if ($request->has('to'))
            $news->searchByDateTo(Carbon::parse($request->input('to')));
        if ($request->has('from'))
            $news->searchByDateFrom(Carbon::parse($request->input('from')));


        $news = $news->paginate(100);
        $news->load('source');
        return $news;
    }

    public function store(Source $source, array $data):News
    {
        $news = News::findByUrl($data['url']);
        if ($news->exists()) return $news;
        $data['source_id'] = $source->id;
        return News::create( $data);
    }

}
