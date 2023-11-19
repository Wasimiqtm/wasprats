<x-app-layout>
    <div class="pcoded-main-container">
        <div class="pcoded-content">
            <x-breadcrumb title="{{ $customer->name }} Contacts" :button="[
                'name' => 'Add',
                'allow' => true,
                'link' => route('customer-locations.create', ['id' => $customer->uuid]),
            ]" />

            @include('sections.customer-tabs')

            <div class="row">
                <div class="col-xl-12 col-md-12">
                    <div class="card user-profile-list">
                        <div class="card-body-dd theme-tbl">
                            <x-table action="false" :keys="['Address Name', 'Street', 'City', 'State', 'Zip', 'Status', '']" />
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
                var datatable_url = route('customer-locations.ajax', ['{{ $customer->uuid }}']);
                var datatable_columns = [{
                        data: 'name'
                    },
                    {
                        data: 'street'
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
