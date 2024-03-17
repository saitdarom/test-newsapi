<?php

namespace App\Jobs;

use App\Exceptions\Parser\Licence;
use App\Services\NewsService;
use App\Services\Parsers\Parser;
use App\Services\SourceService;

class GetNewsJob extends Job
{
    private $setting;


    public function __construct()
    {
        $this->setting = config('parser.news');
    }


    public function handle(NewsService $newsService)
    {
        try {
            if (isset($this->setting['titles'])) {
                foreach ($this->setting['titles'] as $title) {
                    $newsService->addNewsByQueryViaApi($title);
                }
            }
        }catch (\Throwable $e){
            dd($e->getMessage().$e->getTraceAsString());
        }

    }
}
