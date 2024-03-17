<?php

namespace App\Services\ApiExternal;


use App\Services\ApiExternal\Requests\News\EverythingRequest;
use App\Services\ApiExternal\Responses\AResponse;

use App\Services\ApiExternal\Responses\News\EverythingResponse;

use Illuminate\Support\Facades\Cache;

class ApiNews extends AApiExternal
{

    private function cache(string $key, callable $func):?AResponse
    {
        /** @var  AResponse $response*/
        $response = Cache::remember($key,  60 * 60,$func);
        if (!($response instanceof AResponse)) {
            throw new \Exception('ApiNews::cache. Awaits AResponse.');
        }
        if (!$response->isServerOK()) {
            Cache::delete($key);
            return $response;
        }
        return $response;
    }

    public function everything(EverythingRequest $everythingRequest): EverythingResponse
    {
        /** @var EverythingResponse  */
        return $this->cache("ApiNews2::everything".$everythingRequest->getSHA1(), function () use ($everythingRequest) {
            return $this->request($everythingRequest);
        });
    }
}
