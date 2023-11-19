<x-app-layout>
    <div class="pcoded-main-container">
        <div class="pcoded-content">
            <x-breadcrumb title="Tags" :button="['name' => 'Add', 'allow' => false]" />

            <div class="row">
                <div class="col-xl-12 col-md-12">
                    <div class="card user-profile-list">
                        <div class="card-body-dd theme-tbl">
                            <x-table action="false" :keys="['Name', 'Type', '']" />
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
                var datatable_url = route('tags.ajax');
                var datatable_columns = [{
                        data: 'name'
                    },
                    {
                        data: 'type'
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


</x-app-layout>
