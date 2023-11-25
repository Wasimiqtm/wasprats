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
            {{--<a class="btn btn-primary" id="addPayment">Add Payment</a>--}}
            <x-breadcrumb title="{{ $user->name }} Payments" />

            <ul class="nav nav-pills mb-4 bg-white" id="myTab" role="tablist">

                <li class="nav-item">
                    <a class="nav-link text-uppercase {{$tab ==='all'?'active':''}}" href="{{ route('technician.amount.ajax', [$user->id]) . '?tab=all' }}">All Payments</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-uppercase {{$tab ==='full'?'active':''}}" href="{{route('technician.amount.ajax', [ $user->id ]) . '?tab=full' }}">Full Payments</a>
                </li>
                <li class="nav-item">
                    <a class=" nav-link text-uppercase {{$tab ==='partial'?'active':''}}" href="{{route('technician.amount.ajax', [ $user->id ]) . '?tab=partial' }}">Partial Payments</a>
                </li>


            </ul>

            {{--@include('sections.customer-tabs')--}}
            <div class="row">
                <div style="margin: 20px 0px;">

                    <input type="text" name="daterange" value="" />
                </div>
                <div class="col-xl-12 col-md-12">
                    <div class="card user-profile-list">
                        <div class="card-body-dd theme-tbl">
                            <x-table action="false" checkbox="false" :keys="['Service Name','Customer','Payment Mode','Total Amount', 'Paid Amount', 'Date']" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.dataTablesFiles')

    {{--Modal window--}}

    @push('scripts')
        <script src="{{asset('js/plugins/highchart.min.js')}}"></script>
        <script src="{{asset('js/plugins/daterange-picker.js')}}"></script>
        <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.j"></script>
        <script type="text/javascript">
            $("document").ready(function() {
                var datatable_url = route('technician.amount.ajax', [{{ $user->id }}]) + '?tab={{ $tab }}';
                var datatable_columns = [
                    {
                        data: 'service.name'
                    },
                    {
                        data: 'customer.name'
                    },
                    {
                        data: 'payment_mode'
                    },
                    {
                        data: 'service.service_amount'
                    },
                    {
                        data: 'amount'
                    }/*,
                    {
                        data: 'amount'
                    }*/,
                    {
                        data: 'created_at'
                    }
                ];
                var start = moment().subtract(29, 'days');
                var endDate = moment();
                $('input[name="daterange"]').daterangepicker({
                    startDate: start,
                    endDate: endDate,

                });

                 create_datatables(datatable_url, datatable_columns,'','',10,'','',[],{start_date:start,end_date:endDate});
                $('input[name="daterange"]').on('apply.daterangepicker', function(ev, picker) {
                    var dataPOST = {start_date:picker.startDate,end_date:picker.endDate}
                    var   pageLength=10;
                    $('#datatable').DataTable().destroy();
                    var mytable = $('#datatable').DataTable({
                        oLanguage: { sProcessing: '<img src="'+ Ziggy.url +'/images/bx_loader.gif">' },
                        processing: true,
                        serverSide: true,
                        ordering: false,
                        responsive: true,
                        pageLength: pageLength,
                        bLengthChange: (pageLength>0)?(pageLength==30?false:true):false,
                        paging: (pageLength>0)?true:false,
                        info: (pageLength>0)?(pageLength==30?false:true):false,
                        "ajax": {
                            "url": datatable_url,
                            type:'POST',
                            "data": function ( d ) {
                                return $.extend( {}, d, {
                                    "extra_search": JSON.stringify(dataPOST)
                                } );
                            }
                        }, columns: datatable_columns,
                        order: false,
                        drawCallback: function ( settings ) {

                        }
                    });

                });
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
