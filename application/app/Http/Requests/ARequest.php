<?php

namespace App\Http\Requests;


use App\Http\Resources\Message422ByValidatorResponse;
use App\Http\Resources\Message422Response;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Request;

abstract class ARequest implements IRequest
{

    protected array $validationData=[];
    protected array $validationDescription=[];

    protected function setValidationData(): void
    {
    }

    protected function setValidationDescription(): void
    {
    }

    public function __construct()
    {
        try {
            $this->setValidationData();
            $this->setValidationDescription();
            $this->validateByValidationData();
            $this->validateAfter();
        } catch (ERequestValidate $e) {
            $this->sendErrorMessage('error', $e->getMessage());
        }
    }
    protected function validateByValidationData(): void
    {
        $validator = Validator::make(Request::all(), $this->validationData,$this->validationDescription);
        if($validator->fails()){
            throw new HttpResponseException(new Message422ByValidatorResponse($validator));
        }
    }

    protected function validateAfter(): void
    {
    }

    public function sendErrorMessage(string $name, string $message): void
    {
        throw new HttpResponseException(new Message422Response($name,$message));
    }
}
