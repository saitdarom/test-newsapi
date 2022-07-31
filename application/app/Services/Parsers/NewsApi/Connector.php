<?php


namespace App\Services\Parsers\NewsApi;


use App\Exceptions\Parser\HttpStatus;
use App\Exceptions\Parser\Licence;
use Illuminate\Support\Facades\Http;
use Cache;

class Connector
{
    private $key;
    private $url = 'https://newsapi.org/v2';

    public function __construct()
    {
        $this->key = config('newsapi.key');
    }

    public function everything(array $params = [])
    {
        return $this->get('/everything', $params);
    }


    public function get(string $url, array $arr = [])
    {
        //Кеш временное решение. Лицензии нет. Чтобы уменьшить вероятность проблемы.
        return Cache::remember('newsapi.' . md5($url) . md5(json_encode($arr)), 86400, function () use ($url, $arr) {
            $this->validateError($response = Http::acceptJson()->withHeaders(["Accept" => "application/json", "X-Api-Key" => $this->key])->get($this->url . $url, $arr));
            return json_decode($response->getBody());
        });
    }

    private function validateError($response)
    {
        try {
            $result = json_decode($response->getBody());
        } catch (\Throwable $e) {
            ///
        }

        if ($result->status == 'error')
            throw new Licence();

        if ($response->status() !== 200)
            throw new HttpStatus();
    }
}
