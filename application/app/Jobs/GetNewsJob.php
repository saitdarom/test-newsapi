<?php

namespace App\Jobs;

use App\Contracts\Parser;
use App\Events\GetNewsEvent;
use App\Models\News;
use App\Services\NewsService;
use App\Services\Parsers\NewsApi\NewsApiParser;

class GetNewsJob extends Job
{
    private $parser;
    private $newsService;
    private $setting;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Parser $parser, array $setting = [])
    {
        $this->parser = $parser;
        $this->newsService = new NewsService();
        $this->setting = array_merge(config('parser.news'), $setting);
    }


    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (isset($this->setting['titles']))
            foreach ($this->setting['titles'] as $title) {
                foreach ($this->parser->getNewItemsByQuery($title) as $item) {
                    $this->newsService->store($item);
                }
            }
    }
}
