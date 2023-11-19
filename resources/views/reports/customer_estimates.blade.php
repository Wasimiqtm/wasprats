
<x-app-layout>
    <div class="pcoded-main-container">
        <div class="pcoded-content">
            <x-breadcrumb title="Estimates" :button="[]" />

            <div class="row">
                <div style="margin: 20px 0px;">

                    <input type="text" name="daterange" value="" />
                    <span data-href="/export-estimates" id="export" class="btn btn-success btn-sm" onclick ="exportTasks (event.target);">Export</span>
                </div>
                <div class="col-xl-12 col-md-12">
                    <div class="card user-profile-list">
                        <div class="card-body-dd theme-tbl">
                            <x-table action="false" checkbox="false" :keys="[
                                'Customer',
                                'Billing Email',
                                'Date',
                                'Status',
                                'Total',

                            ]"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @include('layouts.dataTablesFiles')
    @push('scripts')

        <script src="{{asset('js/plugins/highchart.min.js')}}"></script>
        <script src="{{asset('js/plugins/daterange-picker.js')}}"></script>
        <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.j"></script>
        <script>

            $("document").ready(function() {
                var datatable_url = route('estimate.details');
                var datatable_columns = [{
                    data: 'customer'
                },
                    {
                        data: 'billing_email'
                    },
                    {
                        data: 'invoice_date'
                    },
                    {
                        data: 'status'
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
