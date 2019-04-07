<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Init extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('meals', function (Blueprint $table) {
            $table->char('id', 26)->nullable(false);
            $table->string('title')->nullable(false);
            $table->float('protein')->nullable(false);
            $table->float('fat')->nullable(false);
            $table->float('carbohydrates')->nullable(false);
            $table->float('fiber')->nullable(false);
            $table->char('user_id', 26)->nullable(false);

            $table->timestamps();

            $table->primary('id');
            $table->index('user_id');
        });

        Schema::create('days', function (Blueprint $table) {
            $table->char('id', 26)->nullable(false);
            $table->char('user_id', 26)->nullable(false);
            $table->date('date')->nullable(false);
            $table->integer('protein')->nullable(false);
            $table->integer('fat')->nullable(false);
            $table->integer('carbohydrates')->nullable(false);
            $table->integer('fiber')->nullable(false);
            $table->integer('weight')->nullable(false);
            $table->integer('protein_eaten')->nullable(false);
            $table->integer('fat_eaten')->nullable(false);
            $table->integer('carbohydrates_eaten')->nullable(false);
            $table->integer('fiber_eaten')->nullable(false);
            $table->integer('weight_eaten')->nullable(false);

            $table->timestamps();

            $table->primary('id');
            $table->index('user_id');
        });

        Schema::create('portions', function (Blueprint $table) {
            $table->char('id', 26)->nullable(false);
            $table->char('day_id', 26)->nullable(false);
            $table->char('meal_id', 26)->nullable(false);
            $table->char('user_id', 26)->nullable(false);
            $table->integer('protein')->nullable(false);
            $table->integer('fat')->nullable(false);
            $table->integer('carbohydrates')->nullable(false);
            $table->integer('fiber')->nullable(false);
            $table->integer('weight')->nullable(false);
            $table->boolean('eaten')->nullable(false);
            $table->time('time_plan')->nullable();
            $table->time('time_eaten')->nullable();

            $table->timestamps();

            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::drop('meals');
        Schema::drop('days');
        Schema::drop('portions');
    }
}
