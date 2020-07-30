<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\Appeal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ApiAgentController extends Controller
{
    public function getAgents(Request $request)
    {
        $data = DB::select('select ap.agent_id, ag.name, COUNT(*) as total,
            (
                (SELECT COUNT(*)
                FROM appeals
                INNER JOIN decisions d ON d.id = appeals.decision_id
                WHERE agent_id = ag.id AND (
                    d.name = \'Quashed on Legal Grounds\' OR d.name = \'Planning Permission Granted\' OR d.name = \'Notice Quashed\'
                    OR d.name = \'Allowed with Conditions\' OR d.name = \'Allowed\' OR d.name = \'Allowed in Part\'
                )
            ) / (SELECT COUNT(*) FROM appeals WHERE agent_id = ag.id GROUP BY agent_id)) * 100 as success,
            (
                (SELECT COUNT(*)
                FROM appeals
                INNER JOIN decisions d ON d.id = appeals.decision_id
                WHERE agent_id = ag.id AND (d.name = \'Notice Varied and Upheld\' OR d.name = \'Notice Upheld\' OR d.name = \'Dismissed\')
            ) / (SELECT COUNT(*) FROM appeals WHERE agent_id = ag.id GROUP BY agent_id)) * 100 as fail
            from appeals as ap
            INNER JOIN agents as ag ON ap.agent_id = ag.id
            GROUP BY ap.agent_id
            ORDER BY success DESC');

        return DataTables::of($data)->make();
    }
}
