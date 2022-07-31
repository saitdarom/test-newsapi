<?php

namespace Database\Seeders;

use App\Services\NewsService;
use App\Services\Parsers\NewsApi\NewsApiParser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call('UsersTableSeeder');

//        $service=new NewsApiParser();
//        dd($service->getNewItemsByQuery('Bitcoin'));
    }
}
