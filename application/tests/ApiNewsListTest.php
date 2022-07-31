<?php

namespace Tests;

use App\Exceptions\Parser\Licence;
use App\Services\NewsService;
use App\Services\Parsers\NewsApi\NewsApiParser;
use Carbon\Carbon;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class ApiNewsListTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic test example.
     *
     * @return void
     */


    public function test()
    {
        $parser = new NewsApiParser();
        $newsService = new NewsService();

        //Отлов ошибки лицензии
        try{
            foreach ($parser->getNewItemsByQuery('Bitcoin') as $item) $newsService->store($item);
        }catch (Licence $e){}


        $this->getByTitle();
        $this->getByTitle_fail();
        $this->getBySourceName();
        $this->getBySourceName_fail();
        $this->getByDateFrom();
        $this->getByDateFrom_fail();
        $this->getByDateTo();
        $this->getByDateTo_fail();
        $this->getByALL();
    }

    private function getByTitle()
    {
        $response = $this->call('GET', '/api/news', ['title' => 'bitcoin']);
        $this->assertEquals(200, $response->status());

    }

    private function getByTitle_fail()
    {
        $response = $this->call('GET', '/api/news', ['title' => 'bi']);
        $this->assertEquals(422, $response->status());
    }

    private function getBySourceName()
    {
        $response = $this->call('GET', '/api/news', ['source' => 'bitcoin']);
        $this->assertEquals(200, $response->status());

    }

    private function getBySourceName_fail()
    {
        $response = $this->call('GET', '/api/news', ['source' => 'bi']);
        $this->assertEquals(422, $response->status());
    }

    private function getByDateFrom()
    {
        $response = $this->call('GET', '/api/news', [
            'from' => Carbon::now()->addDays(-4)->toAtomString(),
        ]);
        $this->assertEquals(200, $response->status());

    }

    private function getByDateFrom_fail()
    {
        $response = $this->call('GET', '/api/news', [
            'from' => Carbon::now()->addDays(-4)->toIso8601ZuluString(),
        ]);
        $this->assertEquals(422, $response->status());

    }

    private function getByDateTo()
    {
        $response = $this->call('GET', '/api/news', [
            'to' => Carbon::now()->addDays(-4)->toAtomString(),
        ]);
        $this->assertEquals(200, $response->status());

    }

    private function getByDateTo_fail()
    {
        $response = $this->call('GET', '/api/news', [
            'to' => Carbon::now()->addDays(-4)->toIso8601ZuluString(),
        ]);
        $this->assertEquals(422, $response->status());

    }

    private function getByALL()
    {
        $response = $this->call('GET', '/api/news', [
            'to' => Carbon::now()->addDays(-4)->toAtomString(),
            'from' => Carbon::now()->addDays(-3)->toAtomString(),
            'title' => 'sdfsfs',
            'source' => 'sfsf',
        ]);
        $this->assertEquals(200, $response->status());

    }
}
