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
        if (config('app.env') === 'development') {
            $this->call(TestUserSeeder::class);
        }

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
