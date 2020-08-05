
<div class="row">
    <div class="col-md-11">
        <ul class="planning_agent_filter">
            @if($lpa)
                <li>
                    <b>LPA:</b>
                    <select class="select2-filter lpa-filter" name="lpa">
                        <option value="-1">All</option>
                        @foreach($lpas as $lpa_item)
                            <option value="{{ $lpa_item['id'] }}">{{ $lpa_item['name'] }}</option>
                        @endforeach
                    </select>
                </li>
            @endif

            @if($appeal_type)
                <li>
                    <b>Appeal Types:</b>
                    <select class="select2-filter appeal-filter" name="appeal_type">
                        <option value="-1">All</option>
                        @foreach($types as $type_item)
                            <option value="{{ $type_item['id'] }}">{{ $type_item['name'] }}</option>
                        @endforeach
                    </select>
                </li>
            @endif

            @if($procedure)
                <li>
                    <b>Procedures:</b>
                    <select class="select2-filter procedure-filter" name="procedure">
                        <option value="-1">All</option>
                        @foreach($procedures as $procedure_item)
                            <option value="{{ $procedure_item['id'] }}">{{ $procedure_item['name'] }}</option>
                        @endforeach
                    </select>
                </li>
            @endif

            @if($development_type)
                <li>
                    <b>Development Types:</b>
                    <select class="select2-filter development-filter" name="development_type">
                        <option value="-1">All</option>
                        @foreach($development_types as $development_type_item)
                            <option value="{{ $development_type_item['id'] }}">{{ $development_type_item['name'] }}</option>
                        @endforeach
                    </select>
                </li>
            @endif

            @if($year)
                <li>
                    <b>Year:</b>
                    <select class="year-start">
                        <option value="2015">2015</option>
                        <option value="2016">2016</option>
                        <option value="2017">2017</option>
                        <option value="2018">2018</option>
                        <option value="2019">2019</option>
                        <option value="2020">2020</option>
                    </select>
                    <b>To:</b>
                    <select class="year-end">
                        <option value="2015">2015</option>
                        <option value="2016">2016</option>
                        <option value="2017">2017</option>
                        <option value="2018">2018</option>
                        <option value="2019">2019</option>
                        <option value="2020">2020</option>
                    </select>
                </li>
            @endif
        </ul>
</div>
<div class="col-md-1">
    <button class="apply-filters">Apply</button>
</div>
</div>

