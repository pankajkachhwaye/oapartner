<?php

use Illuminate\Database\Seeder;

class TranscationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('transcation_fees')->insert([
            'transcation_fee' => '0.50',
            'created_at' => \Carbon\Carbon::now(),

        ]);
    }
}
