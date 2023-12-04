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
             <div class="row">
            <div class="col-xl-12 col-md-12">
                <div class="card user-profile-list">
                    <div class="card-body-dd theme-tbl">
                        <x-table action="false" checkbox="false" :keys="[
                                'Payments',
                                'Service Name',
                                'Customer Name',
                                'Technician Name',
                                'Status',
                            ]"/>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>

    @include('layouts.dataTablesFiles')

    @push('scripts')
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
                    data: 'status'
                }
            ];

            var table = create_datatables(datatable_url, datatable_columns);
            
            $('#datatable tbody').on('click', 'td span.details-control', function () {
                var tr = $(this).closest('tr');
                var row = table.row( tr );
                console.log(row);

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
    @endpush


</x-app-layout>
