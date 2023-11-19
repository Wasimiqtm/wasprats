<x-app-layout>
    <!-- [ Main Content ] start -->
    <div class="pcoded-main-container">
        <div class="pcoded-content">
            <!-- [ breadcrumb ] start -->
            <x-breadcrumb title="Roles" :button="['name' => 'Add', 'allow' => true, 'link' => route('roles.create')]" />
            <!-- [ breadcrumb ] end -->
            <!-- [ Main Content ] start -->
            <div class="row">
                <!-- product profit end -->

                <div class="col-xl-12 col-md-12">
                    <div class="card user-profile-list">
                        <div class="card-body-dd theme-tbl">
                            <x-table action="false" checkbox="false" :keys="['Name', 'Group Name', '']" />
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- [ Main Content ] end -->

    @include('layouts.dataTablesFiles')

    @push('scripts')
        <script type="text/javascript">
            $("document").ready(function() {
                var datatable_url = route('roles.ajax');
                var datatable_columns = [{
                        data: 'name'
                    },
                    {
                        data: 'group.name'
                    },
                    {
                        data: 'action',
                        width: '15%',
                        orderable: false,
                        searchable: false
                    }
                ];

                create_datatables(datatable_url, datatable_columns);
            });
        </script>
    @endpush


</x-app-layout>
