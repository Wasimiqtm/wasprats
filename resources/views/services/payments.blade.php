<x-app-layout>

    <?php
        if (in_array($tab, ['completed', 'canceled'])) {
            $tab = $request->tab;
        } else {
            $tab = 'active';
        }
    ?>

    <div class="pcoded-main-container">
        <div class="pcoded-content">
            <a class="btn btn-primary" id="addPayment">Add Payment</a>
            <x-breadcrumb title="{{ $service->name }} Payments" />

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
                            <input type="hidden" id="service_id" name="customer_id" value="{{request()->service_id}}">

                            <div class="form-group">
                                <label class="form-label">Service Name</label>
                                <input type="text" class="form-control" readonly value="{{$service->name}}" id="serviceName">
                            </div>

                            <div class="form-group row">
                                <label class="form-label">Select Customer</label>
                                <div class="col-lg-12 col-sm-12">
                                    <select id="customerId" class="form-select">
                                        @foreach($customers as $value)
                                            <option value="{{$value->id}}">{{$value->first_name.' '.$value->last_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="form-label">Select User</label>
                                <div class="col-lg-12 col-sm-12">
                                    <select id="userId" class="form-select">
                                        @foreach($users as $value)
                                            <option value="{{$value->id}}">{{$value->name}}</option>
                                        @endforeach
                                    </select>
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
                                <label class="form-label">Amount</label>
                                <input type="number" class="form-control" placeholder="Amount" id="amount">
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
                var datatable_url = route('service.payments.ajax', [{{ $service->id }}]) + '?tab={{ $tab }}';
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
                /*var value1 = $("#exampleFormControlSelect1").val();*/
                var service_id = $("#service_id").val();
                var customerId = $("#customerId").val();
                var userId = $("#userId").val();
                var paymentMode = $("#paymentMode").val();
                var amount = $("#amount").val();
                var dated = $("#dated").val();
                var description = $("#description").val();
                $.ajax({
                    url: '{{route('add.service.payment')}}',
                    type: 'POST',
                    "headers": {'X-CSRF-TOKEN': "{{csrf_token()}}"},
                    data:{
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
