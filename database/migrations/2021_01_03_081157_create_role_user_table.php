<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoleUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_user', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('role_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->timestamps();

            $table->foreignId('user_id')->constrained();
            $table->foreignId('role_id')->constrained();
        });

        $current_date_time = date('Y-m-d H:i:s');

        DB::table('role_user')->insert(
            array(
                'role_id' => 1,
                'user_id' => 1,
                'created_at'=> $current_date_time,
                'updated_at'=> $current_date_time
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_user');
    }
}
