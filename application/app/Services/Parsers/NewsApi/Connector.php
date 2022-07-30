<?php


namespace App\Services\Parsers\NewsApi;


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
        return $this->get('/everything',$params);
    }


    public function get(string $url, array $arr = [])
    {
        $url = $this->url . $url;
        if ($arr)
            $url .= '?' . http_build_query($arr);

        $ch = curl_init( $url);

        $headers[] = "Accept: application/json";
        $headers[] = "X-Api-Key: " . $this->key;
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = json_decode(curl_exec($ch));
        curl_close($ch);

        if($result->status=='error'){
//            var_dump($result);
            /*@TODO обработка ошибок. Пока часто по лицензии ошибка.*/
            return null;
        }

        return $result;
    }
}
