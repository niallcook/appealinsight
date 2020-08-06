<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ApiAgentController extends Controller
{
    public function getAgents(Request $request)
    {
        $where = [];

//        dd([$request->get('year_start'), $request->get('year_end')]);

        if ($lpas = $request->get('lpa')) {
            foreach ($lpas as $lpa) {
                array_push($where, 'lpa_id = ' . $lpa);
            }
        }

        if ($appealTypes = $request->get('appeal_type')) {
            foreach ($appealTypes as $appealType) {
                array_push($where, 'type_of_appeal_id = ' . $appealType);
            }
        }

        if ($procedures = $request->get('procedure')) {
            foreach ($procedures as $procedure) {
                array_push($where, 'procedure_id = ' . $procedure);
            }
        }

        if ($developmentTypes = $request->get('development_type')) {
            foreach ($developmentTypes as $developmentType) {
                array_push($where, 'development_type_id = ' . $developmentType);
            }
        }



        if ($year_start = $request->get('year_start')) {
//            dd(Carbon::createFromDate($year_start, 1, 1)->toDateString());
            $year_start = Carbon::createFromDate($year_start, 1, 1)->toDateString();
            array_push($where, 'decision_date >= ' . $year_start);
        }

        if ($year_end = $request->get('year_end')) {
            $year_end = Carbon::createFromDate($year_end, 1, 1)->toDateString();
            array_push($where, 'decision_date <= ' . $year_end);
        }

//        dd($where);

//        dd(DB::select('select ap.agent_id, ag.name, COUNT(*) as total,
//            round((
//                (SELECT COUNT(*)
//                FROM appeals
//                INNER JOIN decisions d ON d.id = appeals.decision_id
//                WHERE agent_id = ag.id
//                AND ag.name IS NOT NULL and  ag.name != \'\'
//                ' . (count($where) > 0 ? 'AND ' . join(" AND ", $where) : '') . '
//                AND d.name IN (\'Quashed on Legal Grounds\', \'Planning Permission Granted\', \'Notice Quashed\', \'Allowed with Conditions\', \'Allowed\', \'Allowed in Part\')
//            ) / (SELECT COUNT(*) FROM appeals WHERE agent_id = ag.id GROUP BY agent_id)) * 100, 2) as success
//            from appeals as ap
//            INNER JOIN agents as ag ON ap.agent_id = ag.id
//            WHERE ag.name IS NOT NULL and  ag.name != \'\'
//            ' . (count($where) > 0 ? 'AND ' . join(" AND ", $where) : '') . '
//            GROUP BY ap.agent_id order by total DESC'));

        $data = DB::select('select ap.agent_id, ag.name, COUNT(*) as total,
            round((
                (SELECT COUNT(*)
                FROM appeals
                INNER JOIN decisions d ON d.id = appeals.decision_id
                WHERE agent_id = ag.id
                AND ag.name IS NOT NULL and  ag.name != \'\'
                ' . (count($where) > 0 ? 'AND ' . join(" AND ", $where) : '') . '
                AND d.name IN (\'Quashed on Legal Grounds\', \'Planning Permission Granted\', \'Notice Quashed\', \'Allowed with Conditions\', \'Allowed\', \'Allowed in Part\')
            ) / (SELECT COUNT(*) FROM appeals WHERE agent_id = ag.id GROUP BY agent_id)) * 100, 2) as success
            from appeals as ap
            INNER JOIN agents as ag ON ap.agent_id = ag.id
            WHERE ag.name IS NOT NULL and  ag.name != \'\'
            ' . (count($where) > 0 ? 'AND ' . join(" AND ", $where) : '') . '
            GROUP BY ap.agent_id order by total DESC');

        return DataTables::of($data)->make();
    }

    public function getTopTwentyAgents(Request $request)
    {
        $where = [];

        if ($lpas = $request->get('lpa')) {
            foreach ($lpas as $lpa) {
                array_push($where, 'lpa_id = ' . $lpa);
            }
        }

        if ($appealTypes = $request->get('appeal_type')) {
            foreach ($appealTypes as $appealType) {
                array_push($where, 'type_of_appeal_id = ' . $appealType);
            }
        }

        if ($procedures = $request->get('procedure')) {
            foreach ($procedures as $procedure) {
                array_push($where, 'procedure_id = ' . $procedure);
            }
        }

        if ($developmentTypes = $request->get('development_type')) {
            foreach ($developmentTypes as $developmentType) {
                array_push($where, 'development_type_id = ' . $developmentType);
            }
        }

        $data = DB::select('select ap.agent_id, ag.name, COUNT(*) as total
            from appeals as ap
            INNER JOIN agents as ag ON ap.agent_id = ag.id
            WHERE ag.name IS NOT NULL and  ag.name != \'\'
            ' . (count($where) > 0 ? 'AND ' . join(" AND ", $where) : '') . '
            GROUP BY ap.agent_id
            ORDER BY total DESC
            LIMIT 0, 20');

        $data = collect($data)->map(function ($item, $key) {
            return [
                $item->name,
                (int) $item->total
            ];
        });

        return response()->json(['data' => $data]);
    }
}
