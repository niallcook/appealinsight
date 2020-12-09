
<div class="row">
    <div class="col-md-12">
        <ul class="planning_agent_filter">
            @if($lpa)
                <li>
{{--                    <div class="form-group">--}}
                        <b>LPA:</b>
                        <select class="form-control select2-filter lpa-filter" name="lpa" multiple="multiple" data-placeholder="Select a LPA">
{{--                            <option value="-1">All</option>--}}
                            @foreach($lpas as $lpa_item)
                                <option value="{{ $lpa_item['id'] }}">{{ $lpa_item['name'] }}</option>
                            @endforeach
                        </select>
{{--                    </div>--}}
                </li>
            @endif

            @if($appeal_type)
                <li>
                    <b>Appeal Types:</b>
                    <select class="select2-filter appeal-filter" name="appeal_type" multiple="multiple" data-placeholder="Select a Appeal Types">
{{--                        <option value="-1">All</option>--}}
                        @foreach($types as $type_item)
                            <option value="{{ $type_item['id'] }}">{{ $type_item['name'] }}</option>
                        @endforeach
                    </select>
                </li>
            @endif

            @if($procedure)
                <li>
                    <b>Procedures:</b>
                    <select class="select2-filter procedure-filter" name="procedure" multiple="multiple" data-placeholder="Select a Procedures">
{{--                        <option value="-1">All</option>--}}
                        @foreach($procedures as $procedure_item)
                            <option value="{{ $procedure_item['id'] }}">{{ $procedure_item['name'] }}</option>
                        @endforeach
                    </select>
                </li>
            @endif

            @if($development_type)
                <li>
                    <b>Development Types:</b>
                    <select class="select2-filter development-filter" name="development_type" multiple="multiple" data-placeholder="Select a Development Types">
{{--                        <option value="-1">All</option>--}}
                        @foreach($development_types as $development_type_item)
                            <option value="{{ $development_type_item['id'] }}">{{ $development_type_item['name'] }}</option>
                        @endforeach
                    </select>
                </li>
            @endif

            @if($year)
                <li style="margin-top: 10px">
                    <b>Year:</b>
                    <select class="year-start">
                        <option value="2012">2012</option>
                        <option value="2013">2013</option>
                        <option value="2014">2014</option>
                        <option value="2015">2015</option>
                        <option value="2016">2016</option>
                        <option value="2017">2017</option>
                        <option value="2018">2018</option>
                        <option value="2019">2019</option>
                        <option value="2020">2020</option>
                    </select>
                    <b>To:</b>
                    <select class="year-end">
                        <option value="2012">2012</option>
                        <option value="2013">2013</option>
                        <option value="2014">2014</option>
                        <option value="2015">2015</option>
                        <option value="2016">2016</option>
                        <option value="2017">2017</option>
                        <option value="2018">2018</option>
                        <option value="2019">2019</option>
                        <option selected value="2020">2020</option>
                    </select>
                </li>
            @endif

            <li>
                <div style="margin-top: 10px">
                    <button class="apply-filters">Apply</button>
                </div>
            </li>
        </ul>
    </div>
</div>

