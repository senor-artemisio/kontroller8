<?php

use Illuminate\Database\Seeder;

/**
 * Dummy data seeder
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = factory(\App\Api\Models\User::class)->create(['email' => 'user@kntrl8.com']);

        factory(\App\Api\Models\Item::class, 53)->create(['user_id' => $user->id]);

    }
}
