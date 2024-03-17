<?php

namespace App\Services\ApiExternal\Requests;

use App\Services\ApiExternal\enums\Formats;
use App\Services\ApiExternal\enums\Methods;
use App\Entity\Lead\CommonLead;
use App\Services\ApiExternal\ALKRequest;
use App\Utils\Phone\PhoneModelRU;
use App\DI;

interface  IRequest
{
    public function getMethod(): Methods;

    public function getPayload(): array;

    public function getHeaders(): array;

    public function getHost(): string;

    public function getUrl(): string;

    public function isValid():bool;
    public function isSkip():bool;

    public function getTimeout():int;
    public function getConnectTimeout():int;
    public function getReadTimeout():int;

    public function getResponseClass(): string;

    public function getListenerClass(): ?string;

    public function getSHA1(): string;

    public function getFormat():Formats;
}
