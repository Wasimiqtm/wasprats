<style>
    td span.details-control {
        background: url(../images/details_open.png) no-repeat center center;
        cursor: pointer;
        width: 18px;
        padding: 12px;
    }
    tr.shown td span.details-control {
        background: url(../images/details_close.png) no-repeat center center;
    }
</style>

<x-app-layout>
    <div class="pcoded-main-container">
        <div class="pcoded-content">
            <x-breadcrumb title="Customers Jobs Invoices"/>
            <div class="dropdown bg-white" style="display: flex;">
                <div class="mb-3">
                    <label for="select-technician" class="form-label">Select Technician</label>
                    <select id="technicianID" class="form-select"  onchange="clickUserTechnician()" >
                        <option value="null">Select Any Technician</option>
                        @foreach ($getTechnicians as $user)
                         <option value="{{$user->id}}">{{$user->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="select-technician" class="form-label">Select Customer</label>
                    <select id="customerId" class="form-select" onchange="clickUserCustomer()">
                        <option value="null">Select Any Customer</option>
                        @foreach ($customers as $customer)
                         <option value="{{$customer['id']}}">{{$customer['first_name']}} {{$customer['last_name']}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
             <div class="row">
                <div style="margin: 20px 0px;">
                    <input type="text" name="daterange" value="" />
                </div>
            <div class="col-xl-12 col-md-12">
                <div class="card user-profile-list">
                    <div class="card-body-dd theme-tbl">
                        <x-table action="false" checkbox="false" :keys="[
                                '',
                                'Service Name',
                                'Customer Name',
                                'Technician Name',
                                'Amount',
                                {{--'Payment',--}}
                                'Status',
                                'Created At'
                            ]"/>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>

    @include('layouts.dataTablesFiles')

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="{{asset('js/plugins/highchart.min.js')}}"></script>
        <script src="{{asset('js/plugins/daterange-picker.js')}}"></script>
        <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

        <script type="text/javascript">
            $("document").ready(function () {
            var datatable_url = route('customers.jobs.invoices.ajax');
            var datatable_columns = [{
                    data: 'payments'
                },{
                    data: 'services.name'
                },
                {
                    data: 'customer.name'
                },
                {
                    data: 'technician_name'
                },
                {
                    data: 'services.service_amount'
                },
                /*{
                    data: 'payment_status'
                },*/
                {
                    data: 'status'
                },
                {
                    data: 'created_at'
                }
            ];
            var start = moment().subtract(29, 'days');
            var endDate = moment();
            var techId = $("#technicianID option:selected" ).val();
            var customerId = $("#customerId option:selected" ).val();
                $('input[name="daterange"]').daterangepicker({
                    startDate: start,
                    endDate: endDate,

                });
                  var table = create_datatables(datatable_url, datatable_columns,'','',10,'','',[],{start_date:start,end_date:endDate, customer_id:customerId, user_tech_id:techId});

                $('input[name="daterange"]').on('apply.daterangepicker', function(ev, picker) {
                    var dataPOST = {start_date:picker.startDate,end_date:picker.endDate,user_tech_id:techId, customer_id:customerId}
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
            $('#datatable tbody').on('click', 'td span.details-control', function () {
                var tr = $(this).closest('tr');
                var row = table.row( tr );

                if ( row.child.isShown() ) {
                    row.child.hide();
                    tr.removeClass('shown');
                } else {
                    row.child( format(row.data()) ).show();
                    tr.addClass('shown');
                }
            });

            function format ( rowData ) {
                let div = $('<div/>').addClass( 'loading' ).text( 'Loading...' );

                let paymentHtml = `<h4>Payments</h4><table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Payment Amount</th>
                                            <th>Payment Mode</th>
                                            <th>Description</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>`;

                if(rowData.customer.service_payments.length > 0){
                    const payments = rowData.customer.service_payments;
                    console.log('payments',payments);
                    $.each(payments,function(index, payment){
                        paymentHtml += `<tr>
                            <td width="10%">${payment.amount}</td>
                            <td width="10%">${payment.payment_mode}</td>
                            <td>${payment.description}</td>
                            <td width="10%">${payment.date}</td>
                            <td width="10%"><a href="payment-invoice/${payment.id}" class="btn btn-icon btn-secondary"><i class="feather icon-user-check"></i></a></td>
                        </tr>`;
                    });
                } else {
                    paymentHtml += '<tr><td colspan="4">Record not found</td></tr> ';
                }

                paymentHtml += '</tbody></table>';

                div.html( paymentHtml ).removeClass( 'loading' );

                return div;
            }
        });
        </script>




        <script type="text/javascript">
            var datatable_url = route('customers.jobs.invoices.ajax');
            var datatable_columns = [{
                    data: 'payments'
                },{
                    data: 'services.name'
                },
                {
                    data: 'customer.name'
                },
                {
                    data: 'technician_name'
                },
                {
                    data: 'services.service_amount'
                },
                {
                    data: 'payment_status'
                },
                {
                    data: 'status'
                },
                {
                    data: 'created_at'
                }
            ];
            var get_customer_id = null;

            function clickUserCustomer() {
                var selectElement = document.getElementById("customerId");
                var selectedOption = selectElement.options[selectElement.selectedIndex];
                var selectedCustomerValue = selectedOption.value;
             get_customer_id = selectedCustomerValue

            var techId = $("#technicianID option:selected" ).val();
            [startDate, endDate] = $('input[name="daterange"]').val().split(' - ');

                    var dataPOST = {start_date:startDate,end_date:endDate,user_tech_id:techId, customer_id:get_customer_id}
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
            }

     function clickUserTechnician() {
        var selectElement = document.getElementById("technicianID");
        var selectedOption = selectElement.options[selectElement.selectedIndex];
        var selectedTechnicianValue = selectedOption.value;
           var  get_user_tech_id = selectedTechnicianValue
           var customerId = $("#customerId option:selected" ).val();
            [startDate, endDate] = $('input[name="daterange"]').val().split(' - ');
                    var dataPOST = {start_date:startDate,end_date:endDate, customer_id:customerId,user_tech_id:get_user_tech_id}
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
            }
        </script>
    @endpush


</x-app-layout>
