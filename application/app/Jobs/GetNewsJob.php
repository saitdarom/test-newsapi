<?php

namespace App\Jobs;

use App\Exceptions\Parser\Licence;
use App\Services\NewsService;
use App\Services\Parsers\Parser;
use App\Services\SourceService;

class GetNewsJob extends Job
{
    private $parser;
    private $newsService;
    private $sourceService;
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
        $this->sourceService = new SourceService();
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
                try {
                    foreach ($this->parser->getNewItemsByQuery($title) as $item) {
                        $this->newsService->store($this->sourceService->store($item['source']), $item['news']);
                    }
                } catch (Licence $e) {
                }
            }
    }
}
