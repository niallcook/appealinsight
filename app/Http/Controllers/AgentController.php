<?php

namespace App\Http\Controllers;

use App\Models\DevelopmentType;
use App\Models\Lpa;
use App\Models\Procedure;
use App\Models\TypeOfAppeal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

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
        return view('agents.show');
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
