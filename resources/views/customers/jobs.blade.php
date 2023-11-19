<x-app-layout>

    <?php
        if (in_array($tab, ['completed', 'canceled'])) {
            $tab = $request->tab;
        } else {
            $tab = 'active';
        }
    ?>

    <div class="pcoded-main-container">
        <div class="pcoded-content">
            <x-breadcrumb title="{{ $customer->name }} {{ ucfirst($tab) }} Jobs" />

            @include('sections.customer-tabs')

            <div class="row">
                <div class="col-xl-12 col-md-12">
                    <div class="card user-profile-list">
                        <div class="card-body-dd theme-tbl">
                            <x-table action="false" checkbox="false" :keys="['Service Name', '']" />
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
                var datatable_url = route('customers.jobs.ajax', [{{ $customer->id }}]) + '?tab={{ $tab }}';
                var datatable_columns = [{
                        data: 'services.name'
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
