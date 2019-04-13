<?php

use App\Api\Models\Day;
use App\Api\Models\Portion;
use App\Api\Models\Meal;
use App\Api\Models\User;
use Carbon\Carbon;
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
        /** @var User $user */
        $user = factory(User::class)->create(['email' => 'user@kntrl8.com']);
        $date = Carbon::now()->subDays(4);
        for ($i = 1; $i <= 7; $i++) {
            /** @var Day $day */
            $day = factory(Day::class)->create([
                'user_id' => $user->id,
                'date' => $date->addDay()->format('Y-m-d')
            ]);
            factory(Meal::class, 15)->create(['user_id' => $user->id])
                ->each(function (Meal $meal) use ($user, $day) {
                    factory(Portion::class)->create([
                        'user_id' => $user->id,
                        'day_id' => $day->id,
                        'meal_id' => $meal->id
                    ]);
                });
        }
    }
}
