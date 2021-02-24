@if($periodType == "duration")
  <div class="form-group row data-start-date">
    <label for="start-date" class="col-sm-2 col-form-label">Start Date</label>
    <div class="col-sm-12">
        <input value="{{$start_date}}" data-date-format="MM dd, yyyy" id="start-date" name="startdate" class="form-control datepicker" >
    </div>
  </div>
  <div class="form-group row data-end-date">
    <label for="date-period" class="col-sm-2 col-form-label">End Date</label>
    <div class="col-sm-12">
        <input value="{{$end_date}}" data-date-format="MM dd, yyyy" id="end-date" name="enddate" class="form-control datepicker" >
    </div>
  </div>
@else
  <div class="form-group row data-instant">
    <label for="instant" class="col-sm-2 col-form-label">Instant</label>
    <div class="col-sm-12">
        <input value="{{$end_date}}" data-date-format="MM dd, yyyy" id="instant" name="instant" class="form-control datepicker" >
    </div>
  </div>
@endif
