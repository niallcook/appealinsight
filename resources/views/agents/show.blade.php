@extends('layouts.app')

@section('content')
    @include('filters.planning_agent_filter', [
        'lpa' => false,
        'appeal_types' => false,
        'procedures' => false,
        'development_types' => false,
        'year' => true
       ])

    <div class="row justify-content-md-center">
        <div class="col-md-10">

        </div>
    </div>
@endsection
