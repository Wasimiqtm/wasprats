<div class="main-container">
    <div class="pcoded-content">
        <a class="btn btn-primary" id="addinvoice">New Job</a>

        <div class="row">
            <div class="col-xl-12 col-md-12">
                <div class="card user-profile-list">
                    <div class="card-body-dd theme-tbl">
                        <x-table action="false" checkbox="false" :keys="[
                                'Service Name',
                                'Customer Name',
                                'Status',
                                ''
                            ]"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('layouts.dataTablesFiles')

@push('scripts')

    <script>
        $("document").ready(function () {
            var datatable_url = route('users.get.active.jobs');
            datatable_url =`${datatable_url}?id=`+"{{request()->id}}"+"&type={{request()->type ??'active'}}"

            var datatable_columns = [{
                data: 'service_name'
            },
                {
                    data: 'customer.name'
                },
                {
                    data: 'status'
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


