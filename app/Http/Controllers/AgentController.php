<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\DevelopmentType;
use App\Models\Lpa;
use App\Models\Procedure;
use App\Models\TypeOfAppeal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class AgentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function index(Request $request)
    {
        //Cache::put('processing', false);
        $processing = Cache::get('processing') ?? false;
        $lpas = Lpa::all();
        $types = TypeOfAppeal::all();
        $procedures = Procedure::all();
        $development_types = DevelopmentType::all();

        return view('agents.index', [
            'processing_parse' => $processing,
            'lpas' => $lpas,
            'types' => $types,
            'procedures' => $procedures,
            'development_types' => $development_types,
            // TODO get min and max year from appellants table
            'year_start' => 2015,
            'year_end' => 2020
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {

        $agent = Agent::find($id);

        if ($agent) {

            $agentId = $agent->id;

            $topTypesOfAppeals = DB::select('SELECT types_of_appeals.name, COUNT(*) as cnt
                FROM appeals as ap
                INNER JOIN types_of_appeals ON ap.type_of_appeal_id = types_of_appeals.id
                WHERE agent_id = ' . $agentId . '
                GROUP BY type_of_appeal_id
                order by cnt DESC
                LIMIT 0, 1');

            $topLPA = DB::select('SELECT lpas.name, COUNT(*) as cnt
                FROM appeals as ap
                INNER JOIN lpas ON ap.lpa_id = lpas.id
                WHERE agent_id = ' . $agentId . '
                GROUP BY lpa_id
                order by cnt DESC
                LIMIT 0, 1');

            $topDevelopmentType = DB::select('SELECT dt.name, COUNT(*) as cnt
                FROM appeals as ap
                INNER JOIN development_types as dt ON ap.development_type_id = dt.id
                WHERE agent_id = ' . $agentId . '
                GROUP BY development_type_id
                order by cnt DESC
                LIMIT 0, 1');

            $totalAppealsHandledAndSuccessRate = DB::select('select ap.agent_id, ag.name, COUNT(*) as total,
                round((
                    (SELECT COUNT(*)
                    FROM appeals
                    INNER JOIN decisions d ON d.id = appeals.decision_id
                    WHERE agent_id = ' . $agentId . '
                    AND ag.name IS NOT NULL and  ag.name != \'\'
                    AND d.name IN (\'Quashed on Legal Grounds\', \'Planning Permission Granted\', \'Notice Quashed\', \'Allowed with Conditions\', \'Allowed\', \'Allowed in Part\')
                ) / (SELECT COUNT(*)
                        FROM appeals
                        INNER JOIN decisions d ON d.id = appeals.decision_id
                        WHERE agent_id = ag.id
                        AND d.name NOT IN (\'Unknown\', \'Turned Away\', \'Split Decision\', \'Invalid\', \'Appeal Withdrawn\')
                        GROUP BY agent_id)
                    ) * 100, 2) as success
                from appeals as ap
                INNER JOIN agents as ag ON ap.agent_id = ag.id
                WHERE ag.name IS NOT NULL AND  ag.name != \'\'
                AND  ap.agent_id = ' . $agentId . '
                GROUP BY ap.agent_id ORDER BY total DESC');

            $topLPA = empty($topLPA) ?: $topLPA[0];
            $topTypesOfAppeals = empty($topTypesOfAppeals) ?: $topTypesOfAppeals[0];
            $topDevelopmentType = empty($topDevelopmentType) ?: $topDevelopmentType[0];
            $totalAppealsHandledAndSuccessRate = empty($totalAppealsHandledAndSuccessRate) ?: $totalAppealsHandledAndSuccessRate[0];
        }

        return view('agents.show', compact(
            'agent',
            'topLPA',
            'topTypesOfAppeals',
            'topDevelopmentType',
            'totalAppealsHandledAndSuccessRate'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
