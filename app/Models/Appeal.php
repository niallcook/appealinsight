<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appeal extends Model
{
    protected $fillable = [
        'reference',
        'received_date',
        'valid_date',
        'start_date',
        'decision_date',
        'appellant_id',
        'lpa_id',
        'inspector_id',
        'development_type_id',
        'site_address_1',
        'site_address_2',
        'site_postcode',
        'area_of_site_in_hectares',
        'floor_space_in_square_metres',
        'number_of_residences',
        'lpa_application_reference',
        'site_green_belt',
        'agricultural_holding',
        'development_affect_setting_of_listed_building',
        'historic_building_grant_made',
        'in_ca_relates_to_ca',
        'is_flooding_an_issue',
        'is_the_site_within_an_aonb',
        'site_within_sssi',
        'redetermined',
        'bespoke_indicator',
        'costs_applied_for_indicator',
        'site_town_id',
        'site_country_id',
        'site_county_id',
        'call_in_date',
        'enforcement_grounds_count',
        'enforcement_grounds',
        'development_or_allegation',
        'agent_id',
        'decision_id',
        'type_of_appeal_id',
        'decision_type_id',
        'procedure_id',
        'appeal_type_reason_id',
        'reason_for_the_appeal_id',
        'type_detail_id',
        'jurisdiction_id',
        'link_status_id',
        'lead_case',
        'date_recovered',
        'date_not_recovered_or_derecovered'
    ];

    protected $table = 'appeals';

    public $timestamps = false;

}
