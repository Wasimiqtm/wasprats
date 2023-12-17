<x-app-layout>

    <div class="pcoded-main-container">
        <div class="pcoded-content">
            <x-breadcrumb title="{{ $job->services->name }} Items Invoice" />
            <a class="btn btn-primary" id="addinvoice">Add New invoice</a>
            <a href="javascript:void(0)" data-id="{{$scheduleJobId}}" class="btn btn-primary" id="updateinvoice">Update invoice</a>
            <div class="row">
                <div class="col-xl-12 col-md-12">
                    <div class="card user-profile-list">
                        <div class="card-body-dd theme-tbl">
                            <x-table action="false" checkbox="false" :keys="['Item Code', 'Quantity']" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--Items Invoice Modal--}}
    <div class="modal fade bd-example-modal-lg" id="invoiceModal" tabindex="-1" aria-labelledby="myLargeModalLabel"
         style="display:none;" aria-modal="false" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h4" id="myLargeModalLabel">Items Invoice Modal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="invoiceId">
                        <input type="hidden" name="schedule_job_id" value="{{$scheduleJobId}}">
                        @include('used-items.items-invoices.add_invoices')
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn  btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn  btn-primary" id="saveInvoice">Save</button>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.dataTablesFiles')

    @push('scripts')
        <script type="text/javascript">
            $("document").ready(function() {
                var datatable_url = route('item.invoice.ajax', [{{ $scheduleJobId }}]);

                var datatable_columns = [
                    {
                        data: 'code'
                    },
                    {
                        data: 'quantity'
                    }
                ];

                create_datatables(datatable_url, datatable_columns);
            });

            $("body").on('click', "#addinvoice", function () {
                $("#invoiceModal").modal('show')
            });

            /*$("body").on('click', "#updateinvoice", function () {

                $.ajax({
                    url: '{route('update.item.invoice')}}',
                    type: 'POST',
                    "headers": {'X-CSRF-TOKEN': "{{csrf_token()}}"},
                    data:$("#invoiceId").serialize(),
                    success: function (data) {

                        $("#invoiceModal").modal('hide')
                        $("div.modal-backdrop").remove();
                        $("body").css({'overflow': 'auto', 'padding-right': '0px'});
                        window.location.reload();

                    }
                })

                $("#invoiceModal").modal('show')
            });*/

            $("body").on('click', "#updateinvoice", function () {
                var id = $(this).attr('data-id')
                $.ajax({
                    url: '{{route('edit.item.invoice')}}',
                    type: 'POST',
                    "headers": {'X-CSRF-TOKEN': "{{csrf_token()}}"},
                    data: {
                        schedule_job_id: id,
                    },
                    success: function (data) {
                        console.log(data);

                    }
                })
            })


            $("body").on("click", "#saveInvoice", function () {

                $.ajax({
                    url: '{{route('create.item.invoice')}}',
                    type: 'POST',
                    "headers": {'X-CSRF-TOKEN': "{{csrf_token()}}"},
                    data:$("#invoiceId").serialize(),
                    success: function (data) {

                        $("#invoiceModal").modal('hide')
                        $("div.modal-backdrop").remove();
                        $("body").css({'overflow': 'auto', 'padding-right': '0px'});
                        window.location.reload();

                    }
                })
            });
        </script>
    @endpush


</x-app-layout>
