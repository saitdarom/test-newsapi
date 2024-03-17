<?php

namespace App\Services\ApiExternal\Responses;



class  EResponseValidate extends \Exception
{
    public static function notFound($name){
        return new self($name.' not found');
    }
}
