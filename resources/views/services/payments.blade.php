<x-app-layout>

    <?php
        if (in_array($tab, ['full', 'partial'])) {
            $tab = $request->tab;
        } else {
            $tab = 'all';
        }
    ?>

    <div class="pcoded-main-container">
        <div class="pcoded-content">
            <a class="btn btn-primary" id="addPayment">Add Payment</a>
            <x-breadcrumb title="{{ $job->services->name }} Payments" />
            <ul class="nav nav-pills mb-4 bg-white" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link text-uppercase {{$tab ==='all'?'active':''}}" href="{{ route('service.payments.ajax', [$job->id]) . '?tab=all' }}">All Payments</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-uppercase {{$tab ==='full'?'active':''}}" href="{{route('service.payments.ajax', [ $job->id ]) . '?tab=full' }}">Full Payments</a>
                </li>
                <li class="nav-item">
                    <a class=" nav-link text-uppercase {{$tab ==='partial'?'active':''}}" href="{{route('service.payments.ajax', [ $job->id ]) . '?tab=partial' }}">Partial Payments</a>
                </li>

            </ul>

            {{--@include('sections.customer-tabs')--}}

            <div class="row">
                <div class="col-xl-12 col-md-12">
                    <div class="card user-profile-list">
                        <div class="card-body-dd theme-tbl">
                            <x-table action="false" checkbox="false" :keys="['Service Name', 'Customer', 'Technician', 'Payment Mode', 'Amount Paid', 'Data']" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.dataTablesFiles')

    {{--Modal window--}}
    <div class="modal fade bd-example-modal-lg" id="paymentModal" tabindex="-1" aria-labelledby="myLargeModalLabel"
             style="display:none;" aria-modal="false" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title h4" id="myLargeModalLabel">Add Payment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="credit">

                            <input type="hidden" id="schedule_job_id" name="customer_id" value="{{$job->id}}">
                            <div class="form-group">
                                <label class="form-label">Service Name</label>
                                <input type="hidden" id="service_id" name="customer_id" value="{{$job->services->id}}">
                                <input type="text" class="form-control" readonly value="{{$job->services->name}}">
                            </div>

                            <div class="form-group">
                                <label class="form-label">Select Customer</label>
                                <input type="hidden" id="customerId" name="customer_id" value="{{$job->customer->id}}">
                                <input type="text" class="form-control" readonly value="{{$job->customer->name}}">
                            </div>

                            <div class="form-group">
                                <label class="form-label">Select User</label>
                                <div class="col-lg-12 col-sm-12">
                                    <input type="hidden" id="userId" name="customer_id" value="{{$job->schedule->user->id}}">
                                    <input type="text" class="form-control" readonly value="{{$job->schedule->user->name}}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="exampleFormControlSelect1">Payment Mode</label>
                                <select class="form-select" id="paymentMode">
                                    <option value="full">Full</option>
                                    <option value="partial">Partial</option>
                                </select>

                            </div>

                            <div class="form-group">
                                <label class="form-label">Amount Payable</label>
                                <input type="text" class="form-control" readonly value="{{$job->services->service_amount}}">
                            </div>

                            <div class="form-group">
                                <label class="form-label">Pay Amount</label>
                                <input type="number" max="{{$job->services->service_amount}}" class="form-control" placeholder="Amount" id="amount">
                            </div>

                            <div class="form-group">
                                <label class="form-label">Description</label>
                                <textarea id="description" class="form-control" name="description" rows="3"></textarea>
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn  btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn  btn-primary" id="savePayment">Save</button>
                    </div>
                </div>
            </div>
        </div>
    @push('scripts')
        <script type="text/javascript">
            $("document").ready(function() {
                var datatable_url = route('service.payments.ajax', [{{ $job->services->id }}]) + '?tab={{ $tab }}';
                var datatable_columns = [{
                        data: 'service.name'
                    },
                    {
                        data: 'customer.name'
                    },
                    {
                        data: 'user.name'
                    },
                    {
                        data: 'payment_mode'
                    },
                    {
                        data: 'amount'
                    },
                    {
                        data: 'created_at'
                    }
                ];

                create_datatables(datatable_url, datatable_columns);

                /*open modal for adding payment*/
                $("body").on('click', "#addPayment", function () {
                    $("#paymentModal").modal('show')
                });
            });

            $("body").on('click','#savePayment',function(){
                var schedule_job_id = $("#schedule_job_id").val();
                var service_id = $("#service_id").val();
                var customerId = $("#customerId").val();
                var userId = $("#userId").val();
                var paymentMode = $("#paymentMode").val();
                var amount = $("#amount").val();
                var description = $("#description").val();
                $.ajax({
                    url: '{{route('add.service.payment')}}',
                    type: 'POST',
                    "headers": {'X-CSRF-TOKEN': "{{csrf_token()}}"},
                    data:{
                        schedule_job_id:schedule_job_id,
                        service_id:service_id,
                        customer_id: customerId,
                        user_id: userId,
                        payment_mode: paymentMode,
                        amount:amount,
                        description:description
                    },
                    success:function(){
                        $("#paymentModal").modal('hide')
                        $("div.modal-backdrop").remove();
                        $("body").css({'overflow': 'auto', 'padding-right': '0px'});
                        window.location.reload();
                    }
                });
            });
        </script>
    @endpush


</x-app-layout>
