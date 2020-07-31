<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppealsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'appeals';

    /**
     * Run the migrations.
     * @table appeals
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->id();
            $table->integer('reference')->unique()->index();
            $table->date('received_date')->nullable();
            $table->date('valid_date')->nullable();
            $table->date('start_date')->nullable();
            $table->date('decision_date')->nullable();
            $table->bigInteger('appellant_id')->unsigned();
            $table->bigInteger('lpa_id')->unsigned();
            $table->bigInteger('inspector_id')->nullable()->unsigned();
            $table->bigInteger('development_type_id')->unsigned();
            $table->string('site_address_1');
            $table->string('site_address_2')->nullable();
            $table->string('site_postcode', 50);
            $table->float('area_of_site_in_hectares')->nullable();
            $table->integer('floor_space_in_square_metres')->nullable();
            $table->integer('number_of_residences')->nullable();
            $table->string('lpa_application_reference', 50)->nullable();
            $table->boolean('site_green_belt')->nullable();
            $table->boolean('agricultural_holding')->nullable();
            $table->boolean('development_affect_setting_of_listed_building')->nullable();
            $table->boolean('historic_building_grant_made')->nullable();
            $table->boolean('in_ca_relates_to_ca')->nullable();
            $table->boolean('is_flooding_an_issue')->nullable();
            $table->boolean('is_the_site_within_an_aonb')->nullable();
            $table->boolean('site_within_sssi')->nullable();
            $table->boolean('redetermined')->nullable();
            $table->boolean('bespoke_indicator')->nullable();
            $table->boolean('costs_applied_for_indicator')->nullable();
            $table->bigInteger('site_town_id')->unsigned();
            $table->bigInteger('site_country_id')->nullable()->unsigned();;
            $table->bigInteger('site_county_id')->nullable()->unsigned();;
            $table->date('call_in_date')->nullable();
            $table->integer('enforcement_grounds_count')->nullable();
            $table->string('enforcement_grounds', 50)->nullable();
            $table->text('development_or_allegation')->nullable();
            $table->bigInteger('agent_id')->nullable()->unsigned();;
            $table->bigInteger('type_of_appeal_id')->unsigned()->nullable();
            $table->bigInteger('decision_id')->unsigned();
            $table->bigInteger('procedure_id')->unsigned();
            $table->bigInteger('appeal_type_reason_id')->nullable()->unsigned();;
            $table->bigInteger('reason_for_the_appeal_id')->nullable()->unsigned();;
            $table->bigInteger('type_detail_id')->nullable()->unsigned();;
            $table->bigInteger('jurisdiction_id')->unsigned();
            $table->bigInteger('link_status_id')->nullable()->unsigned();;
            $table->integer('lead_case')->nullable();
            $table->date('date_recovered')->nullable();
            $table->date('date_not_recovered_or_derecovered')->nullable();

            $table->foreign('appellant_id')
                ->references('id')
                ->on('appellants')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table->foreign('lpa_id')
                ->references('id')
                ->on('lpas')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table->foreign('inspector_id')
                ->references('id')
                ->on('inspectors')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table->foreign('site_town_id')
                ->references('id')
                ->on('site_towns')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table->foreign('site_country_id')
                ->references('id')
                ->on('site_countries')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table->foreign('agent_id')
                ->references('id')
                ->on('agents')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table->foreign('type_of_appeal_id')
                ->references('id')
                ->on('types_of_appeals')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table->foreign('decision_id')
                ->references('id')
                ->on('decisions')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table->foreign('procedure_id')
                ->references('id')
                ->on('procedures')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table->foreign('reason_for_the_appeal_id')
                ->references('id')
                ->on('reasons_for_the_appeal')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table->foreign('appeal_type_reason_id')
                ->references('id')
                ->on('appeal_type_reasons')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table->foreign('type_detail_id')
                ->references('id')
                ->on('types_detail')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table->foreign('jurisdiction_id')
                ->references('id')
                ->on('jurisdictions')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table->foreign('link_status_id')
                ->references('id')
                ->on('link_statuses')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table->foreign('site_county_id')
                ->references('id')
                ->on('site_counties')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

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
       Schema::dropIfExists($this->tableName);
     }
}
