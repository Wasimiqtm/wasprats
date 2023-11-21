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
            {{--<x-breadcrumb title="{{ $service->name }} {{ ucfirst($tab) }} Jobs" />--}}
            <x-breadcrumb title="{{ $service->name }} Payments" />

            {{--@include('sections.customer-tabs')--}}

            <div class="row">
                <div class="col-xl-12 col-md-12">
                    <div class="card user-profile-list">
                        <div class="card-body-dd theme-tbl">
                            <x-table action="false" checkbox="false" :keys="['Service Name', 'Customer', 'Technician', 'Payment Mode', 'Amount']" />
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
                var datatable_url = route('service.payments.ajax', [{{ $service->id }}]) + '?tab={{ $tab }}';
                var datatable_columns = [{
                        data: 'service.name'
                    },
                    {
                        data: 'customer.name'
                    },
                    {
                        data: 'user.name'
                    },
                    {
                        data: 'payment_mode'
                    },
                    {
                        data: 'amount'
                    }/*,
                    {
                        data: 'action',
                        width: '5%',
                        orderable: false,
                        searchable: false
                    }*/
                ];

                create_datatables(datatable_url, datatable_columns);
            });
        </script>
    @endpush


</x-app-layout>
