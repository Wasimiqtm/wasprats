<x-app-layout>
    <div class="pcoded-main-container">
        <div class="pcoded-content">
            <x-breadcrumb title="Services" :button="['name' => 'Add', 'allow' => true, 'link' => route('services.create')]" />

            <div class="row">
                <div class="col-xl-12 col-md-12">
                    <div class="card user-profile-list">
                        <div class="card-body-dd theme-tbl">
                            <x-table action="false" checkbox="false" :keys="['Name', 'Amount', 'Length', 'Repeat', 'Except', 'Job Status', 'Status', '']" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.dataTablesFiles')

    @push('scripts')
        <script type="text/javascript">
            $("document").ready(function() {
                var datatable_url = route('services.ajax');
                var datatable_columns = [{
                        data: 'name'
                    },
                    {
                        data: 'service_amount'
                    },
                    {
                        data: 'length_completed',
                        width: '15%',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'repeat',
                        width: '5%'
                    },
                    {
                        data: 'except_completed',
                        width: '15%',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'job_status',
                        width: '5%'
                    },
                    {
                        data: 'is_active',
                        width: '10%',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        width: '7%',
                        orderable: false,
                        searchable: false
                    }
                ];

                create_datatables(datatable_url, datatable_columns);
            });
        </script>
    @endpush


</x-app-layout>
