<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReasonsForTheAppealTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'reasons_for_the_appeal';

    /**
     * Run the migrations.
     * @table reasons_for_the_appeal
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down()
     {
       Schema::dropIfExists($this->tableName);
     }
}
