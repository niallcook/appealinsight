<?php

use \App\Models\Decision;
use \App\Models\DecisionType;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDecisionTypesTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'decision_types';

    /**
     * Run the migrations.
     * @table decision_types
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->id();
            $table->bigInteger('decision_id')->unsigned();
            $table->string('name', 50)->unique();

            $table->foreign('decision_id')
                ->references('id')
                ->on('decisions')
                ->onDelete('CASCADE')
                ->onUpdate('CASCADE');
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
