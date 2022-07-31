<?php


namespace App\Services\Parsers\NewsApi;


use App\Exceptions\Parser\Content;
use App\Exceptions\Parser\HttpStatus;
use App\Exceptions\Parser\Licence;
use Illuminate\Support\Facades\Http;
use Cache;
use Illuminate\Http\Client\Response;

class Connector
{
    private $key;
    private $url = 'https://newsapi.org/v2';

    public function __construct()
    {
        $this->key = config('newsapi.key');
    }

    public function everything(array $params = []):\stdClass
    {
        return $this->get('/everything', $params);
    }


    public function get(string $url, array $arr = []):\stdClass
    {
        //Кеш временное решение. Лицензии нет. Чтобы уменьшить вероятность проблемы.
        return Cache::remember('getnewsapi.' . md5($url) . md5(json_encode($arr)), 86400, function () use ($url, $arr) {
            $this->validateError($response = Http::acceptJson()->withHeaders(["Accept" => "application/json", "X-Api-Key" => $this->key])->get($this->url . $url, $arr));
            return $this->getJsonObj($response);
        });
    }

    /**
     * @throws Content
     */
    private function getJsonObj(Response $response):\stdClass
    {
        try {
            return json_decode($response->getBody());
        } catch (\Throwable $e) {
            throw new Content();
        }
    }

    /**
     * @throws Licence
     * @throws Content
     * @throws HttpStatus
     */
    private function validateError(Response $response):void
    {
        if ($response->status() !== 200)
            throw new HttpStatus();

        $result = $this->getJsonObj($response);
        if ($result->status == 'error')
            throw new Licence();
    }
}
