<x-app-layout>

    <div class="pcoded-main-container">
        <div class="pcoded-content">
            <x-breadcrumb title="{{ $job->services->name }} Items Invoice" />
            <ul class="nav nav-pills mb-4 bg-white" id="myTab" role="tablist">
                <li class="nav-item ">
                    <a class=" nav-link text-uppercase" href="{{ route('print.items.invoice', $scheduleJobId)}}">Print Invoice</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-uppercase active btn btn-primary" id="addinvoice">Add New invoic</a>
                </li>
            </ul>

            <div class="row">
                <div class="col-xl-12 col-md-12">
                    <div class="card user-profile-list">
                        <div class="card-body-dd theme-tbl">
                            <x-table action="false" checkbox="false" :keys="['Item Code', 'Description', 'Quantity', '']" />
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
                        <input type="hidden" name="item_invoice_id" id="item_invoice_id" value="">

                        @include('used-items.items-invoices.add_update_invoices')
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
                        data: 'used_items.description'
                    },
                    {
                        data: 'quantity'
                    },
                    {
                        data: 'action'
                    }
                ];

                create_datatables(datatable_url, datatable_columns);
            });

            /*add invoice function*/
            $("body").on('click', "#addinvoice", function () {
                /*reset and show modal*/
                $("#invoiceId").trigger("reset");
                $("#item_description").hide();
                $('.removeRow').show();
                $('.loadRow').show();
                $("#invoiceModal").modal('show')
            });

            $('#invoiceId').on('change', 'select', function() {

                $.ajax({
                    url: '{{route('get.single.item')}}',
                    type: 'POST',
                    "headers": {'X-CSRF-TOKEN': "{{csrf_token()}}"},
                    data: {
                        id: this.value,
                    },
                    success: function (data) {
                        $("#item_description textarea").val(data.description)
                    }
                })
            });


            /*update invoice item*/
            $("body").on('click', "#updateinvoice", function () {
                $("#item_description").show();
                var id = $(this).attr('data-id')
                $.ajax({
                    url: '{{route('edit.item.invoice')}}',
                    type: 'POST',
                    "headers": {'X-CSRF-TOKEN': "{{csrf_token()}}"},
                    data: {
                        id: id,
                    },
                    success: function (data) {
                        console.log(data);
                        $("#item_qty").val(data.data.quantity)
                        $("#item_description textarea").val(data.data.used_items.description)
                        $("#item_id").val(data.data.used_items.id)
                        $("#edit_item_id").val(data.data.used_items.id)
                        $("#item_invoice_id").val(id)

                        /*hide add remove buttons*/
                        if(id) {
                            $('.removeRow').hide();
                            $('.loadRow').hide();
                        }
                        $("#invoiceModal").modal('show');
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
