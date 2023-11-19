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
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="NewJobModalLabel">NEW JOB</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="newJobForm" action="{{ route('jobs.store') }}">

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
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn  btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn  btn-primary btn-create-job">Save</button>
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

        </script>
    @endpush


</x-app-layout>
