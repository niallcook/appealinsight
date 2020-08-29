

{{--@section('stylesheets')--}}
{{--    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">--}}
{{--    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">--}}
{{--@endsection--}}

@section('table')
{{--    <div class="container">--}}
        <div class="chart-column-with-rotated-labels"></div>

        <h1>All Planning Agents</h1>
        <table class="table table-bordered data-table">
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
{{--    </div>--}}
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript">
        $(function () {

            let processing_parse = JSON.parse("{{ json_encode($processing_parse) }}");
            $('.btn-upload-file').prop('disabled', processing_parse);

            $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "/api/agents",

                columns: [
                    {
                        data: 'agent_id',
                        name: 'agent_id',
                    },
                    {
                        data: 'name',
                        name: 'name'
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
        });
    </script>
@endsection
