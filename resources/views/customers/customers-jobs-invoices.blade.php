<x-app-layout>
    <div class="pcoded-main-container">
        <div class="pcoded-content">
            <x-breadcrumb title="Customers Jobs Invoices"/>
             <div class="row">
            <div class="col-xl-12 col-md-12">
                <div class="card user-profile-list">
                    <div class="card-body-dd theme-tbl">
                        <x-table action="false" checkbox="false" :keys="[
                                'Service Name',
                                'Customer Name',
                                'Technician Name',
                                'Total',
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
                    data: 'service_name'
                },
                {
                    data: 'customer_name'
                },
                {
                    data: 'technician_name'
                },
                {
                    data: 'total'
                }
            ];

            create_datatables(datatable_url, datatable_columns);
        });
        </script>
    @endpush


</x-app-layout>
