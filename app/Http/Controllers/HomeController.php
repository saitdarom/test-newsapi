<?php

namespace App\Http\Controllers;

use App\Jobs\GetNewsJob;
use App\Models\News;
use App\Models\Source;
use App\Services\Parsers\NewsApi\NewsApiParser;
use Event;
use App\Events\GetNewsEvent;

class HomeController extends Controller
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

    public function index(){


//        Event::dispatch(new GetNewsEvent([]));
        dispatch(new GetNewsJob(new NewsApiParser()));

        dd(News::with('source')->get()->toArray(),Source::all()->toArray());

//        event(new GetNewsByTitleEvent(''));

        die;
        return view('home');
    }

    //
}
