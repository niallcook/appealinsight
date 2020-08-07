<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('agents', 'Api\ApiAgentController@getAgents');
Route::get('agents/top-twenty', 'Api\ApiAgentController@getTopTwentyAgents');
Route::get('agents/appeals-by-lpa', 'Api\ApiAgentController@getAppealsByLPA');
Route::get('agents/appeals-by-inspector', 'Api\ApiAgentController@getAppealsByInspectorData');
Route::get('agents/appeals-by-decision-date', 'Api\ApiAgentController@getAppealsByDecisionDateData');
Route::get('agents/appeals-by-development-type', 'Api\ApiAgentController@getAppealsByDevelopmentType');
