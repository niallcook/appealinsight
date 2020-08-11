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

        if ($year_start = $request->get('year_start') && $year_end = $request->get('year_end')) {
            array_push($where, "(decision_date BETWEEN '$year_start-01-01' AND '$year_end-01-01')");
        }

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

    public function setDate($year)
    {
        $dt = Carbon::now();
        $dt->year = $year;
        $dt->month = 1;
        $dt->day = 1;
        return $dt;
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

        if ($year_start = $request->get('year_start') && $year_end = $request->get('year_end')) {
            array_push($where, "(decision_date BETWEEN '$year_start-01-01' AND '$year_end-01-01')");
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

    public function getAppealsByInspectorData(Request $request)
    {
        $where = [];

        if ($year_start = $request->get('year_start') && $year_end = $request->get('year_end')) {
            array_push($where, "(decision_date BETWEEN '$year_start-01-01' AND '$year_end-01-01')");
        }

        if ($agentId = $request->get('agent_id')) {
            $data = DB::select('SELECT ag.name as agent_name, insp.name as inspector_name, COUNT(*)
             as total,
                (SELECT COUNT(*)

                    FROM appeals
                    join inspectors as insp on appeals.inspector_id = insp.id
                    INNER JOIN decisions d ON d.id = appeals.decision_id
                    WHERE agent_id = ' . $agentId . '
                    AND ap.inspector_id = insp.id
                    ' . (count($where) > 0 ? 'AND ' . join(" AND ", $where) : '') . '
                    AND d.name IN (\'Quashed on Legal Grounds\', \'Planning Permission Granted\', \'Notice Quashed\', \'Allowed with Conditions\', \'Allowed\', \'Allowed in Part\')
                ) as success,

                (SELECT COUNT(*)
                    FROM appeals
                    join inspectors as insp on appeals.inspector_id = insp.id
                    INNER JOIN decisions d ON d.id = appeals.decision_id
                    WHERE agent_id = ' . $agentId . '
                    AND ap.inspector_id = insp.id
                    ' . (count($where) > 0 ? 'AND ' . join(" AND ", $where) : '') . '
                    AND d.name IN (\'Notice Varied and Upheld\', \'Notice Upheld\', \'Dismissed\')
            ) as fail
            FROM appeals as ap
            join agents as ag ON ap.agent_id = ag.id
            join inspectors as insp on ap.inspector_id = insp.id
            where ap.agent_id = ' . $agentId . '
            ' . (count($where) > 0 ? 'AND ' . join(" AND ", $where) : '') . '
            group by inspector_name ORDER BY total DESC
            LIMIT 0, 25');
        }

        return response()->json(['data' => $data]);
    }

    public function getAppealsByDecisionDateData(Request $request)
    {
        $where = [];
        $successful = null;
        $failed = null;

        if ($year_start = $request->get('year_start') && $year_end = $request->get('year_end')) {
            array_push($where, "(decision_date BETWEEN '$year_start-01-01' AND '$year_end-01-01')");
        }

        if ($agentId = $request->get('agent_id')) {
            $successful = DB::select('select COUNT(*) as success, DATE_FORMAT(ap.decision_date, \'%y\') as formatted_year
                from appeals as ap
                LEFT JOIN decisions as d ON ap.decision_id = d.id
                where ap.agent_id = ' . $agentId . ' AND d.name IN (\'Quashed on Legal Grounds\', \'Planning Permission Granted\', \'Notice Quashed\', \'Allowed with Conditions\', \'Allowed\', \'Allowed in Part\')
                ' . (count($where) > 0 ? 'AND ' . join(" AND ", $where) : '') . '
                GROUP BY formatted_year');

            $failed = DB::select('select COUNT(*) as failed, DATE_FORMAT(ap.decision_date, \'%y\') as formatted_year
                from appeals as ap
                LEFT JOIN decisions as d ON ap.decision_id = d.id
                where ap.agent_id = ' . $agentId . ' AND d.name IN (\'Notice Varied and Upheld\', \'Notice Upheld\', \'Dismissed\')
                ' . (count($where) > 0 ? 'AND ' . join(" AND ", $where) : '') . '
                GROUP BY formatted_year
                LIMIT 0, 25');

            foreach ($successful as $k => $val) {
                if ($fail = $this->findFailed($failed, $val->formatted_year)) {
                    $successful[$k]->fail = $fail->failed;
                } else {
                    $successful[$k]->fail = $fail;
                }

                $val->formatted_year = '20' . $val->formatted_year;
            }

        }

        return response()->json([
            'successfulAndFail' => $successful
        ]);
    }

    function findFailed($failed, $year) {
        foreach($failed as $k => $val) {
            if ($val->formatted_year === $year) return $val;
        }
        return 0;
    }

    public function getAppealsByDevelopmentType(Request $request)
    {
        $where = [];
        $data = null;

        if ($year_start = $request->get('year_start') && $year_end = $request->get('year_end')) {
            array_push($where, "(decision_date BETWEEN '$year_start-01-01' AND '$year_end-01-01')");
        }

        if ($agentId = $request->get('agent_id')) {
            $data = DB::select('select count(*) as total, dt.name as name
                from appeals as ap
                join development_types as dt on ap.development_type_id = dt.id
                where ap.agent_id = ' . $agentId . '
                ' . (count($where) > 0 ? 'AND ' . join(" AND ", $where) : '') . '
                group by ap.development_type_id
                LIMIT 0, 25');
        }

        return response()->json(['data' => $data]);
    }

    public function getAppealsByLPA(Request $request)
    {
        $where = [];
        $data = null;

        if ($year_start = $request->get('year_start') && $year_end = $request->get('year_end')) {
            array_push($where, "(decision_date BETWEEN '$year_start-01-01' AND '$year_end-01-01')");
        }

        if ($agentId = $request->get('agent_id')) {
            $data = DB::select('SELECT ag.name as agent_name, lp.name as lpa_name, COUNT(*)
                 as total,
                    (SELECT COUNT(*)

                        FROM appeals
                        join lpas as lp on appeals.lpa_id = lp.id
                        INNER JOIN decisions d ON d.id = appeals.decision_id
                        WHERE agent_id = ' . $agentId . '
                        AND ap.lpa_id = lp.id
                        ' . (count($where) > 0 ? 'AND ' . join(" AND ", $where) : '') . '
                        AND d.name IN (\'Quashed on Legal Grounds\', \'Planning Permission Granted\', \'Notice Quashed\', \'Allowed with Conditions\', \'Allowed\', \'Allowed in Part\')

                    ) as success,

                    (SELECT COUNT(*)

                        FROM appeals
                        join lpas as lp on appeals.lpa_id = lp.id
                        INNER JOIN decisions d ON d.id = appeals.decision_id
                        WHERE agent_id = ' . $agentId . '
                        AND ap.lpa_id = lp.id
                        ' . (count($where) > 0 ? 'AND ' . join(" AND ", $where) : '') . '
                        AND d.name IN (\'Notice Varied and Upheld\', \'Notice Upheld\', \'Dismissed\')
                ) as fail
                FROM appeals as ap
                join agents as ag ON ap.agent_id = ag.id
                join lpas as lp on ap.lpa_id = lp.id
                where ap.agent_id = ' . $agentId . '
                ' . (count($where) > 0 ? 'AND ' . join(" AND ", $where) : '') . '
                group by lpa_name, ap.lpa_id ORDER BY total DESC
                LIMIT 0, 25');
        }

        return response()->json(['data' => $data]);
    }
}
