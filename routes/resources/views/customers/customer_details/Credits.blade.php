<div class="main-container">
        <div class="pcoded-content">
        <a class="btn btn-primary" id="addinvoice">New Credits</a>

            <div class="row">
                <div class="col-xl-12 col-md-12">
                    <div class="card user-profile-list">
                        <div class="card-body-dd theme-tbl">
                            <x-table action="false" checkbox="false" :keys="[
                                'Method',
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
                    <input type="hidden" name="customer_id" value="{{request()->customer_id}}">

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

    <script>
        $("document").ready(function () {
            var datatable_url = route('customers.credit.details.list');
            datatable_url =`${datatable_url}?customer_id=`+"{{request()->customer_id}}"

            var datatable_columns = [{
                data: 'method'
            },
                {
                    data: 'date'
                },
                {
                    data: 'total'
                }
            ];

            create_datatables(datatable_url, datatable_columns);
        });
        $("body").on('click', "#addinvoice", function () {
            $("#creditModal").modal('show')
        });

        $("body").on('change','#exampleFormControlSelect1',function (){
            if($(this).val() ==='check'){
                    $(".check-number").show();
                    $(".memo").hide();
            }else if($(this).val()==='cash'){
                $(".check-number").hide();
                $(".memo").show();
            }else{
                $(".check-number").hide();
                $(".memo").hide();
            }
        })

        $("body").on('click','#saveCredits',function(){
                var value1 = $("#exampleFormControlSelect1").val();
                var amount = $("#amount").val();
                var dated = $("#dated").val();
                var CustomerPayment_check_number = $("#CustomerPayment_check_number").val();
                var CustomerPayment_memo = $("#CustomerPayment_memo").val();
                 $.ajax({
                     url: '{{route('customer.credits')}}',
                     type: 'POST',
                     "headers": {'X-CSRF-TOKEN': "{{csrf_token()}}"},
                     data:{
                         value1:value1,
                         amount:amount,
                         dated:dated,
                         CustomerPayment_check_number:CustomerPayment_check_number,
                         CustomerPayment_memo:CustomerPayment_memo,
                         customer_id:"{{request()->customer_id}}"
                     },
                     success:function(){
                         $("#creditModal").modal('hide')
                         $("div.modal-backdrop").remove();
                         $("body").css({'overflow': 'auto', 'padding-right': '0px'});
                         window.location.reload();
                     }
                 });
        });
    </script>
@endpush
