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
            <div class="dropdown bg-white">
  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButtond" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Select Customer 
  </button>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButtond">
    @foreach ($customers as $customer)
    <button class="dropdown-item" onClick="clickCustomer({{$customer['id']}})">{{$customer['first_name']}} {{$customer['last_name']}}</button>
    @endforeach
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
                                'Payments',
                                'Service Name',
                                'Customer Name',
                                'Technician Name',
                                'Payment Status',
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
                    data: 'payment_status'
                },
                {
                    data: 'status'
                },
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
                  var table = create_datatables(datatable_url, datatable_columns,'','',10,'','',[],{start_date:start,end_date:endDate, customer_id:null});
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
            $('#datatable tbody').on('click', 'td span.details-control', function () {
                var tr = $(this).closest('tr');
                var row = table.row( tr );
                console.log('asad',row);

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
                                        
                if(rowData.services.service_payment.length > 0){
                    const payments = rowData.services.service_payment;
      
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
            function clickCustomer(customer_id){
             get_customer_id = customer_id
             {
                    var dataPOST = {start_date:null,end_date:null, customer_id:get_customer_id}
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
            }
        </script>
    @endpush


</x-app-layout>
