<?php

namespace App\Services\ApiExternal;

use App\Services\ApiExternal\enums\Formats;
use App\Services\ApiExternal\enums\Methods;
use App\Services\ApiExternal\Requests\IRequest;
use App\Services\ApiExternal\Responses\IResponse;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\RequestOptions;


abstract class AApiExternal implements IApiExternal
{
    public function request(IRequest $request): ?IResponse
    {
        $client = new Client([
            'base_uri' => $request->getHost(),
            'verify' => false,
        ]);
        $RequestOptions = [
            RequestOptions::TIMEOUT => $request->getTimeout(),
            RequestOptions::CONNECT_TIMEOUT => $request->getReadTimeout(),
            RequestOptions::READ_TIMEOUT => $request->getConnectTimeout(),
            RequestOptions::HEADERS => $request->getHeaders(),
        ];

        if ($request->getMethod() == Methods::GET) $RequestOptions[RequestOptions::QUERY] = $request->getPayload();
        else if ($request->getFormat() == Formats::form) $RequestOptions[RequestOptions::FORM_PARAMS] = $request->getPayload();
        else if ($request->getFormat() == Formats::json) $RequestOptions[RequestOptions::JSON] = $request->getPayload();

        try {
            $response = $client->request($request->getMethod()->name, $request->getUrl(), $RequestOptions);
        } catch (BadResponseException $e){
            dd("Problem request: ",$RequestOptions, $request,$e->getResponse()->getStatusCode(),$e->getResponse()->getBody()->getContents());

            $ApiExternalResponse = new ApiExternalResponse(
                $e->getResponse()->getStatusCode(),
                $e->getResponse()->getHeaders(),
                ['err'=>$e->getResponse()->getBody()->getContents()],
                $request->getHeaders(),
                $request->getHost() . $request->getUrl(),
                $request->getPayload()
            );
        }catch (\Throwable $e) {
            $ApiExternalResponse = new ApiExternalResponse(
                9999,
                [],
                ['errINTERIOR'=>$e->getMessage().$e->getTraceAsString()],
                $request->getHeaders(),
                $request->getHost() . $request->getUrl(),
                $request->getPayload()
            );
        }

        if(!isset($ApiExternalResponse)){
            try {
                $payload = json_decode((string)$response->getBody(), 1);
            } catch (\Throwable $e) {
                $ApiExternalResponse = new ApiExternalResponse(
                    9999,
                    [],
                    ['errINTERIOR'=>$e->getMessage().$e->getTraceAsString()],
                    $request->getHeaders(),
                    $request->getHost() . $request->getUrl(),
                    $request->getPayload()
                );
            }
        }



        if(!isset($ApiExternalResponse)){
            $ApiExternalResponse = new ApiExternalResponse(
                $response->getStatusCode(),
                $response->getHeaders(),
                $payload,
                $request->getHeaders(),
                $request->getHost() . $request->getUrl(),
                $request->getPayload()
            );
        }


        /** @var IResponse $responseClass */
        $responseClass = $request->getResponseClass();
        return new $responseClass($ApiExternalResponse);
    }


    public function requestViaQUEUE(IRequest $request): void
    {
        //отправка через очередь. Ответ должен обработать Lestener
    }
}
