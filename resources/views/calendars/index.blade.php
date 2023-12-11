<x-app-layout>

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/plugins/fullcalendar.css') }}">
    @endpush

    <div class="pcoded-main-container">
        <div class="pcoded-content">
            <x-breadcrumb title="Calendar" />

            <div class="row">
                <div class="col-xl-12 col-md-12">
                    <div class="card fullcalendar-card">
                        <div class="card-header">
                            <h5>Calendar</h5>
                        </div>
                        <div class="card-block">
                            <div class="row">
                                <div id='calendar' class='calendar table-bordered'></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="NewJobModal" role="dialog" aria-labelledby="NewJobModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="NewJobModalLabel">NEW JOB</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                {{-- <form id="newJobForm"> --}}
                <form id="jobId">
                    <div class="tab-pane active" id="job-details">
                            <input type="hidden" name="from" id="job_from" />
                        <div class="form-group row">
                             {!! Form::label('customer_id', 'Customer', ['class' => 'form-label required-input']) !!}
                            <select class=""   name="customer_id" id="customer_id">
                                        <option>Select Customer</option>
                                        @foreach($customers as $customer)
                                            <option value="{{$customer->uuid}}">{{$customer->first_name}}
                                                {{$customer->last_name}}</option>
                                        @endforeach
                            </select>
                           {{--  {!! Form::label('customer_id', 'Customer', ['class' => 'form-label required-input']) !!}
                            {!! Form::select('customer_id', $customers, null, [
                                'id' => 'customer_id',
                                'class' => 'form-control ' . $errors->first('customer_id', 'error'),
                            ]) !!}
                            {!! $errors->first('customer_id', '<label class="error">:message</label>') !!} --}}
                        </div>
                        <div id="locationContainer" class="form-group row">
                        </div>
                       {{--  <div class="form-group row">
                            <label class="col-form-label col-lg-3 col-sm-12 text-lg-end">Address</label>
                            <div class="col-lg-9 col-sm-12">
                                <select name="location" id="CustomerJob_customer_location_id">
                                    <option>Select Location</option>
                                    @foreach($customerLocation as $location)
                                        <option value="{{$location->id}}">{{$location->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div> --}}
                        <div class="form-group row">
                            <label class="col-form-label col-lg-3 col-sm-12 text-lg-end">Services</label>
                            <div class="col-lg-9 col-sm-12">
                                <select class=""   name="customer_job_service" id="CustomerJob_service_id">
                                    <option>Select Services</option>
                                    @foreach($services as $value)
                                        <option value="{{$value->id}}">{{$value->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div id="serviceView">

                        </div>




                    </div>
                </form>
            </div>
                   {{--  <form id="newJobForm" action="{{ route('jobs.store') }}">

                        <input type="hidden" name="from" id="job_from" />
                        <input type="hidden" name="to" id="job_to" />

                        <div class="form-group">
                            {!! Form::label('customer_id', 'Customer', ['class' => 'form-label required-input']) !!}
                            {!! Form::select('customer_id', $customers, null, [
                                'id' => 'customer_id',
                                'class' => 'form-control ' . $errors->first('customer_id', 'error'),
                            ]) !!}
                            {!! $errors->first('customer_id', '<label class="error">:message</label>') !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('service_id', 'Service', ['class' => 'form-label required-input']) !!}
                            {!! Form::select('service_id', $services, null, [
                                'id' => 'service_id',
                                'class' => 'form-control ' . $errors->first('service_id', 'error'),
                            ]) !!}
                            {!! $errors->first('service_id', '<label class="error">:message</label>') !!}
                        </div>
                    </form> --}}
               {{--  <div class="modal-footer">
                    <button type="button" class="btn  btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn  btn-primary btn-create-job">Save</button>
                </div> --}}
                <div class="modal-footer">
                    <button type="button" class="btn  btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn  btn-primary" id="saveJob">Save</button>
            </div>
                </div>
            </div>
        </div>
    </div>
<div class="modal fade " id="jobStatusupdate" tabindex="-1" aria-labelledby="myLargeModalLabel"
     style="display:none;" aria-modal="false" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h4" id="myLargeModalLabel">Update Job Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="jobStatusUpdate">
                    <input type="hidden" name="customer_id" value="{{request()->customer_id}}">
                            <input type="hidden" name="job_id" id="job_id" value="">

                    <div class="tab-pane active" id="job-details">

                        <div class="form-group row">
                            <label class="col-form-label col-lg-3 col-sm-12 text-lg-end">Status</label>
                            <div class="col-lg-9 col-sm-12">
                                <select name="job_status" id="job_status">
                                    <option value="">Select Status</option>
                                    <option value="active">Active</option>
                                    <option value="canceled">Canceled</option>
                                    <option value="completed">Completed</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            {{-- <div class="modal-footer">
                <button type="button" class="btn  btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn  btn-primary" id="updateJobStatus">Save</button>
            </div> --}}
            <div class="modal-footer">
                <button type="button" class="btn  btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn  btn-primary" id="saveJob">Save</button>
            </div>
        </div>
    </div>
</div>
    @php($yearMonth = date('Y-m'))
    @push('scripts')
        <script src="{{ asset('js/plugins/fullcalendar.min.js') }}"></script>
        <script type="text/javascript">
            $("document").ready(function() {

                $(document).on("click", ".btn-create-job", function(e) {
                    e.preventDefault();
                    const _self = $(this);
                    const _form = $('#newJobForm');
                    const formData = _form.serialize();

                    _self.LoadingOverlay('show');

                    $.ajax({
                        type: 'post',
                        url: route('jobs.store'),
                        processData: false,
                        dataType: 'json',
                        data: formData,
                        success: function(res) {
                            console.log(res);
                            if (res.success) {
                                successMessage(res.message);
                                calendar.addEvent(res.data.event);
                                $("#NewJobModal").modal('hide');
                            } else {
                                errorMessage(res.message);
                            }
                        },
                        error: function(request, status, error) {
                            showAjaxErrorMessage(request);
                        },
                        complete: function(res) {
                            _self.LoadingOverlay('hide');
                        }
                    });
                });

                // new FullCalendar.Draggable(document.getElementById("external-events"), {
                //     itemSelector: ".fc-event",
                //     eventData: function(e) {
                //         return {
                //             title: e.innerText,
                //         }
                //     }
                // });
                var calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'timeGridDay,timeGridWeek,dayGridMonth'
                    },
                    themeSystem: 'bootstrap',
                    defaultView: 'basicWeek',
                    initialDate: '{{ date('Y-m-d') }}',
                    slotDuration: '00:10:00',
                    navLinks: true,
                    droppable: true,
                    selectable: true,
                    selectMirror: true,
                    editable: true,
                    dayMaxEvents: true,
                    handleWindowResize: true,
                    html: true,
                    select: function(event) {
                        console.log('select event', event);
                        $("#job_from").val(event.startStr);
                        $("#job_to").val(event.endStr);
                        $("#NewJobModal").modal('show');
                    },
                    eventClick: function(event) {
                        console.log('event data', event);
                    },
                    eventDidMount: function(info) {
                        //console.log('info', info);
                        //const event = info.event._def;
                        // $(`.job-event-${event.publicId}`).find('.fc-event-time').html(event.extendedProps
                        //     .time);
                        // $(`.job-event-${event.publicId}`).find('.fc-event-title').html(event.title);
                    },
                    eventDrop: function(event) {
                        console.log('eventDrop', event);
                        updateJob(event.event);
                    },
                    eventResize: function(event) {
                        console.log('eventResize', event.event);
                        updateJob(event.event);
                    },
                    events: {!! $events !!}
                });
                calendar.render();

                $("#customer_id").select2({
                    dropdownParent: $("#NewJobModal")
                });
                $("#service_id").select2({
                    dropdownParent: $("#NewJobModal")
                });


                setTimeout($(".fc-timeGridWeek-button").click(), 3000);
            });

            function updateJob(event) {
                const jobId = event.id;
                const _self = $('.job-event-' + jobId);

                _self.LoadingOverlay('show');

                $.ajax({
                    type: 'post',
                    url: route('update-job'),
                    dataType: 'json',
                    data: {
                        id: jobId,
                        from: event.startStr,
                        to: event.endStr
                    },
                    success: function(res) {
                        console.log(res);
                        if (res.success) {
                            successMessage(res.message);
                        } else {
                            errorMessage(res.message);
                        }
                    },
                    error: function(request, status, error) {
                        showAjaxErrorMessage(request);
                    },
                    complete: function(res) {
                        _self.LoadingOverlay('hide');
                    }
                });
            }

$("body").on('click', "#addinvoice", function () {

            document.getElementById("jobId").reset();
            $("#serviceView").html('');
            $("#invoiceModal").modal('show')
        });
        $("body").on('click', ".editRecord", function () {
                $("#job_id").val($(this).attr('data-id'))
                $("#job_status").val($(this).attr('data-status'))
            $("#jobStatusupdate").modal('show')
        });

        $("body").on("click", "#saveJob", function () {

            $.ajax({
                url: '{{route('job.assign')}}',
                type: 'POST',
                "headers": {'X-CSRF-TOKEN': "{{csrf_token()}}"},
                data:$("#jobId").serialize(),
                success: function (data) {

                    $("#invoiceModal").modal('hide')
                    $("div.modal-backdrop").remove();
                    $("body").css({'overflow': 'auto', 'padding-right': '0px'});
                    window.location.reload();

                }
            })

        });
        $("body").on("click", "#updateJobStatus", function () {

            $.ajax({
                url: '{{route('update.customer.job')}}',
                type: 'POST',
                "headers": {'X-CSRF-TOKEN': "{{csrf_token()}}"},
                data:$("#jobStatusUpdate").serialize(),
                success: function (data) {

                    $("#jobStatusupdate").modal('hide')
                    $("div.modal-backdrop").remove();
                    $("body").css({'overflow': 'auto', 'padding-right': '0px'});
                    window.location.reload();

                }
            })

        });
        $("body").on('change','#CustomerJob_service_id',function(){
            var id = $(this).val();
            $.ajax({
                url: '{{route('service.info')}}',
                type: 'POST',
                "headers": {'X-CSRF-TOKEN': "{{csrf_token()}}"},
                data:{id:id},
                success: function (data) {
                    $("#serviceView").html('')
                    $('#serviceView').html(data)

                }
            })
        });
       $("body").on('change','#customer_id',function() {
            var id = $(this).val();
            $.ajax({
                url: '{{route('get.custmer.locations')}}',
                type: 'GET',
                "headers": {'X-CSRF-TOKEN': "{{csrf_token()}}"},
                data:{id:id},
                success: function (data) {
                    console.log('data',data)
                   displayLocations(data);
                }
            })
        });
       function displayLocations(locations) {
         if (locations && locations.length > 0) {
              var html = '<label class="form-label ">Address:</label><select id="locationSelect"  name="location">';
                $.each(locations, function(index, location) {
                    html += '<option value="' + location.id + '">' + location.name + '</option>';
                });
                html += '</select>';
                $('#locationContainer').html(html);
        } else {
        $('#locationContainer').html('<p>No locations available.</p>');
    }
        }
        </script>
    @endpush


</x-app-layout>
