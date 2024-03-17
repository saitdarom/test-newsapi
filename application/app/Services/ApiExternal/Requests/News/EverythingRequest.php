<?php

namespace App\Services\ApiExternal\Requests\News;

use App\Services\ApiExternal\enums\Methods;
use App\Services\ApiExternal\Responses\News\EverythingResponse;

class EverythingRequest extends ANewsRequest
{
    protected string $url = "/v2/everything";
    protected Methods $method = Methods::GET;
    protected string $responseClass = EverythingResponse::class;

    public function __construct(
        private string $q,
        private int $page
    ) {
        parent::__construct();
    }

    protected function setPayload(): void
    {
        $this->payload = ['language' => 'ru', 'sortBy' => 'publishedAt', 'searchIn' => 'title'];
        $this->addPayloadValue('q', $this->q)
            ->addPayloadValue('page', $this->page);
    }
}
