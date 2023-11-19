<x-app-layout>
    <div class="pcoded-main-container">
        <div class="pcoded-content">
            <x-breadcrumb title="Customers" :button="['name' => 'Add', 'allow' => true, 'link' => route('customers.create')]" />

            <div class="row">
                <div class="col-xl-12 col-md-12">
                    <div class="card user-profile-list">
                        <div class="card-body-dd theme-tbl">
                            <x-table action="false" checkbox="false" :keys="['Name', 'Account #', 'Email', 'Phone', 'Company Name', 'Status', '']" />
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
                var datatable_url = route('customers.ajax');
                var datatable_columns = [{
                        data: 'name'
                    },
                    {
                        data: 'account_no'
                    },
                    {
                        data: 'email'
                    },
                    {
                        data: 'phone'
                    },
                    {
                        data: 'company_name'
                    },
                    {
                        data: 'is_active',
                        width: '5%',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        width: '5%',
                        orderable: false,
                        searchable: false
                    }
                ];

                create_datatables(datatable_url, datatable_columns);
            });
        </script>
    @endpush


</x-app-layout>
