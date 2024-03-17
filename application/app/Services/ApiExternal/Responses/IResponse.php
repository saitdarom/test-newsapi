<?php

namespace App\Services\ApiExternal\Responses;

use App\Services\ApiExternal\enums\Methods;
use App\Entity\Lead\CommonLead;
use App\Services\ApiExternal\ALKRequest;
use App\Utils\Phone\PhoneModelRU;
use App\DI;

interface  IResponse
{

    public function isValid():bool;
    public function isSkip():bool;

    public function isServerOK(): bool;

    public function getServerStatus(): int;

    public function getServerBody(): string;


}
