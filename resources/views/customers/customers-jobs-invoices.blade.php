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
                    data: 'service_name'
                },
                {
                    data: 'customer_name'
                },
                {
                    data: 'technician_name'
                },
                {
                    data: 'status'
                }
            ];

            create_datatables(datatable_url, datatable_columns);
        });
        </script>
    @endpush


</x-app-layout>
