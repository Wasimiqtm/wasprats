<x-app-layout>
    <div class="pcoded-main-container">
        <div class="pcoded-content">
            <x-breadcrumb title="UsedItem" :button="['name' => 'Add', 'allow' => true, 'link' => route('things.create')]" />

            <div class="row">
                <div class="col-xl-12 col-md-12">
                    <div class="card user-profile-list">
                        <div class="card-body-dd theme-tbl">
                            <x-table action="false" :keys="['Name','']" />
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
                var datatable_url = route('things.ajax');
                var datatable_columns = [
                    {
                        data: 'name'
                    },
                    // {
                    //     data: 'rate'
                    // },
                    // {
                    //     data: 'is_active',
                    //     width: '10%',
                    //     orderable: false,
                    //     searchable: false
                    // },
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
