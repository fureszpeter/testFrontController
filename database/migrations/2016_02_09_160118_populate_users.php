<?php

use Illuminate\Database\Migrations\Migration;

class PopulateUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $fields = [
            'id',
            'name',
            'email',
            'password',
        ];

        $data = [
            [
                1,
                'Test User 1',
                'test_1@example.com',
                'secret',
            ],
            [
                2,
                'Test User 2',
                'test_2@example.com',
                'secret',
            ],
            [
                3,
                'Test User 3',
                'test_3@example.com',
                'secret',
            ],
        ];

        foreach ($data as $userArray) {
            DB::table('users')->insert(
                array_combine($fields, $userArray)
            );
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('users')->delete();
    }
}
