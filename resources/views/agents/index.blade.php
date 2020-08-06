@extends('layouts.app')

@section('content')
    <div class="container-planning-agents">
    @include('filters.planning_agent_filter', [
        'lpa' => true,
        'appeal_type' => true,
        'procedure' => true,
        'development_type' => true,
        'year' => true
    ])

    <div class="row custom-style-column-labels">
        <div class="col-md-12">
            <!-- Bar chart -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <i class="fa fa-bar-chart-o"></i>

                    <h3 class="box-title">Bar Chart</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div id="bar-chart" style="height: 300px;"></div>
                </div>
                <!-- /.box-body-->
            </div>
            <!-- /.box -->

{{--        <div class="col-md-12">--}}
{{--            <figure class="highcharts-figure">--}}
{{--                <div id="most_active_planning_agents_diagrams-container"></div>--}}
{{--            </figure>--}}
{{--        </div>--}}

        <div class="col-md-12">
            <div class=""></div>

            <h1>Table Planning Agent</h1>
{{--            <table id="data-table" class="table table-striped table-bordered data-table custom-style-table">--}}
            <table id="data-table" class="table table-bordered table-striped data-table custom-style-table">
                <thead>
                <tr>
                    <th></th>
                    <th>Planning Agent</th>
                    <th width="100px">Appeal Count</th>
                    <th width="100px">Success Rate</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
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

    <!-- Bootstrap 3.3.7 -->
    <script src="{{ asset('css/bower_components/jquery/dist/jquery.min.js')}}"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap.min.js"></script>

    <script src="{{ asset('css/bower_components/fastclick/lib/fastclick.js')}}"></script>
    <script src="{{ asset('js/dist/js/adminlte.min.js')}}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('js/dist/js/demo.js')}}"></script>

    <script src="{{ asset('css/bower_components/select2/dist/js/select2.full.min.js')}}"></script>
    <script src="{{ asset('css/bower_components/Flot/jquery.flot.js')}}"></script>
    <script src="{{ asset('css/bower_components/Flot/jquery.flot.resize.js')}}"></script>
    <script src="{{ asset('css/bower_components/Flot/jquery.flot.pie.js')}}"></script>
    <script src="{{ asset('css/bower_components/Flot/jquery.flot.categories.js')}}"></script>



    <script type="text/javascript">
        $(function () {
            $('.select2-filter').select2({width: '100%'});

            let processing_parse = JSON.parse("{{ json_encode($processing_parse) }}");
            $('.btn-upload-file').prop('disabled', processing_parse);

            var filters = {};
            var dataTableCustom = $('.data-table').DataTable({
                processing: true,
                order: [[2, "desc"]],
                columns: [
                    {
                        data: 'agent_id',
                        name: 'agent_id',
                    },
                    {
                        data: 'name',
                        name: 'name',
                        render: function (data, type, row) {
                            return `<a href="/agent/${row.agent_id}">${data}</a>`;
                        }
                    },
                    {
                        data: 'total',
                        name: 'total'
                    },
                    {
                        data: 'success',
                        name: 'success',
                        render: function (data) {
                            return data + '%'
                        }
                    },
                    // {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });

            var getAgentsData = function () {
                $.get('/api/agents', filters)
                    .done(function (data) {
                        dataTableCustom.clear();
                        dataTableCustom.rows.add(data.data);
                        dataTableCustom.draw();
                    });
            }

        /*
         * BAR CHART
         * ---------
         */
            var options = {
                grid: {
                    hoverable  : true,
                    borderWidth: 1,
                    borderColor: '#f3f3f3',
                    tickColor: '#f3f3f3',
                    color: '#3c8dbc'
                },
                series: {
                    bars: {
                        show: true,
                        barWidth: 0.4,
                        align: 'center'
                    },
                    // lines: { show: true },
                    points: { show: true }
                },
                xaxis: {
                    mode: 'categories',
                    tickLength: 0
                }
            }

            var bar_chart = $.plot('#bar-chart', [], options)
            /* END BAR CHART */


            const getTopTwentyAgentsData = () => {
                $.get('/api/agents/top-twenty', filters)
                    .done(function (data) {
                        if (data && data.data) {
                            $.plot('#bar-chart', [data.data], options)
                        }
                    });
            }

            //Initialize tooltip on hover
            $('<div class="tooltip-inner" id="line-chart-tooltip"></div>').css({
                position: 'absolute',
                display : 'none',
                opacity : 0.8
            }).appendTo('body')
            $('#bar-chart').bind('plothover', function (event, pos, item) {
                if (item) {
                    var x = item.datapoint[0].toFixed(2),
                        y = item.datapoint[1].toFixed(2)

                    $('#line-chart-tooltip').html(y)
                        .css({ top: item.pageY + 5, left: item.pageX + 5 })
                        .fadeIn(200)
                } else {
                    $('#line-chart-tooltip').hide()
                }

            })

            $('.apply-filters').on('click', function () {
                filters = {};
                var lpa = $('.lpa-filter').val();
                if (lpa) {
                    filters.lpa = lpa;
                }

                var type = $('.appeal-filter').val();
                if (type) {
                    filters.appeal_type = type;
                }

                var procedure = $('.procedure-filter').val();
                if (procedure) {
                    filters.procedure = procedure;
                }

                var development = $('.development-filter').val();
                if (development) {
                    filters.development_type = development;
                }

                var year_start = $('.year-start').val();
                if (year_start) {
                    filters.year_start = year_start;
                }

                var year_end = $('.year-end').val();
                if (year_end) {
                    filters.year_end = year_end;
                }


                getAgentsData();
                // getTopTwentyAgentsData();
            });
            getTopTwentyAgentsData();
            getAgentsData();
    });
    </script>
@endsection

