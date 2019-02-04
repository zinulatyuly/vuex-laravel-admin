<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormDepartmentTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_department_types', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('department_id');
            $table->string('type');
            $table->timestamps();

            $table->foreign('department_id')
                ->references('id')
                ->on('form_departments')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('form_department_types');
    }
}
