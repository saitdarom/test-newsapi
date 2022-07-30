<?php

namespace App\Http\Controllers;

use App\Jobs\GetNewsJob;
use App\Models\News;
use App\Models\Source;
use App\Services\Parsers\NewsApi\NewsApiParser;
use Event;

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


//        dd('end');
//
//
////        Event::dispatch(new GetNewsEvent([]));
////        dispatch(new GetNewsJob(new NewsApiParser()));
////
////        dd(News::with('source')->get()->toArray(),Source::all()->toArray());
//
////        event(new GetNewsByTitleEvent(''));
//
//
//        $email='d@ffd.ru.dsf@s';
//        $str='/[a-z0-9\-_]*@[a-z0-9\-_]*.[a-z0-9\-_]{2,}/';
//
//
//        $str='/[a-z0-9\-_]+@[a-z0-9\-_]+.[a-z0-9\-_]{2,}/';
//
//        $str='/([a-z0-9_-]+\.)*[a-z0-9_-]+@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.[a-z]{2,6}/';
//
//        dd(preg_match($str, $email));
//
//        die;
        return view('home');
    }




    //
}
