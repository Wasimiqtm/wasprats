<div class="main-container">
    <div class="pcoded-content">
        <a class="btn btn-primary" id="addinvoice">New Job</a>

        <div class="row">
            <div class="col-xl-12 col-md-12">
                <div class="card user-profile-list">
                    <div class="card-body-dd theme-tbl">
                        <x-table action="false" checkbox="false" :keys="[
                                'Service Name',
                                'Job Frequency',
                                {{--'Invoice Frequency',--}}
                                'Assigned To',
                                'Amount',
                                'Tax',
                                'Total',
                                'Action'
                            ]"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('layouts.dataTablesFiles')
<div class="modal fade bd-example-modal-lg" id="invoiceModal" tabindex="-1" aria-labelledby="myLargeModalLabel"
     style="display:none;" aria-modal="false" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h4" id="myLargeModalLabel">Create New Job</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="jobId">
                    <input type="hidden" name="customer_id" value="{{request()->customer_id}}">

                    <div class="tab-pane active" id="job-details">
                        <div class="form-group row">
                            <label class="col-form-label col-lg-3 col-sm-12 text-lg-end">Customer</label>
                            <div class="col-lg-9 col-sm-12">
                                <input type="text" class="form-control " id="task_name" placeholder="Customer Search" value="{{$customer->name}}" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-3 col-sm-12 text-lg-end">Address</label>
                            <div class="col-lg-9 col-sm-12">
                                <select name="location" id="CustomerJob_customer_location_id">
                                    <option>Select Location</option>
                                    @foreach($customerLocation as $location)
                                        <option value="{{$location->id}}">{{$location->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
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
            <div class="modal-footer">
                <button type="button" class="btn  btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn  btn-primary" id="saveJob">Save</button>
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
            <div class="modal-footer">
                <button type="button" class="btn  btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn  btn-primary" id="updateJobStatus">Save</button>
            </div>
        </div>
    </div>
</div>
@push('scripts')

    <script>
        $("document").ready(function () {
            var datatable_url = route('customers.job.details');
            datatable_url =`${datatable_url}?customer_id=`+"{{request()->customer_id}}"

            var datatable_columns = [{
                data: 'service_name'
            },
                {
                    data: 'job_frequency'
                },
                /*{
                    data: 'invoice_frequency'
                },*/
                {
                    data: 'assigned_to'
                },
                {
                    data: 'total'
                },
                {
                    data: 'tax'
                },
                {
                    data: 'total_amount'
                },
                {
                    data: 'action'
                }
            ];

            create_datatables(datatable_url, datatable_columns);
        });
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
        })
    </script>
@endpush


