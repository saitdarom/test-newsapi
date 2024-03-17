<?php

namespace App\Services\ApiExternal\Listeners;

use App\Services\ApiExternal\Responses\IResponse;

abstract class AListener implements IListener
{
    public function __construct(
        readonly protected IResponse $response
    )
    {
        $this->run();
    }

    abstract protected function run():void;
}
