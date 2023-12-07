<div class="form-group row">
    <label class="col-form-label col-lg-3 col-sm-12 text-lg-end">Date</label>
    <div class="col-lg-9 col-sm-12">
        <input type="date" class="form-control" name="JobEvent[date]" id="start_date">
    </div>
</div>

<div class="form-group row">
    <label class="col-form-label col-lg-3 col-sm-12 text-lg-end">Time</label>
    <div class="col-lg-9 col-sm-12">
        <input type="time" class="form-control" name="JobEvent[time]" id="start_time">
    </div>
</div>

<div class="form-group row">
    <label for="JobEvent_hours" class="job-length-label">Length</label>
    <select class="form-select" name="JobEvent[hours]" id="JobEvent_hours">
        @foreach([0,1,2,3,4,5,6,7,8,9,10,11,12] as $value)
            <option value="{{$value}}" {{$services->hours === $value ? 'selected':''}} >{{$value}} hr</option>
        @endforeach


    </select><select class="form-select" name="JobEvent[minutes]" id="JobEvent_minutes">
        @foreach([0,5,10,15,20,25,30,35,40,45,50,55] as $value)
            <option value="{{$value}}" {{$services->minutes === $value ? 'selected':''}} >{{$value}} mins</option>
        @endforeach

    </select></div>

<div class="form-group row">
    <label class="col-form-label col-lg-3 col-sm-12 text-lg-end">Repeat</label>
    <div class="col-lg-9 col-sm-12">


        <select name="JobEvent[recurrence][frequency]"  id="CustomerJob_customer_location_id">
            @foreach(['Not' =>'Does not repeat','Daily' =>'daily','Weekly'=>'Weekly','Monthly'=>'Monthly','Yearly'=>'Yearly'] as $key=>$value)
                <option value="{{$key}}" {{$services->repeat ===$key?'selected':''}}>{{$value}}</option>
            @endforeach

        </select>
    </div>
</div>
@if($services->repeat !=='Not')

    <div class="form-group row">
        <label for="JobEvent_hours" class="job-length-label">Every</label>
        <select class="form-select" name="JobEvent[recurrence][interval]" id="repeat_every">
            @for($i=0;$i<30;$i++)
                <option value="{{$i}}" {{$services->repeat_every === $i ? 'selected':''}} >{{$i}}</option>
            @endfor


        </select><input type="text" name="repeat_frequency" value="{{$services->repeat}}"></div>

    <div class="form-group row" style="display: block;">
        <label for="JobEvent_hours" class="job-length-label">Assign To</label>
        <select class="form-select" name="JobEvent[primary_schedule_id]" id="assign_to">
            @foreach($getTechnicians as $value)
                <option value="{{$value->id}}">{{$value->name}}</option>
            @endforeach


        </select>
    </div>
    <div class="form-group row" style="display: block;">
        <label for="JobEvent_hours" class="job-length-label">Recurring Job Status</label>
        <select class="form-select" name="JobEvent[always_confirmed]" id="recurring_status">
            <option value="0" selected="selected">Unconfirmed</option>
            <option value="1">Confirmed</option>
        </select>
    </div>
    <div class="form-group row" style="display: block;">
        <label for="JobEvent_hours" class="job-length-label">Job Status</label>
        <select class="form-select" name="CustomerJob[status]" id="job_status">
            <option value="0" selected="selected">Unconfirmed</option>
            <option value="1">Confirmed</option>
        </select>
    </div>
    <div class="form-group row" style="display: block;">
        <label for="JobEvent_hours" class="job-length-label">Locked</label>
        <select class="form-select" name="JobEvent[locked]" id="locked">
            <option value="0" selected="selected">Locked</option>
            <option value="1">Unlocked</option>
        </select>
    </div>

    <div class="form-group row" style="display: block;">
        <label for="JobEvent_hours" class="job-length-label">Notes</label>
        <textarea name="Note[note]"></textarea>
    </div>
@endif
























<script>
    var date = new Date();
    var currentDate = date.toISOString().substring(0,10);
    var currentTime = date.toISOString().substring(11,16);

    document.getElementById('start_date').value = currentDate;
    document.getElementById('start_time').value = currentTime;

</script>
