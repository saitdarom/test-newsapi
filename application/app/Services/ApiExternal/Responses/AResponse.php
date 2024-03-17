<?php

namespace App\Services\ApiExternal\Responses;

use App\Services\ApiExternal\ApiExternalResponse;
use App\Services\ApiExternal\IApiExternalResponse;
use App\Services\helpers\Log;
use Illuminate\Support\Arr;
use yii\helpers\ArrayHelper;

abstract class AResponse implements IResponse
{
    protected bool $isValid = true;
    protected bool $isSkip = false;
    protected string $serverTextError = '';
    protected int $serverStstus = 200;
    protected bool $isServerOK = true;

    final function __construct(readonly protected IApiExternalResponse $response)
    {
        try {
            $this->validate();
            $this->setData();
        } catch (EResponseSkip $e) {
            $this->isSkip = true;
        } catch (EResponseValidate $e) {
            //log
            $this->isValid = false;
        }
    }

    protected function validate(): void
    {
    }

    protected function setData(): void
    {
    }

    protected function getByPath(string $key): mixed
    {
        return Arr::get($this->response->getPayload(), $key);
    }

    protected function existByPath(string $key): bool
    {
        if ($this->getByPath($key) !== null) {
            return true;
        }
        return false;
    }

    protected function validateExistByPath(array $arrKey): void
    {
        foreach ($arrKey as $key) {
            if (!$this->existByPath($key)) {
                throw EResponseValidate::notFound($key);
            }
        }
    }



    public function isValid(): bool
    {
        return $this->isValid;
    }

    public function isSkip(): bool
    {
        return $this->isSkip;
    }

    public function isServerOK(): bool
    {
        if($this->response->getStatus()!==200) return false;
        return true;
    }

    public function getServerStatus(): int
    {
        return $this->response->getStatus();
    }

    public function getServerBody(): string
    {
        return json_encode($this->response->getPayload());
    }
}
