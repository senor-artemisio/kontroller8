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
        Schema::create('items', function (Blueprint $table) {
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

        Schema::create('day', function (Blueprint $table) {
            $table->char('id', 26)->nullable(false);
            $table->date('date')->nullable(false);
            $table->float('protein')->nullable(false);
            $table->float('fat')->nullable(false);
            $table->float('carbohydrates')->nullable(false);
            $table->float('fiber')->nullable(false);
            $table->float('weight')->nullable(false);
            $table->float('weight_eaten')->nullable(false);
            $table->char('user_id', 26)->nullable(false);

            $table->timestamps();

            $table->primary('id');
            $table->index('user_id');
        });

        Schema::create('day_items', function (Blueprint $table) {
            $table->primary('id');
            $table->char('day_id', 26);
            $table->float('protein')->nullable(false);
            $table->float('fat')->nullable(false);
            $table->float('carbohydrates')->nullable(false);
            $table->float('fiber')->nullable(false);
            $table->float('weight')->nullable(false);
            $table->float('weight_eaten')->nullable(false);
            $table->boolean('eaten')->nullable(false);
            $table->time('eat_before')->nullable();

            $table->primary('id');
            $table->primary('day_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::drop('items');
        Schema::drop('day');
        Schema::drop('day_items');
    }
}
