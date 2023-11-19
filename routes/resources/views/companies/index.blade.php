<x-app-layout>
    <div class="pcoded-main-container">
        <div class="pcoded-content">
            <x-breadcrumb title="Companies" :button="['name' => 'Add', 'allow' => true, 'link' => route('companies.create')]" />

            <div class="row">
                <div class="col-xl-12 col-md-12">
                    <div class="card user-profile-list">
                        <div class="card-body-dd theme-tbl">
                            <x-table action="false" checkbox="false" :keys="[
                                'Name',
                                'Email',
                                'Phone',
                                'License',
                                'Address',
                                'City',
                                'State',
                                'Zip',
                                'Status',
                                '',
                            ]" />
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
                var datatable_url = route('companies.ajax');
                var datatable_columns = [{
                        data: 'name'
                    },
                    {
                        data: 'email'
                    },
                    {
                        data: 'phone'
                    },
                    {
                        data: 'license'
                    },
                    {
                        data: 'address'
                    },
                    {
                        data: 'city'
                    },
                    {
                        data: 'state'
                    },
                    {
                        data: 'zip'
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
