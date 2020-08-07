@extends('layouts.app')

@section('content')
    @include('filters.planning_agent_filter', [
        'lpa' => false,
        'appeal_type' => false,
        'procedure' => false,
        'development_type' => false,
        'year' => true
       ])

    <div class="row">
        <div class="col-md-6">
            <div class="chart" style="border: 1px solid black">
                <canvas id="vertical-bar-decision-date-chart" width="800" height="450"></canvas>
            </div>
        </div>

        <div class="col-md-6">
            <div class="chart" style="border: 1px solid black">
                <canvas id="doughnut-development-type-chart" width="800" height="450"></canvas>
            </div>
        </div>

        <div class="col-md-6">
            <div class="chart" style="border: 1px solid black">
                <canvas id="horizontal-bar-inspector-chart" width="800" height="450"></canvas>
            </div>
        </div>

        <div class="col-md-6">
            <div class="chart" style="border: 1px solid black">
                <canvas id="horizontal-bar-lpa-chart" width="800" height="450"></canvas>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
{{--    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>--}}
{{--    <script src="https://code.highcharts.com/highcharts.js"></script>--}}
{{--    <script src="https://code.highcharts.com/modules/exporting.js"></script>--}}
{{--    <script src="https://code.highcharts.com/modules/export-data.js"></script>--}}
{{--    <script src="https://code.highcharts.com/modules/accessibility.js"></script>--}}

<script src="{{ asset('css/bower_components/jquery/dist/jquery.min.js')}}"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
{{--<script src="{{ asset('css/bower_components/chart.js/Chart.js')}}"></script>--}}
<script src="{{ asset('css/bower_components/fastclick/lib/fastclick.js')}}"></script>
<script src="{{ asset('js/dist/js/adminlte.min.js')}}"></script>
<script src="{{ asset('js/dist/js/demo.js')}}"></script>

<script src="{{ asset('css/bower_components/Flot/jquery.flot.js')}}"></script>
<script src="{{ asset('css/bower_components/Flot/jquery.flot.resize.js')}}"></script>
<script src="{{ asset('css/bower_components/Flot/jquery.flot.pie.js')}}"></script>
<script src="{{ asset('css/bower_components/Flot/jquery.flot.categories.js')}}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>

<script type="text/javascript">
    $(function () {

        var filters = {};
        var agent_id = {!! json_encode( Request::segment(2) ) !!}

        var verticalBarByDecisionDate = new Chart(document.getElementById("vertical-bar-decision-date-chart"), {
                type: 'bar',
                data: {
                    labels: ["1900", "1950", "1999", "2050"],
                    datasets: [
                        {
                            label: "Successful",
                            backgroundColor: "#3e95cd",
                            data: []
                        }, {
                            label: "Failed",
                            backgroundColor: "#8e5ea2",
                            data: []
                        }
                    ]
                },
                options: {
                    title: {
                        display: true,
                        text: 'Appeals by Decision Date'
                    }
                }
            });

        // verticalBarByDecisionDate;


        var doughnutChartByDevelopmentType = new Chart(document.getElementById("doughnut-development-type-chart"), {
            type: 'doughnut',
            data: {
                labels: [],
                datasets: [
                    {
                        label: "Population (millions)",
                        backgroundColor: [],
                        // backgroundColor: [],
                        data: []
                        // data: []
                    }
                ]
            },
            options: {
                title: {
                    display: true,
                    text: 'Appeals by Development Type'
                }
            }
        });

        var horizontalBarByInspector = new Chart(document.getElementById("horizontal-bar-inspector-chart"), {
            type: 'horizontalBar',
            data: {
                labels: [],
                datasets: [
                    {
                        label: "Successful",
                        backgroundColor: "#3ecd6b",
                        data: []
                    }, {
                        label: "Failed",
                        backgroundColor: "#fb012e",
                        data: []
                    }
                ]
            },
            options: {
                title: {
                    display: true,
                    text: 'Appeals by Inspector'
                }
            }
        });

        var horizontalBarByLPA = new Chart(document.getElementById("horizontal-bar-lpa-chart"), {
            type: 'horizontalBar',
            data: {
                labels: [],
                datasets: [
                    {
                        label: "Successful",
                        backgroundColor: "#008000",
                        data: []
                    }, {
                        label: "Failed",
                        backgroundColor: "#d81313",
                        data: []
                    }
                ]
            },
            options: {
                title: {
                    display: true,
                    text: 'Appeals by LPA'
                }
            }
        });

        var getRandomColor = () => {
            var letters = '0123456789ABCDEF';
            var color = '#';
            for (var i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }

        var getAppealsByDevelopmentType = () => {

            var year_start = $('.year-start').val();
            if (year_start) {
                filters.year_start = year_start;
            }

            var year_end = $('.year-end').val();
            if (year_end) {
                filters.year_end = year_end;
            }

            if(agent_id) {
                filters.agent_id = parseInt(agent_id);

                $.get('/api/agents/appeals-by-development-type', filters)
                    .done(function (data) {
                        if (data && data.data) {
                            let labels = [];
                            var background_colors = [];
                            let totals = [];

                            data.data.forEach(el => {
                                labels.push(el.name);
                                totals.push(el.total);
                            });

                            for (let i = 1; i <= totals.length; i++) {
                                let color = getRandomColor();
                                background_colors.push(color);
                            }

                            doughnutChartByDevelopmentType.labels = labels;
                            doughnutChartByDevelopmentType.data.datasets[0].backgroundColor = background_colors;
                            doughnutChartByDevelopmentType.data.datasets[0].data = totals;

                            doughnutChartByDevelopmentType.update();
                        }
                    });
            }
        }

        var getAppealsByInspectorData = function () {
            if(agent_id) {
                filters.agent_id = parseInt(agent_id);

                $.get('/api/agents/appeals-by-inspector', filters)
                    .done(function (data) {
                        if (data && data.data) {
                            let labels = [];
                            let success = [];
                            let failed = [];

                            data.data.forEach(el => {
                                labels.push(el.inspector_name);
                                success.push(el.success);
                                failed.push(el.fail);
                            });

                            addData(horizontalBarByInspector, success, failed, labels);
                        }
                    });
            }
        }

        var getAppealsByLPAData = function () {
            if(agent_id) {
                filters.agent_id = parseInt(agent_id);

                $.get('/api/agents/appeals-by-lpa', filters)
                    .done(function (data) {
                        if (data && data.data) {
                            let labels = [];
                            let success = [];
                            let failed = [];

                            data.data.forEach(el => {
                                labels.push(el.lpa_name);
                                success.push(el.success);
                                failed.push(el.fail);
                            });

                            addData(horizontalBarByLPA, success, failed, labels);
                        }
                    });
            }
        }

        var getAppealsByDecisionDateData = function () {
            if(agent_id) {
                filters.agent_id = parseInt(agent_id);

                $.get('/api/agents/appeals-by-decision-date', filters)
                    .done(function (data) {
                        if (data && data.data) {
                            console.log(data.data)
                        }
                    });
            }
        }

        var addData = (chart, success, failed, labels) => {
            chart.data.labels = labels;
            chart.data.datasets[0].data = success
            chart.data.datasets[1].data = failed

            chart.update();
        }

        $('.apply-filters').on('click', function () {
            filters = {};

            var year_start = $('.year-start').val();
            if (year_start) {
                filters.year_start = year_start;
            }

            var year_end = $('.year-end').val();
            if (year_end) {
                filters.year_end = year_end;
            }

            // getAppealsByDecisionDateData();
            getAppealsByDevelopmentType();
            getAppealsByInspectorData();
            getAppealsByLPAData();
        });

        // getAppealsByDecisionDateData();
        getAppealsByDevelopmentType();
        getAppealsByInspectorData();
        getAppealsByLPAData();


    });
</script>
@endsection
