<div class="main-container">
    <div class="pcoded-content">
        <a class="btn btn-primary" href="{{ route('job.invoice', request()->id)}}">Print Invoice</a><br /><br />
        <div class="row">
            <div class="col-xl-12 col-md-12">
                <div class="card user-profile-list">
                    <div class="card-body-dd theme-tbl">
                        <x-table action="false" checkbox="false" :keys="[
                                'Service Name',
                                'Amount',
                                'Tax (%)',
                                'Total',
                                'Customer Name',
                                'Status',
                                'Items Invoice',
                                ''
                            ]"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('layouts.dataTablesFiles')

@push('scripts')

    <script>
        $("document").ready(function () {
            var datatable_url = route('users.get.active.jobs');
            datatable_url =`${datatable_url}?id=`+"{{request()->id}}"+"&type={{request()->type ??'active'}}"

            var datatable_columns = [{
                data: 'service_name'
            },{
              data: 'service_amount'
            },
                {
                    data: 'tax'
                },
                {
                    data: 'total_amount'
                },
                {
                    data: 'customer.name'
                },
                {
                    data: 'status'
                },
                {
                    data: 'items_invoice'
                },
                {
                    data: 'action',
                    orderable: false,
                    searchable: false
                }
            ];

            create_datatables(datatable_url, datatable_columns);
        });



    </script>
@endpush


