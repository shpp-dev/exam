<?php

use Illuminate\Database\Seeder;

class TestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            DB::table('users')->insert([
                'id' => 1,
                'account_id' => 1,
                'email' => 'test@email.com',
                'exam_datetime' => null,
                'exam_location' => null,
                'check_location' => false
            ]);
        } catch (\Exception $exception) {
            //
        }
    }
}
