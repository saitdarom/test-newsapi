<?php


namespace App\Services;
use App\Http\Requests\Api\News\ListRequest;
use App\Models\News;
use App\Models\Source;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class NewsService
{

    public function list(Request $request)
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

    public function store(array $data)
    {
        $news = News::findByUrl($data['news']['url']);
        if ($news->exists()) return $news;


        DB::beginTransaction();
        if ($data['source']['source_id'])
            $source = Source::findBySourceId($data['source']['source_id']);
        else
            $source = Source::findByName($data['source']['name']);
        if (!$source->exists()) $source = Source::create($data['source']);

        $data['news']['source_id'] = $source->id;
        $news = News::create( $data['news']);
        DB::commit();

        return $news;
    }

}
