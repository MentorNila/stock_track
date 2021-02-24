<div class="modal-dialog modal-lg" role="document" style="margin-top: 15%;">
    <div class="modal-content">
        <div class="modal-body">
            <form id="attributesForm">
                <div class="row">
                    <div class="col-md-4 nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        @if(isset($level) && in_array($level, ['1','2','3']))
                            <a class="nav-link active" id="v-pills-section-tab" data-toggle="pill" href="#v-pills-section" role="tab" aria-controls="v-pills-section" aria-selected="false">Add Section\Subsection</a>
                            <a class="nav-link" id="v-abstract" data-toggle="pill" href="#v-pills-abstract" role="tab" aria-controls="v-pills-abstract" aria-selected="false">Select Abstract</a>
                            <a class="nav-link" id="v-pills-table-tab" data-toggle="pill" href="#v-pills-table" role="tab" aria-controls="v-pills-table" aria-selected="false">Select a Table Concept</a>
                        @endif
                        <a class="nav-link @if(!isset($level) || !in_array($level, ['1','2','3'])) active @endif" id="v-pills-tag-tab" data-toggle="pill" href="#v-pills-tag" role="tab" aria-controls="v-pills-tag" aria-selected="true">Select Tag</a>
                        <a class="nav-link @if(isset($empty)) suggest-dates @endif" id="v-pills-dates-tab" data-toggle="pill" href="#v-pills-dates" role="tab" aria-controls="v-pills-dates" aria-selected="false">Select Period</a>
                        <a class="nav-link" id="v-pills-labels-tab" data-toggle="pill" href="#v-pills-labels" role="tab" aria-controls="v-pills-labels" aria-selected="false">Labels</a>
                        <a class="nav-link" id="v-pills-dimensions-tab" data-toggle="pill" href="#v-pills-dimensions" role="tab" aria-controls="v-pills-dimensions" aria-selected="false">Select Axis</a>
                    </div>
                    <div class="col-md-8 tab-content" id="v-pills-tabContent">
                        @if(isset($level) && in_array($level, ['1','2','3']))
                            <div class="tab-pane fade show active" id="v-pills-section" role="tabpanel" aria-labelledby="v-pills-section-tab">
                                <label for="tag">Select or Create a new section</label>
                                <div class="form-group">
                                    <input id="section" name="section" class="form-control" value="@if(isset($section)){{$section}}@endif">
                                </div>
                                <label for="sections">Parent</label>
                                <div class="form-group">
                                    <select name="parent" id="sections" class="form-control">
                                        <option disabled selected>Select parent</option>
                                    </select>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="v-pills-abstract" role="tabpanel" aria-labelledby="v-abstract">
                                <label for="taxonomy-reference">Select Abstract</label>
                                <div class="form-group">
                                    <input id="taxonomy-reference" name="abstract" class="form-control" value="@if(isset($abstract)){{$abstract}}@endif" style="display: inline; width: 90%">
                                    <i class="bx bx-plus get-selected-tag" aria-hidden="true" style="padding-top: 10px;cursor:pointer;"></i>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="v-pills-table" role="tabpanel" aria-labelledby="v-pills-table-tab">
                                <label for="table-concept">Table Concept</label>
                                <div class="form-group">
                                    <input id="table-concept" name="table" class="form-control" value="@if(isset($table)){{$table}}@endif" style="display: inline; width: 90%">
                                    <i class="bx bx-plus get-selected-tag" aria-hidden="true" style="padding-top: 10px;cursor:pointer;"></i>
                                </div>
                                <label for="line-item">Line Item</label>
                                <div class="form-group">
                                    <input id="line-item" name="lineitem" class="form-control" value="@if(isset($lineitem)){{$lineitem}}@endif" style="display: inline; width: 90%">
                                    <i class="bx bx-plus get-selected-tag" aria-hidden="true" style="padding-top: 10px;cursor:pointer;"></i>
                                </div>
{{--                                <div class="form-group row">--}}
{{--                                    <div class="col-sm-12">--}}
{{--                                        <div class="row">--}}
{{--                                            <div id="table-concept-data" class="col-sm-12" style="height: 200px;overflow-y: scroll;">--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                            </div>
                        @endif
                        <div class="tab-pane fade @if(!isset($level) || !in_array($level, ['1','2','3'])) show active @endif" id="v-pills-tag" role="tabpanel" aria-labelledby="v-pills-tag-tab">
                            <div class="search-area">
                                <label for="tag">Tag</label>
                                <div class="form-group">
                                    @if(isset($tag))
                                        <input style="width: 80%; display: inline" class="form-control search-input clearable x" type="text" placeholder="Search" readonly aria-label="Search" id="tag" name="tag" value="{{$tag}}">
                                    @else
                                        <input style="width: 80%; display: inline" class="form-control search-input clearable" type="text" placeholder="Search" aria-label="Search" id="tag" name="tag" value="">
                                    @endif
                                    <i id="show-attributes" style="padding-left: 5px;cursor:pointer;" class="bx bx-info-circle" aria-hidden="true"></i>
                                    <i id="hide-attributes" style="padding-left: 5px;cursor:pointer;display: none;" class="bx bx-info-circle" aria-hidden="true"></i>
                                    <i class="bx bx-plus get-selected-tag" aria-hidden="true" style="padding-top: 10px;cursor:pointer;"></i>
                                    <i class="bx bx-search tag-search" style="cursor:pointer;"  aria-hidden="true"></i>
                                </div>

                                <div class="search-results" style="display: none;">
                                    <label>Results</label>
                                    <div class="form-group results" style="height: 200px;overflow-y: scroll;">
                                    </div>
                                </div>
                            </div>
                            <div class="" id="sum-input" style="">
                                @if(isset($sum))
                                    <label for="sums">Sum to</label>
                                    <div class="form-group">
                                        <input id="sums" name="sum" style="width: 65%; display: inline"  class="form-control" value="{{$sum}}">
                                        <i class="bx bx-plus get-selected-tag" aria-hidden="true" style="padding-top: 10px;cursor:pointer;"></i>
                                        <button type="button" style="margin-left: 30px;" class="btn btn-danger" id="remove-sum">Delete</button>
                                    </div>
                                @endif
                            </div>
                            <label for="fact">Fact</label>
                            <div class="form-group">
                                <input type="text" id="fact" name="fact" class="form-control" value="@if(isset($fact)){{$fact}}@endif">
                            </div>
                            <div class="checkbox">
                                <input id="data-parenthetical" type="checkbox" name="parenthetical" @if(isset($parenthetical)) checked @endif id="data-parenthetical">
                                <label for="data-parenthetical">Parenthetical</label>
                            </div>
                            <div id="value-sign" style="margin-top: 15px;">
                                @if(isset($signvalue))
                                    <label for="fact" style="display: block;">Value sign</label>
                                    <div class="custom-control custom-radio" style="display: inline;">
                                        <input type="radio" class="custom-control-input" value="positive" name="signvalue" id="positive" @if($signvalue=='positive') checked @endif>
                                        <label class="custom-control-label" for="positive">Positive</label>
                                    </div>
                                    <div class="custom-control custom-radio" style="display: inline;">
                                        <input type="radio" class="custom-control-input" value="negative" name="signvalue" id="negative" @if($signvalue=='negative') checked @endif>
                                        <label class="custom-control-label" for="negative">Negative</label>
                                    </div>
                                @endif
                            </div>
                            <button style="@if(isset($sum)) display:none; @endif" type="button" class="btn btn-primary" id="add-sum">Add Sum</button>
                            <div class="attributes-content" style="margin-top: 30px;display:table;"></div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-labels" role="tabpanel" aria-labelledby="v-pills-labels-tab">
                            <div class="label-content">
                                @if(isset($labels) && !empty($labels))
                                    @foreach($labels as $key => $label)
                                        @if(isset($label['name']))
                                            <div class="label" style="padding: 10px; margin-bottom: 10px;border: 1px solid #0574f0!important;" data-id="{{$key}}" >
                                                <label for="labels[{{$key}}][label]">Label</label>
                                                <div class="form-group">
                                                    <input type="text" name="labels[{{$key}}][name]" id="labels[{{$key}}][label]" class="form-control label-value" value="{{$label['name']}}">
                                                </div>
                                                <label for="labels[{{$key}}][type]">Label Type</label>
                                                <div class="form-group">
                                                    <select name="labels[{{$key}}][type]" id="labels[{{$key}}][type]" class="form-control type-value">
                                                        @foreach($labelsTypes as $type => $name)
                                                            <option value="{{$type}}" @if($type == $label['type']) selected @endif>{{$name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="checkbox">
                                                    <input type="checkbox" name="labels[{{$key}}][preferred]" id="labels[{{$key}}][preferred]" class="preferred-value" {{isset($label['preferred']) ? 'checked' : ''}}>
                                                    <label for="labels[{{$key}}][preferred]">Preferred Label</label>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                            <button type="button" class="btn btn-primary" id="add-label">Add Label</button>
                        </div>
                        <div class="tab-pane fade" id="v-pills-dimensions" role="tabpanel" aria-labelledby="v-pills-dimensions-tab">
                            <div class="axis-content">
                                @if(isset($dimensions) && !empty($dimensions))
                                    @foreach($dimensions as $key => $dimension)
                                        <div class="axis" style="padding: 10px; margin-bottom: 10px;border: 1px solid #0574f0!important;" data-id="{{$key}}">
                                            <div class="search-area">
                                                <label for="dimensions[{{$key}}][axis]">Axis</label>
                                                <div class="form-group">
                                                    @if(isset($dimension['axis']))
                                                        <input name="dimensions[{{$key}}][axis]" id="dimensions[{{$key}}][axis]" class="form-control search-input clearable x" value="{{$dimension['axis']}}" readonly style="display: inline; width: 90%">
                                                    @else
                                                        <input name="dimensions[{{$key}}][axis]" id="dimensions[{{$key}}][axis]" class="form-control search-input clearable" value="" style="display: inline; width: 90%">
                                                    @endif
                                                    <i class="bx bx-plus get-selected-tag" aria-hidden="true" style="padding-top: 10px;cursor:pointer;"></i>
                                                    <i class="bx bx-search tag-search" style="cursor:pointer;"  aria-hidden="true"></i>
                                                </div>
                                                <div class="search-results" style="display: none;">
                                                    <label>Results</label>
                                                    <div class="form-group results" style="height: 200px;overflow-y: scroll;">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="search-area">
                                                <label for="dimensions[{{$key}}][domain]">Domain</label>
                                                <div class="form-group">
                                                    @if(isset($dimension['domain']))
                                                        <input name="dimensions[{{$key}}][domain]" id="dimensions[{{$key}}][domain]" class="form-control search-input clearable x" readonly value="{{$dimension['domain']}}" style="display: inline; width: 90%">
                                                    @else
                                                        <input name="dimensions[{{$key}}][domain]" id="dimensions[{{$key}}][domain]" class="form-control search-input clearable" value="" style="display: inline; width: 90%">
                                                    @endif
                                                    <i class="bx bx-plus get-selected-tag" aria-hidden="true" style="padding-top: 10px;cursor:pointer;"></i>
                                                    <i class="bx bx-search tag-search" style="cursor:pointer;"  aria-hidden="true"></i>
                                                </div>
                                                <div class="search-results" style="display: none;">
                                                    <label>Results</label>
                                                    <div class="form-group results" style="height: 200px;overflow-y: scroll;">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="search-area">
                                                <label for="dimensions[{{$key}}][member]">Member</label>
                                                <div class="form-group">
                                                    @if(isset($dimension['member']))
                                                        <input name="dimensions[{{$key}}][member]" id="dimensions[{{$key}}][member]" class="form-control search-input  clearable x" readonly  value="{{$dimension['member']}}" style="display: inline; width: 90%">
                                                    @else
                                                        <input name="dimensions[{{$key}}][member]" id="dimensions[{{$key}}][member]" class="form-control search-input  clearable" readonly  value="" style="display: inline; width: 90%">
                                                    @endif
                                                    <i class="bx bx-plus get-selected-tag" aria-hidden="true" style="padding-top: 10px;cursor:pointer;"></i>
                                                    <i class="bx bx-search tag-search" style="cursor:pointer;"  aria-hidden="true"></i>
                                                </div>
                                                <div class="search-results" style="display: none;">
                                                    <label>Results</label>
                                                    <div class="form-group results" style="height: 200px;overflow-y: scroll;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <button type="button" class="btn btn-primary" id="add-axis">Add Axis</button>
                        </div>
                        <div class="tab-pane fade" id="v-pills-dates" role="tabpanel" aria-labelledby="v-pills-dates-tab">
                            <div class="periods-content">
                                @if(isset($startdate))
                                    <div class="form-group row data-start-date">
                                        <label for="start-date" class="col-sm-2 col-form-label">Start Date</label>
                                        <div class="col-sm-12">
                                            <input value="{{$startdate}}" data-date-format="MM dd, yyyy" id="start-date" name="startdate" class="form-control datepicker" >
                                        </div>
                                    </div>
                                    <div class="form-group row data-end-date">
                                        <label for="date-period" class="col-sm-2 col-form-label">End Date</label>
                                        <div class="col-sm-12">
                                            <input value="{{$enddate}}" data-date-format="MM dd, yyyy" id="end-date" name="enddate" class="form-control datepicker" >
                                        </div>
                                    </div>
                                @elseif(isset($instant))
                                    <div class="form-group row data-instant">
                                        <label for="data-instant" class="col-sm-2 col-form-label">Instant</label>
                                        <div class="col-sm-12">
                                            <input @if($instant) value="{{$instant}}" @else value="{{$instant}}" @endif data-date-format="MM dd, yyyy" id="data-instant" name="instant" class="form-control datepicker" >
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <button type="button" class="btn btn-primary" id="suggest-dates">Suggest Dates</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-light-secondary" data-dismiss="modal" id="discardTag">
                <i class="bx bx-x d-block d-sm-none"></i>
                <span class="d-none d-sm-block">Close</span>
            </button>
            <button type="button" class="btn btn-danger" data-dismiss="modal" id="deleteTag">
                <i class="bx bx-x d-block d-sm-none"></i>
                <span class="d-none d-sm-block">Delete Tag</span>
            </button>
            <button type="button" class="btn btn-primary" id="saveTags">
                <i class="bx bx-check d-block d-sm-none"></i>
                <span class="d-none d-sm-block">Save Attributes</span>
            </button>
        </div>
    </div>
</div>
