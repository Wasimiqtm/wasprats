
<x-app-layout>
    <div class="pcoded-main-container">
        <div class="pcoded-content">
            <x-breadcrumb title="Invoice Credits" :button="['has_modal' => true, 'className' =>'invoice_credits','name' =>'New Credits']" />

            <div class="row">
                <div style="margin: 20px 0px;">

                    <input type="text" name="daterange" value="" />
                    <span data-href="{{route('export.credits')}}" id="export" class="btn btn-success btn-sm" onclick ="exportTasks (event.target);">Export</span>
                </div>
                <div class="col-xl-12 col-md-12">
                    <div class="card user-profile-list">
                        <div class="card-body-dd theme-tbl">
                            <x-table action="false" checkbox="false" :keys="[
                                'Customer',
                                'Method',
                                'Date',
                                'Total',


                            ]"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @include('layouts.dataTablesFiles')

    <div class="modal fade bd-example-modal-lg" id="creditModal" tabindex="-1" aria-labelledby="myLargeModalLabel"
         style="display:none;" aria-modal="false" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h4" id="myLargeModalLabel">Add Credits</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="credit">
                        <div class="form-group">
                            <label class="form-label">Customer</label>
                            <select class="form-control basicAutoSelect" name="simple_select"
                                    placeholder="type to search..."
                                    data-url="testdata/test-select-simple.json" autocomplete="off"></select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Amount</label>
                            <input type="number" class="form-control" placeholder="Text" id="amount">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Date</label>
                            <input type="date" class="form-control" placeholder="Text" id="dated">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="exampleFormControlSelect1">Method</label>
                            <select class="form-select" id="exampleFormControlSelect1">
                                <option value="cash">Cash</option>
                                <option value="check">Check</option>
                                <option value="credit">Credit</option>
                            </select>

                        </div>
                        <span class="check-number w156" style="display: none;">
                        <input placeholder="Check #" class="span2 need-tabindex" name="check_number" id="CustomerPayment_check_number" type="text" maxlength="255">                    </span>
                        <span class="memo w156" style="display: none; ">
                        <input placeholder="Memo" class="span2 need-tabindex" maxlength="25" name="check_memo" id="CustomerPayment_memo" type="text">                    </span>


                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn  btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn  btn-primary" id="saveCredits">Save</button>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/gh/xcash/bootstrap-autocomplete@v2.3.7/dist/latest/bootstrap-autocomplete.min.js"></script>

        <script src="{{asset('js/plugins/highchart.min.js')}}"></script>
        <script src="{{asset('js/plugins/daterange-picker.js')}}"></script>
        <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.j"></script>
        <script>
            $('.advancedAutoComplete').autoComplete({
                resolver: 'custom',
                events: {
                    search: function (qry, callback) {
                        // let's do a custom ajax call
                        $.ajax(
                            '{{route('get.customer.list')}}',
                            {
                                data: { 'qry': qry}
                            }
                        ).done(function (res) {
                            callback(res.results)
                        });
                    }
                }
            });
            $("body").on('click','.invoice_credits',function(){
                    $("#creditModal").modal('show');
            })
            $("document").ready(function() {
                var datatable_url = route('invoice.credit.list');
                var datatable_columns = [{
                    data: 'customer'
                },
                    {
                        data: 'method'
                    },
                    {
                        data: 'dated'
                    },
                    {
                        data: 'total'
                    }
                ];

                var start = moment().subtract(29, 'days');
                var endDate = moment();
                $('input[name="daterange"]').daterangepicker({
                    startDate: start,
                    endDate: endDate,

                });


                create_datatables(datatable_url, datatable_columns,'','',10,'','',[],{start_date:start,end_date:endDate});
                $('input[name="daterange"]').on('apply.daterangepicker', function(ev, picker) {
                    var dataPOST = {start_date:picker.startDate,end_date:picker.endDate}
                    var   pageLength=10;
                    $('#datatable').DataTable().destroy();
                    var mytable = $('#datatable').DataTable({
                        oLanguage: { sProcessing: '<img src="'+ Ziggy.url +'/images/bx_loader.gif">' },
                        processing: true,
                        serverSide: true,
                        ordering: false,
                        responsive: true,
                        pageLength: pageLength,
                        bLengthChange: (pageLength>0)?(pageLength==30?false:true):false,
                        paging: (pageLength>0)?true:false,
                        info: (pageLength>0)?(pageLength==30?false:true):false,
                        "ajax": {
                            "url": datatable_url,
                            type:'POST',
                            "data": function ( d ) {
                                return $.extend( {}, d, {
                                    "extra_search": JSON.stringify(dataPOST)
                                } );
                            }
                        }, columns: datatable_columns,
                        order: false,
                        drawCallback: function ( settings ) {

                        }
                    });

                });
            });

            function exportTasks(_this) {
                let _url = $(_this).data('href');

                window.open(
                    _url,
                    '_blank' // <- This is what makes it open in a new window.
                );

            }
        </script>
    @endpush

</x-app-layout>
