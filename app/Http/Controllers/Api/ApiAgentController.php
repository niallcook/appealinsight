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
        $where = [];
        if ($request->get('lpa')) {
            array_push($where, 'lpa_id = ' . $request->get('lpa'));
        }

        if ($request->get('appeal_type')) {
            array_push($where, 'type_of_appeal_id = ' . $request->get('appeal_type'));
        }

        if ($request->get('procedure')) {
            array_push($where, 'procedure_id = ' . $request->get('procedure'));
        }

        if ($request->get('development_type')) {
            array_push($where, 'development_type_id = ' . $request->get('development_type'));
        }

        $data = DB::select('select ap.agent_id, ag.name, COUNT(*) as total,
            round((
                (SELECT COUNT(*)
                FROM appeals
                INNER JOIN decisions d ON d.id = appeals.decision_id
                WHERE agent_id = ag.id ' . (count($where) > 0 ? 'AND ' . join(" AND ", $where) : '') . ' AND d.name IN (\'Quashed on Legal Grounds\', \'Planning Permission Granted\', \'Notice Quashed\', \'Allowed with Conditions\', \'Allowed\', \'Allowed in Part\')
            ) / (SELECT COUNT(*) FROM appeals WHERE agent_id = ag.id GROUP BY agent_id)) * 100, 2) as success
            from appeals as ap
            INNER JOIN agents as ag ON ap.agent_id = ag.id
            ' . (count($where) > 0 ? 'WHERE ' . join(" AND ", $where) : '') . '
            GROUP BY ap.agent_id');

        return DataTables::of($data)->make();
    }

    public function getTopTwentyAgents(Request $request)
    {
        $where = [];
        if ($request->get('lpa')) {
            array_push($where, 'lpa_id = ' . $request->get('lpa'));
        }

        if ($request->get('appeal_type')) {
            array_push($where, 'type_of_appeal_id = ' . $request->get('appeal_type'));
        }

        if ($request->get('procedure')) {
            array_push($where, 'procedure_id = ' . $request->get('procedure'));
        }

        if ($request->get('development_type')) {
            array_push($where, 'development_type_id = ' . $request->get('development_type'));
        }

        $data = DB::select('select ap.agent_id, ag.name, COUNT(*) as total,
            round((
                (SELECT COUNT(*)
                FROM appeals
                INNER JOIN decisions d ON d.id = appeals.decision_id
                WHERE agent_id = ag.id ' . (count($where) > 0 ? 'AND ' . join(" AND ", $where) : '') . ' AND d.name IN (\'Quashed on Legal Grounds\', \'Planning Permission Granted\', \'Notice Quashed\', \'Allowed with Conditions\', \'Allowed\', \'Allowed in Part\')
            ) / (SELECT COUNT(*) FROM appeals WHERE agent_id = ag.id GROUP BY agent_id)) * 100, 2) as success
            from appeals as ap
            INNER JOIN agents as ag ON ap.agent_id = ag.id
            ' . (count($where) > 0 ? 'WHERE ' . join(" AND ", $where) : '') . '
            GROUP BY ap.agent_id
            ORDER BY success DESC
            LIMIT 0, 20');

        return "";
    }
}
