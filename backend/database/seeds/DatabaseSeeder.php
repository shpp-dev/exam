<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        switch (config('app.locale')) {
            case 'ru':
                $this->call(TasksSeederRU::class);
                break;
            case 'en':
            case 'ua':
                $this->call(TasksSeederUA::class);
                break;
        }
    }
}
