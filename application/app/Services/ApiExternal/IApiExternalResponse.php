<?php

namespace App\Services\ApiExternal;

use App\Services\ApiExternal\Requests\IRequest;
use App\Services\ApiExternal\Responses\IResponse;

interface IApiExternalResponse
{
    public function getHeaders(): array;

    public function getPayload(): array;

    public function setPayload(array $payload): self;

    public function getStatus(): int;

    public function getHeadersRequest(): array;

    public function getUrlRequest(): string;

    public function getPayloadRequest(): array;

}
