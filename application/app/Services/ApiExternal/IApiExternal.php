<?php

namespace App\Services\ApiExternal;

use App\Services\ApiExternal\Requests\IRequest;
use App\Services\ApiExternal\Responses\IResponse;

interface IApiExternal
{
    public function request(IRequest $request):?IResponse;

    public function requestViaQUEUE(IRequest $request): void;
}
