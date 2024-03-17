<?php

namespace App\Services\ApiExternal\Requests;

use App\Services\ApiExternal\enums\Formats;
use App\Services\ApiExternal\enums\Methods;
use App\Services\ApiExternal\Responses\AResponse;
use Illuminate\Support\Arr;

abstract class  ARequest implements IRequest
{
    protected string $contract = 'https://wiki.***/x/wZeDAw';
    protected string $jsonAPI = 'https://wiki.***/x/tUo6Ag';

    protected array $headers = [];
    protected Methods $method = Methods::GET;
    protected Formats $format = Formats::json;
    protected string $host = 'https://***.***';
    protected string $url = '/test';
    protected array $payload = [];
    protected string $responseClass = AResponse::class;

    /** Необходимо для случев выполнения через QUEUE, если ответ нужен для дальнейшего процесса. В этом классе описываем логику, которую необходимо выполнить после получения ответа.
     *  App\Services\ApiExternal\Listeners\AListener
     * В коструктор передается класс AResponse, объявленный выше.
     */
    protected ?string $listenerClass = null;//AListener::class;
    protected int $timeout = 60;
    protected int $connectionTimeout = 60;
    protected int $readyTimeout = 60;
    private bool $isValid = true;
    private bool $isSkip = false;

    public function __construct()
    {
        try {
            $this->validate();
            $this->setAuth();
            $this->setPayload();
        } catch (ERequestSkip $e) {
            $this->isSkip = true;
        } catch (ERequestValidate $e) {
            //log
            $this->isValid = false;
        }

    }

    protected function validate(): void
    {

    }

    abstract protected function setPayload(): void;

    public function getPayload(): array
    {
        return $this->payload;
    }

    public function getMethod(): Methods
    {
        return $this->method;
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getHeaders(): array
    {
        if (!isset($this->headers['content-type']) && $this->getFormat() == Formats::json)
            $this->addHeader('content-type', 'application/json');
        if (!isset($this->headers['content-type']) && $this->getFormat() == Formats::form)
            $this->addHeader('content-type', 'application/x-www-form-urlencoded');
        return $this->headers;
    }

    public function isValid(): bool
    {
        return $this->isValid;
    }

    public function isSkip(): bool
    {
        return $this->isSkip;
    }

    public function getTimeout(): int
    {
        return $this->timeout;
    }

    public function getConnectTimeout(): int
    {
        return $this->connectionTimeout;
    }

    public function getReadTimeout(): int
    {
        return $this->readyTimeout;
    }

    public function getResponseClass(): string
    {
        return $this->responseClass;
    }

    public function getListenerClass(): ?string
    {
        return $this->listenerClass;
    }

    public function getFormat(): Formats
    {
        return $this->format;
    }

    protected function addHeader(string $name, string $value): self
    {
        $this->headers[$name] = $value;
        return $this;
    }

    protected function addPayloadValue(string $key, mixed $value): self
    {
        Arr::set($this->payload, $key, $value);
        return $this;
    }

    protected function setAuth(): void
    {

    }

    public function getSHA1():string
    {
        return sha1(json_encode($this->getPayload()));
    }


}
