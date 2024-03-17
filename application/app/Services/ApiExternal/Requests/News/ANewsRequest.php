<?php

namespace App\Services\ApiExternal\Requests\News;

use App\Services\ApiExternal\ApiAutoStat;
use App\Services\ApiExternal\enums\Methods;
use App\Services\ApiExternal\Requests\ARequest;
use App\Services\ApiExternal\Requests\ERequestValidate;

abstract class ANewsRequest extends ARequest
{
    public function __construct()
    {
        $this->host = 'https://newsapi.org';
        $this->addHeader('X-Api-Key',config('newsapi.key'));

        parent::__construct();
    }


}
