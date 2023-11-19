<x-app-layout>
    <div class="pcoded-main-container">
        <div class="pcoded-content">
            <x-breadcrumb title="{{ $customer->name }} Contacts" :button="[
                'name' => 'Add',
                'allow' => true,
                'link' => route('customer-contacts.create', ['id' => $customer->uuid]),
            ]" />

            <div class="row">
                <div class="col-xl-12 col-md-12">
                    <div class="card user-profile-list">
                        <div class="card-body-dd theme-tbl">
                            <x-table action="false" :keys="['Name', 'Email', 'Phone', 'Status', '']" />
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
                var datatable_url = route('customer-contacts.ajax') + '?id={{ request()->id }}';
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
