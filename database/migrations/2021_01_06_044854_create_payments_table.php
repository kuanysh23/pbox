<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('amount',10,2);
            $table->tinyInteger('status')->nullable();//null - не открывали ссылку, 0 - открывали, 1 - успешно, 2 - ошибка
            $table->timestamp('date_paid')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('card')->nullable();
            $table->string('link')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
