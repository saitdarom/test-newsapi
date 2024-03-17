<?php

namespace Tests\Unit\ApiExternal\News;

use App\Services\ApiExternal\ApiNews;
use App\Services\ApiExternal\enums\Methods;
use App\Services\ApiExternal\Requests\News\EverythingRequest;
use App\Services\ApiExternal\Responses\News\EverythingResponse;
use Illuminate\Support\Facades\Cache;
use Tests\_data\ApiExternal\News\EverythingRequestData;
use Tests\_data\ApiExternal\News\Headers;
use Tests\TestCase;

class NewsApiEverythingRequestTest extends TestCase
{
    public function testNewsApiEverythingRequestReturnHeaders(): void
    {
        $this->assertEquals(Headers::combinationV1(), $this->getRequest()->getHeaders());
    }

    public function testNewsApiEverythingRequestReturnPayload(): void
    {
        $this->assertEquals(EverythingRequestData::payloadV1('query', 2), $this->getRequest()->getPayload());
    }

    public function testNewsApiEverythingRequestReturnMethod(): void
    {
        $this->assertEquals(Methods::GET, $this->getRequest()->getMethod());
    }

    public function testNewsApiEverythingRequestReturnResponseClass(): void
    {
        $this->assertEquals(EverythingResponse::class, $this->getRequest()->getResponseClass());
    }

    public function testSend(): void
    {
        Cache::flush();
        $mock = \Mockery::mock(ApiNews::class)->makePartial();
        $mock->shouldReceive('request')
            ->withArgs([EverythingRequest::class])
            ->andReturn(EverythingRequestData::responseV1())
            ->once();

        $mock->everything(new EverythingRequest('page', 2));
    }

    private function getRequest(): EverythingRequest
    {
        return new EverythingRequest('query', 2);
    }
}
