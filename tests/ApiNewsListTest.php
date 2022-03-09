<?php

namespace Tests;

use Carbon\Carbon;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class ApiNewsListTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_getByTitle()
    {
        $response = $this->call('GET', '/api/news', ['title' => 'bitcoin']);
        $this->assertEquals(200, $response->status());

    }

    public function test_getByTitle_fail()
    {
        $response = $this->call('GET', '/api/news', ['title' => 'bi']);
        $this->assertEquals(422, $response->status());
    }

    public function test_getBySourceName()
    {
        $response = $this->call('GET', '/api/news', ['source' => 'bitcoin']);
        $this->assertEquals(200, $response->status());

    }

    public function test_getBySourceName_fail()
    {
        $response = $this->call('GET', '/api/news', ['source' => 'bi']);
        $this->assertEquals(422, $response->status());
    }

    public function test_getByDateFrom()
    {
        $response = $this->call('GET', '/api/news', [
            'from'     => Carbon::now()->addDays(-4)->toAtomString(),
        ]);
        $this->assertEquals(200, $response->status());

    }

    public function test_getByDateFrom_fail()
    {
        $response = $this->call('GET', '/api/news', [
            'from'     => Carbon::now()->addDays(-4)->toIso8601ZuluString(),
        ]);
        $this->assertEquals(422, $response->status());

    }

    public function test_getByDateTo()
    {
        $response = $this->call('GET', '/api/news', [
            'to'     => Carbon::now()->addDays(-4)->toAtomString(),
        ]);
        $this->assertEquals(200, $response->status());

    }

    public function test_getByDateTo_fail()
    {
        $response = $this->call('GET', '/api/news', [
            'to'     => Carbon::now()->addDays(-4)->toIso8601ZuluString(),
        ]);
        $this->assertEquals(422, $response->status());

    }

    public function test_getByALL()
    {
        $response = $this->call('GET', '/api/news', [
            'to'     => Carbon::now()->addDays(-4)->toAtomString(),
            'from'   => Carbon::now()->addDays(-3)->toAtomString(),
            'title'   => 'sdfsfs',
            'source' => 'sfsf',
        ]);
        $this->assertEquals(200, $response->status());

    }
}
