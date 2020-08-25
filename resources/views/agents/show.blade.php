@extends('layouts.app')

@section('content')
    <div class="row agent-statistics">
        <div class="col-md-2">
            <span class="custom-style-agent">{{  $agent->name }}</span>
        </div>
        <div class="col-md-1">
            <div class="prg-cont-wrap text-center">
                <div class="prg-cont rad-prg" id="indicatorAppealType"></div>
            </div>

            <p class="text-center">Top Appeal Type</p>
            <p class="text-center"><b>{{ $topTypesOfAppeals->name }}</b></p>
        </div>
        <div class="col-md-2">
            <div class="prg-cont-wrap text-center">
                <div class="prg-cont rad-prg" id="indicatorTopLPA"></div>
            </div>

            <p class="text-center">Top LPA</p>
            <p class="text-center"><b>{{ $topLPA->name  }}</b></p>
        </div>
        <div class="col-md-1">
            <div class="prg-cont-wrap text-center">
                <div class="prg-cont rad-prg" id="indicatorDevelopmentType"></div>
            </div>

            <p class="text-center">Top Development Type</p>
            <p class="text-center"><b>{{ $topDevelopmentType->name }}</b></p>
        </div>

        <div class="col-md-2 custom-center">
            <div class="text-center">
                <p class="custom-style-total-appeals-and-success-rate">{{ $totalAppealsHandledAndSuccessRate ? $totalAppealsHandledAndSuccessRate->total : 0 }}</p>
                <p>Total appeals handled</p>
            </div>
        </div>
        <div class="col-md-1 custom-center">
            <div class="text-center">
                <p class="custom-style-total-appeals-and-success-rate">{{ ($totalAppealsHandledAndSuccessRate ? $totalAppealsHandledAndSuccessRate->success : 0) . '%'}}</p>
                <p>Success rate</p>
            </div>
        </div>
    </div>


    @include('filters.planning_agent_filter', [
        'lpa' => false,
        'appeal_type' => false,
        'procedure' => false,
        'development_type' => false,
        'year' => true
       ])

    <div class="row">
        <div class="col-md-6">
            <div class="chart">
                <canvas id="vertical-bar-decision-date-chart" width="800" height="450"></canvas>
            </div>
        </div>

        <div class="col-md-6">
            <div class="chart">
                <canvas id="doughnut-development-type-chart" width="800" height="450"></canvas>
            </div>
        </div>

        <div class="col-md-6">
            <div class="chart">
                <canvas id="horizontal-bar-inspector-chart" width="800" height="450"></canvas>
            </div>
        </div>

        <div class="col-md-6">
            <div class="chart">
                <canvas id="horizontal-bar-lpa-chart" width="800" height="450"></canvas>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
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
<script src="{{ asset('js/radialIndicator.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>

<script type="text/javascript">
    $(function () {

        var filters = {};
        var agent_id = {!! json_encode( Request::segment(2) ) !!}
        var topLPA = {!! json_encode( $topLPA ) !!}
        var topTypesOfAppeals  = {!! json_encode( $topTypesOfAppeals ) !!}
        var topDevelopmentType = {!! json_encode( $topDevelopmentType ) !!}
        var totalAppealsHandledAndSuccessRate = {!! json_encode( $totalAppealsHandledAndSuccessRate ) !!}

        $('#indicatorAppealType').radialIndicator({
            barColor: '#87CEEB',
            barWidth: 10,
            initValue: 40,
            roundCorner : true,
            percentage: true
        });

        $('#indicatorTopLPA').radialIndicator({
            barColor: '#87CEEB',
            barWidth: 10,
            initValue: 40,
            roundCorner : true,
            percentage: true
        });

        $('#indicatorDevelopmentType').radialIndicator({
            barColor: '#87CEEB',
            barWidth: 10,
            initValue: 40,
            roundCorner : true,
            percentage: true
        });


        var indicatorAppealType = $('#indicatorAppealType').data('radialIndicator');
        var indicatorTopLPA = $('#indicatorTopLPA').data('radialIndicator');
        var indicatorDevelopmentType = $('#indicatorDevelopmentType').data('radialIndicator');



        if (totalAppealsHandledAndSuccessRate && totalAppealsHandledAndSuccessRate !== 0) {
            let total = totalAppealsHandledAndSuccessRate.total;

            if (topTypesOfAppeals && topTypesOfAppeals.cnt !== 0) {
                indicatorAppealType.animate((topTypesOfAppeals.cnt / total) * 100);
            } else {
                indicatorAppealType.animate(0);
            }

            if (topLPA && topLPA.cnt !== 0) {
                indicatorTopLPA.animate((topLPA.cnt / total) * 100);
            } else {
                indicatorTopLPA.animate(0);
            }

            if (topDevelopmentType && topDevelopmentType.cnt !== 0) {
                indicatorDevelopmentType.animate((topDevelopmentType.cnt / total) * 100);
            } else {
                indicatorDevelopmentType.animate(0);
            }
        }

        var verticalBarByDecisionDate = new Chart(document.getElementById("vertical-bar-decision-date-chart"), {
            type: 'bar',
            data: {
                labels: [],
                datasets: [
                    {
                        label: "Successful",
                        backgroundColor: "#3e95cd",
                        data: [],
                        minBarLength: 1,
                    }, {
                        label: "Failed",
                        backgroundColor: "#8e5ea2",
                        data: []
                    },
                ]
            },
            options: {
                title: {
                    display: true,
                    text: 'Appeals by Decision Date'
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            min: 0,
                        }
                    }]
                }
            }
        });


        var doughnutChartByDevelopmentType = new Chart(document.getElementById("doughnut-development-type-chart"), {
            type: 'doughnut',
            data: {
                labels: [],
                datasets: [
                    {
                        label: "Population (millions)",
                        backgroundColor: [],
                        data: []
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

        // var horizontalBarByInspector = new Chart(document.getElementById("horizontal-bar-inspector-chart"), {
        //     type: 'horizontalBar',
        //     data: {
        //         labels: [],
        //         datasets: [
        //             {
        //                 label: "Successful",
        //                 backgroundColor: "#3ecd6b",
        //                 data: []
        //             }, {
        //                 label: "Failed",
        //                 backgroundColor: "#fb012e",
        //                 data: []
        //             }
        //         ]
        //     },
        //     options: {
        //         title: {
        //             display: true,
        //             text: 'Appeals by Inspector'
        //         },
        //         scales: {
        //             xAxes: [{
        //                 ticks: {
        //                     min: 0,
        //                     stepSize: 1
        //                 }
        //             }]
        //         }
        //     }
        // });


        var barOptionsStackedForInspector = {
            tooltips: {
                enabled: false
            },
            hover :{
                animationDuration:0
            },
            scales: {
                xAxes: [{
                    ticks: {
                        beginAtZero:true,
                        fontFamily: "'Open Sans Bold', sans-serif",
                        fontSize:11
                    },
                    scaleLabel:{
                        display:false
                    },
                    gridLines: {
                    },
                    stacked: true
                }],
                yAxes: [{
                    gridLines: {
                        display:false,
                        color: "#fff",
                        zeroLineColor: "#fff",
                        zeroLineWidth: 0
                    },
                    ticks: {
                        fontFamily: "'Open Sans Bold', sans-serif",
                        fontSize:11
                    },
                    stacked: true
                }]
            },
            legend:{
                display:false
            },

            animation: {
                onComplete: function () {
                    var chartInstance = this.chart;
                    var ctx = chartInstance.ctx;
                    ctx.textAlign = "left";
                    ctx.font = "10px Open Sans";
                    ctx.fillStyle = "black";

                    Chart.helpers.each(this.data.datasets.forEach(function (dataset, i) {
                        var meta = chartInstance.controller.getDatasetMeta(i);
                        Chart.helpers.each(meta.data.forEach(function (bar, index) {
                            data = dataset.data[index];
                            if(i===0){
                                ctx.fillText(data, 95, bar._model.y+4);
                            } else {
                                ctx.fillText(data, bar._model.x-25, bar._model.y+4);
                            }
                        }),this)
                    }),this);
                }
            },
            pointLabelFontFamily : "Quadon Extra Bold",
            scaleFontFamily : "Quadon Extra Bold",
        };

        var barOptionsStackedForLPA = {
            tooltips: {
                enabled: false
            },
            hover :{
                animationDuration:0
            },
            scales: {
                xAxes: [{
                    ticks: {
                        beginAtZero:true,
                        fontFamily: "'Open Sans Bold', sans-serif",
                        fontSize:11
                    },
                    scaleLabel:{
                        display:false
                    },
                    gridLines: {
                    },
                    stacked: true
                }],
                yAxes: [{
                    gridLines: {
                        display:false,
                        color: "#fff",
                        zeroLineColor: "#fff",
                        zeroLineWidth: 0
                    },
                    ticks: {
                        fontFamily: "'Open Sans Bold', sans-serif",
                        fontSize:11
                    },
                    stacked: true
                }]
            },
            legend:{
                display:false
            },

            animation: {
                onComplete: function () {
                    var chartInstance = this.chart;
                    var ctx = chartInstance.ctx;
                    ctx.textAlign = "left";
                    ctx.font = "10px Open Sans";
                    ctx.fillStyle = "black";

                    Chart.helpers.each(this.data.datasets.forEach(function (dataset, i) {
                        var meta = chartInstance.controller.getDatasetMeta(i);
                        Chart.helpers.each(meta.data.forEach(function (bar, index) {
                            data = dataset.data[index];
                            if(i===0){
                                ctx.fillText(data, 265, bar._model.y+4);
                            } else {
                                ctx.fillText(data, bar._model.x-25, bar._model.y+4);
                            }
                        }),this)
                    }),this);
                }
            },
            pointLabelFontFamily : "Quadon Extra Bold",
            scaleFontFamily : "Quadon Extra Bold",
        };

        var horizontalBarByInspector = new Chart(document.getElementById("horizontal-bar-inspector-chart"), {
            type: 'horizontalBar',
            data: {
                labels: [],
                datasets: [
                    {
                        label: "Successful",
                        data: [],
                        backgroundColor: "#3ec367",
                    },
                    {
                        label: "Failed",
                        data: [],
                        backgroundColor: "rgba(163,103,126,1)",
                }]
            },

            options: barOptionsStackedForInspector,
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
                    },
                    {
                        label: "Failed",
                        backgroundColor: "#d81313",
                        data: []
                    }]
            },

            options: barOptionsStackedForLPA,
        });

        var getRandomColor = () => {
            var letters = '0123456789ABCDEF';
            var color = '#';
            for (var i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }

        var getAppealsByDecisionDateData = function () {
            if (agent_id) {
                filters.agent_id = parseInt(agent_id);
                $.get('/api/agents/appeals-by-decision-date', filters)
                    .done(function (data) {
                        if (data) {
                            let labels = [];
                            let success = [];
                            let failed = [];

                            Object.keys(data).forEach(year => {
                                labels.push(year);
                                success.push(data[year].success);

                                // console.log(data[year].failed)
                                failed.push(data[year].failed);
                            })
                            addData(verticalBarByDecisionDate, success, failed, labels);
                        }
                    });
            }
        }

        var getYears = () => {
            var year_start = $('.year-start').val();
            if (year_start) {
                filters.year_start = year_start;
            }

            var year_end = $('.year-end').val();
            if (year_end) {
                filters.year_end = year_end;
            }
        }


        var getAppealsByDevelopmentType = () => {

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

                            doughnutChartByDevelopmentType.data.labels = labels;
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

            getYears();
            getAppealsByDecisionDateData();
            getAppealsByDevelopmentType();

            getAppealsByInspectorData();
            getAppealsByLPAData();
        });

        getYears();
        getAppealsByDecisionDateData();
        getAppealsByDevelopmentType();
        getAppealsByInspectorData();
        getAppealsByLPAData();


    });
</script>
@endsection
