<?php

namespace App\Services\ApiExternal\Responses;

/** Возвращает данные как есть */
class ProxyResponse extends AResponse
{
    public function getPayload(): array
    {
        return $this->response->getPayload();
    }
}
