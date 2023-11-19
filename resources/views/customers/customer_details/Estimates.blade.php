<div class="main-container">
        <div class="pcoded-content">
        <a class="btn btn-primary" id="addEstimates">Add Estimates</a>

            <div class="row">
                <div class="col-xl-12 col-md-12">
                    <div class="card user-profile-list">
                        <div class="card-body-dd theme-tbl">
                            <x-table action="false" checkbox="false" :keys="[
                                'invoice_id',
                                'job_id',
                                'Frequncy',
                                'Date',
                                'Total',
                            ]" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@include('layouts.dataTablesFiles')

<div class="modal fade bd-example-modal-lg" id="estimatesModal" tabindex="-1" aria-labelledby="myLargeModalLabel"
     style="display:none;" aria-modal="false" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h4" id="myLargeModalLabel">Large Modal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="invoiceId">
                    <input type="hidden" name="customer_id" value="{{request()->customer_id}}">

                    @include('customers.customer_details.invoices.add_invoices')
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn  btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn  btn-primary" id="saveEstimates">Save</button>
            </div>
        </div>
    </div>
</div>
@push('scripts')

    <script>
        $("document").ready(function () {
            var datatable_url = route('customers.estimates.details.list');
            datatable_url =`${datatable_url}?customer_id=`+"{{request()->customer_id}}"

            var datatable_columns = [{
                data: 'uuid'
            },
                {
                    data: 'job_id'
                },
                {
                    data: 'frequncy'
                },
                {
                    data: 'created_at'
                },
                {
                    data: 'total'
                }
            ];

            create_datatables(datatable_url, datatable_columns);
        });
        $("body").on('click', "#addEstimates", function () {
            $("#estimatesModal").modal('show')
        });

        $("body").on("click", "#saveEstimates", function () {

            $.ajax({
                url: '{{route('customers.estimates')}}',
                type: 'POST',
                "headers": {'X-CSRF-TOKEN': "{{csrf_token()}}"},
                data:$("#invoiceId").serialize(),
                success: function (data) {

                    $("#estimatesModal").modal('hide')
                    $("div.modal-backdrop").remove();
                    $("body").css({'overflow': 'auto', 'padding-right': '0px'});
                    window.location.reload();

                }
            })
        });
    </script>
@endpush
