<?php


namespace App\Services;


use App\Models\Agent;
use App\Models\AgentAltName;
use App\Models\Appeal;
use App\Models\AppealTypeReason;
use App\Models\Appellant;
use App\Models\AppellantAltName;
use App\Models\Decision;
use App\Models\DevelopmentType;
use App\Models\Inspector;
use App\Models\Jurisdiction;
use App\Models\LinkStatus;
use App\Models\Lpa;
use App\Models\Procedure;
use App\Models\ReasonForTheAppeal;
use App\Models\SiteCountry;
use App\Models\SiteCounty;
use App\Models\SiteTown;
use App\Models\TypeDetail;
use App\Models\TypesOfAppeal;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use League\Csv\Reader;
use League\Csv\Writer;

class ParseService
{

    public function sliceAndStore ($fileFrom, $fileTo, $limit, $offset = 0)
    {
        $csv = Reader::createFromPath($fileFrom, 'r');
        $titles = [];
        Log::error('TEESSST FILEeee222');
        foreach ($csv->fetchOne() as $name) {
            $name = preg_replace('/[^A-Za-z0-9 \-]/', '', $name);
            $titles[] = $name;
        }

        $data = $csv
            ->setLimit($limit)
            ->setOffset($offset + 1)
            ->fetchAssoc($titles);
        $writer = Writer::createFromPath($fileTo, 'w+');
        $writer->insertOne($titles);

        $writer->insertAll($data);

    }

    public function parseCSV($file)
    {
        $csv = Reader::createFromPath($file, 'r');
        $titles = [];

        foreach ($csv->fetchOne() as $name) {
            if ($name) {
                $name = preg_replace('/[^A-Za-z0-9 \-]/', '', $name);
                $titles[] = $name;
            }
        }
        $data = $csv
            ->setLimit(2000)
            ->setOffset(1)
            ->fetchAssoc($titles);

        $lpaDataCache = [];
        $inspectorDataCache = [];
        $developmentTypeDataCache = [];
        $siteTownDataCache = [];
        $siteCountyDataCache = [];
        $siteCountryDataCache = [];
        $procedureDataCache = [];
        $appealTypeReasonDataCache = [];
        $reasonForTheAppealDataCache = [];
        $typeDetailDataCache = [];
        $jurisdictionDataCache = [];
        $linkStatusDataCache = [];
        $agentDataCache = [];
        $agentAltNameDataCache = [];
        $appellantDataCache = [];
        $appellantAltNameDataCache = [];
        $decisionDataCache = [];

        foreach ($data as $item) {

            // LPA updating and caching
            $lpaKey = $item['LPA Name'].$item['ONS LPA Code'];
            if(!isset($lpaDataCache[$lpaKey])) {
                $lpaData = [
                    'name' => $item['LPA Name'],
                    'ons_lpa_code' => $item['ONS LPA Code']
                ];

                $lpaData = Lpa::updateOrCreate(
                    $lpaData,
                    $lpaData
                );
                $lpaDataCache[$lpaKey] = $lpaData->id;
            }
            // LPA - END

            // Inspector updating and caching
            $inspectorKey = $item['Inspector Name'];
            if(!isset($inspectorDataCache[$inspectorKey])) {
                $inspectorData = [
                    'name' => $item['Inspector Name']
                ];

                $inspectorData = Inspector::updateOrCreate(
                    $inspectorData,
                    $inspectorData
                );
                $inspectorDataCache[$inspectorKey] = $inspectorData->id;
            }
            // Inspector - END

            // Development Type updating and caching
            $developmentTypeKey = $item['Development Type'];
            if(!isset($developmentTypeDataCache[$developmentTypeKey])) {
                $developmentTypeData = [
                    'name' => $item['Development Type']
                ];

                $developmentTypeData = DevelopmentType::updateOrCreate(
                    $developmentTypeData,
                    $developmentTypeData
                );
                $developmentTypeDataCache[$developmentTypeKey] = $developmentTypeData->id;
            }
            // Development Type - END


            // Site Town updating and caching
            $siteTownKey = $item['Site Town'];
            if(!isset($siteTownDataCache[$siteTownKey])) {
                $siteTownData = [
                    'name' => $item['Site Town']
                ];

                $siteTownData = SiteTown::updateOrCreate(
                    $siteTownData,
                    $siteTownData
                );
                $siteTownDataCache[$siteTownKey] = $siteTownData->id;
            }
            // Site Town - END

            // Site County updating and caching
            $siteCountyKey = $item['Site County'];
            if(!isset($siteCountyDataCache[$siteCountyKey])) {
                $siteCountyData = [
                    'name' => $item['Site County']
                ];

                $siteCountyData = SiteCounty::updateOrCreate(
                    $siteCountyData,
                    $siteCountyData
                );
                $siteCountyDataCache[$siteCountyKey] = $siteCountyData->id;
            }
            // Site County - END

            // Site Country updating and caching
            $siteCountryKey = $item['Site Country'];
            if(!isset($siteCountryDataCache[$siteCountryKey])) {
                $siteCountryData = [
                    'name' => $item['Site Country']
                ];

                $siteCountryData = SiteCountry::updateOrCreate(
                    $siteCountryData,
                    $siteCountryData
                );
                $siteCountryDataCache[$siteCountryKey] = $siteCountryData->id;
            }
            // Site Country - END

//            $typeOfAppealData = [
//                'name' => $item['Type of Appeal']
//            ];
//
//            $typeOfAppealData = TypesOfAppeal::updateOrCreate(
//                $typeOfAppealData,
//                $typeOfAppealData
//            );

            // Procedure updating and caching
            $procedureKey = $item['Procedure'];
            if(!isset($procedureDataCache[$procedureKey])) {
                $procedureData = [
                    'name' => $item['Procedure']
                ];

                $procedureData = Procedure::updateOrCreate(
                    $procedureData,
                    $procedureData
                );
                $procedureDataCache[$procedureKey] = $procedureData->id;
            }
            // Procedure - END

            // Appeal Type Reason updating and caching
            $appealTypeReasonKey = $item['Appeal Type Reason'];
            if(!isset($appealTypeReasonDataCache[$appealTypeReasonKey])) {
                $appealTypeReasonData = [
                    'name' => $item['Appeal Type Reason']
                ];

                $appealTypeReasonData = AppealTypeReason::updateOrCreate(
                    $appealTypeReasonData,
                    $appealTypeReasonData
                );
                $appealTypeReasonDataCache[$appealTypeReasonKey] = $appealTypeReasonData->id;
            }
            // Appeal Type Reason - END

            // Reason For The Appeal updating and caching
            $reasonForTheAppealKey = $item['Reason for the appeal'];
            if(!isset($reasonForTheAppealDataCache[$reasonForTheAppealKey])) {
                $reasonForTheAppealData = [
                    'name' => $item['Reason for the appeal']
                ];

                $reasonForTheAppealData = ReasonForTheAppeal::updateOrCreate(
                    $reasonForTheAppealData,
                    $reasonForTheAppealData
                );
                $reasonForTheAppealDataCache[$reasonForTheAppealKey] = $reasonForTheAppealData->id;
            }
            // Reason For The Appeal - END

            // Type Detail updating and caching
            $typeDetailKey = $item['Type - Detail'];
            if(!isset($typeDetailDataCache[$typeDetailKey])) {
                $typeDetailData = [
                    'name' => $item['Type - Detail']
                ];

                $typeDetailData = TypeDetail::updateOrCreate(
                    $typeDetailData,
                    $typeDetailData
                );
                $typeDetailDataCache[$typeDetailKey] = $typeDetailData->id;
            }
            // Type Detail - END

            // Jurisdiction updating and caching
            $jurisdictionKey = $item['Jursidiction'];
            if(!isset($jurisdictionDataCache[$jurisdictionKey])) {
                $jurisdictionData = [
                    'name' => $item['Jursidiction']
                ];

                $jurisdictionData = Jurisdiction::updateOrCreate(
                    $jurisdictionData
                );
                $jurisdictionDataCache[$jurisdictionKey] = $jurisdictionData->id;
            }
            // Jurisdiction - END


            // Link Status updating and caching
            $linkStatusKey = $item['Link Status'];
            if(!isset($linkStatusDataCache[$linkStatusKey])) {
                $linkStatusData = [
                    'name' => $item['Link Status']
                ];

                $linkStatusData = LinkStatus::updateOrCreate(
                    $linkStatusData,
                    $linkStatusData
                );
                $linkStatusDataCache[$linkStatusKey] = $linkStatusData->id;
            }
            // Link Status - END

            // Agent updating and caching
            $agentKey = $item['Agent'];
            if(!isset($agentDataCache[$agentKey])) {
                $agentData = [
                    'name' => $item['Agent']
                ];

                $agentData = Agent::updateOrCreate(
                    $agentData,
                    $agentData
                );
                $agentDataCache[$agentKey] = $agentData->id;
            }
            // Agent - END

            // Agent Alt Name updating and caching
            $agentAltNameKey = $item['Agent'];
            if(!isset($agentAltNameDataCache[$agentAltNameKey])) {
                $agentAltNameData = [
                    'agent_id' => $agentData->id,
                    'alt_name' => $item['Agent']
                ];

                $agentAltNameData = AgentAltName::updateOrCreate(
                    $agentAltNameData,
                    $agentAltNameData
                );
                $agentAltNameDataCache[$agentAltNameKey] = $agentAltNameData->id;
            }
            // Agent Alt Name - END


            // Appellant updating and caching
            $appellantKey = $item['Appellant'];
            if(!isset($appellantDataCache[$appellantKey])) {
                $appellantData = [
                    'name' => $item['Appellant']
                ];

                $appellantData = Appellant::updateOrCreate(
                    $appellantData,
                    $appellantData
                );
                $appellantDataCache[$appellantKey] = $appellantData->id;
            }
            // Appellant - END

            // Appellant Alt Name updating and caching
            $appellantAltNameKey = $item['Appellant'];
            if(!isset($appellantAltNameDataCache[$appellantAltNameKey])) {
                $appellantAltNameData = [
                    'alt_name' => $item['Appellant'],
                    'appellant_id' => $appellantData->id
                ];

                $appellantAltNameData = AppellantAltName::updateOrCreate(
                    $appellantAltNameData,
                    $appellantAltNameData
                );
                $appellantAltNameDataCache[$appellantAltNameKey] = $appellantAltNameData->id;
            }
            // Appellant Alt Name - END

            // Decision updating and caching
            $decisionKey = $item['Decision'];
            if(!isset($decisionDataCache[$decisionKey])) {
                $decisionData = [
                    'name' => $item['Decision']
                ];

                $decisionData = Decision::updateOrCreate(
                    $decisionData,
                    $decisionData
                );
                $decisionDataCache[$decisionKey] = $decisionData->id;
            }
            // Decision - END


            $appealData = [
                'reference' =>                                          (int) $item['Reference'],
                'site_address_1' =>                                     (string) $item['Site Address 1'],
                'site_address_2' =>                                     (string) $item['Site Address 2'],
                'site_postcode' =>                                      (string) $item['Site Postcode'],
                'area_of_site_in_hectares' =>                           (float) $item['Area Of Site In Hectares'],
                'floor_space_in_square_metres' =>                       (int) $item['Floor Space In Square Metres'],
                'number_of_residences' =>                               (int) $item['Number Of Residences'],
                'lpa_application_reference' =>                          (string) $item['LPA Application Reference'],
                'site_green_belt' =>                                    (bool) $item['Site Green Belt'],
                'agricultural_holding' =>                               (bool) $item['Agricultural Holding'],
                'development_affect_setting_of_listed_building' =>      (bool) $item['Development Affect Setting Of Listed Building'],
                'historic_building_grant_made' =>                       (bool) $item['Historic Building Grant Made'],
                'in_ca_relates_to_ca' =>                                (bool) $item['In CA Relates To CA'],
                'is_flooding_an_issue' =>                               (bool) $item['Is Flooding An Issue'],
                'is_the_site_within_an_aonb' =>                         (bool) $item['Is The Site Within An AONB'],
                'site_within_sssi' =>                                   (bool) $item['Site Within SSSI'],
                'redetermined' =>                                       (bool) $item['Redetermined'],
                'bespoke_indicator' =>                                  (bool) $item['Bespoke Indicator'],
                'lead_case' =>                                          (int) $item['Lead Case'],
                'costs_applied_for_indicator' =>                        (bool) $item['Costs Applied For Indicator'],
                'enforcement_grounds_count' =>                          (int) $item['Enforcement Grounds Count'],
                'enforcement_grounds' =>                                (string) $item['Enforcement Grounds'],
                'development_or_allegation' =>                          (string) $item['Development Or Allegation'],
                'type_of_appeal_id' =>                                  null,
                'lpa_id' =>                                             (int) $lpaDataCache[$lpaKey],
                'appellant_id' =>                                       (int) $appellantDataCache[$appellantKey],
                'development_type_id' =>                                (int) $developmentTypeDataCache[$developmentTypeKey],
                'inspector_id' =>                                       (int) $inspectorDataCache[$inspectorKey],
                'site_town_id' =>                                       (int) $siteTownDataCache[$siteTownKey],
                'site_country_id' =>                                    (int) $siteCountryDataCache[$siteCountryKey],
                'site_county_id' =>                                     (int) $siteCountyDataCache[$siteCountyKey],
                'agent_id' =>                                           (int) $agentDataCache[$agentKey],
                'decision_id' =>                                        (int) $decisionDataCache[$decisionKey],
                'procedure_id' =>                                       (int) $procedureDataCache[$procedureKey],
                'appeal_type_reason_id' =>                              (int) $appealTypeReasonDataCache[$appealTypeReasonKey],
                'reason_for_the_appeal_id' =>                           (int) $reasonForTheAppealDataCache[$reasonForTheAppealKey],
                'type_detail_id' =>                                     (int) $typeDetailDataCache[$typeDetailKey],
                'jurisdiction_id' =>                                    (int) $jurisdictionDataCache[$jurisdictionKey],
                'link_status_id' =>                                     (int) $linkStatusDataCache[$linkStatusKey],
                'call_in_date' =>                                       $this->extractTimestamp($item['Call In Date'], 'd-M-y'),
                'decision_date' =>                                      $this->extractTimestamp($item['Decision Date'], 'd/m/y'),
                'valid_date' =>                                         $this->extractTimestamp($item['Valid Date'], 'd/m/y'),
                'start_date' =>                                         $this->extractTimestamp($item['Start Date'], 'd/m/y'),
                'received_date' =>                                      $this->extractTimestamp($item['Received Date'], 'd/m/y'),
                'date_recovered' =>                                     $this->extractTimestamp($item['Date Recovered'], 'd-M-y'),
                'date_not_recovered_or_derecovered' =>                  $this->extractTimestamp($item['Date Not Recovered Or Derecovered'], 'd-M-y'),
            ];

            Appeal::updateOrCreate(
                [
                    'reference' => $appealData['reference'],
                ],
                $appealData
            );

            Cache::put('processing', false);
        }
    }

    public function extractTimestamp($date, $format)
    {
        if(!$date) return null;
        try {
            return Carbon::createFromFormat($format, $date)->toDateString();
        } catch (\Exception $exception) {
            Log::error('Wrong format date: "' . $date . '" for format "' . $format);
            return null;
        }
    }
}
