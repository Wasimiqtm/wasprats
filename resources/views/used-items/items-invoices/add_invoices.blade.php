@php
    if (!isset($key)) {
        $key =0;
    }
@endphp
<div class="table-responsive">
    <table class="table invoice-detail-table">
        <thead>
        <tr class="thead-default">
            <th width="50%">Item</th>
            <th>Qty</th>
            <th><i class="btn btn-sm fa fa-plus loadRow text-success"></i></th>
        </tr>
        </thead>
        <tbody>

        <tr class='item_row'>
            <td>
              <select class="form-control items" name="item_id[]" id="item_id['{{$key}}']">
                    @foreach($items as $id=>$name)
                        <option value="{{$id}}">{{$name}}</option>
                    @endforeach
              </select>
                <label id="item_id[{{ $key }}]-error" class="error" for="item_id[']"></label>
                <input type="hidden" name="item_id[{{ $key }}]"
                       class="item_id" />
            </td>
            <td>
                <input required type='number' style='width:60px' name="item_quantity[{{$key}}]"
                       class='form-control item_quantity'  step="1"
                       min="1" />
                <label id="item_quantity[{{ $key }}]-error" class="error"
                       for="item_quantity[{{ $key }}]"></label>
            </td>

            <td class="text-center"><i class="btn btn-sm fa fa-trash removeRow text-danger"></i></td>
        </tr>

        </tbody>
    </table>
</div>
<div class="row">
    <div class="col-sm-12">
        <h6>Used Item Description:</h6>
        {!! Form::textarea('term', null, ['class' => 'form-control', 'rows' => 2]) !!}
    </div>
</div>


@push('scripts')
    <script src="{{ asset('js/plugins/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('js/plugins/lodash.min.js') }}"></script>
    <script type="text/javascript">
        var i=1;
        var items = [];
        $('document').ready(function() {
            $(document).on('click', '.loadRow', function() {
                loadNewRow($(this));
            });

            $(document).on('change', '.items', function(e) {

                let _el = $(this);
                var _item = $(this).parents('.item_row');
                var itemId = this.value;
                if (itemId > 0) {
                    if (_.includes(items, this.value)) {
                        _el.find('option[value=""]').removeAttr("selected");
                        _el.find('option[value=""]').attr("selected", "selected");
                        errorMessage('You have already select this item please select other item');
                        return false;
                    } else {

                        _item.find(".item_id").val(itemId);
                        /*$.ajax({
                            type: "GET",
                            url: route('services.getItemDetails', itemId),
                            dataType: "json",
                            success: function(data, textStatus, jqXHR) {
                                if (data.success) {

                                    var item = data.item;
                                    //if (product.final_quantity && product.final_quantity > 0) {

                                    _item.find(".item_id").val(item.id);
                                    _item.find('.item_cost').val(item.cost);

                                    calculateAmount();

                                    var wrapped = _(items).push(itemId);
                                    wrapped.commit();
                                    products = _.uniqBy(items);
                                    _el.attr("disabled", true);
                                    // } else {
                                    //     _el.val('').change();
                                    //     errorMessage('This item is not available for sale');
                                    // }


                                } else {
                                    errorMessage(data.message);
                                }
                                stopOverlay(_el);
                            }
                        });*/
                    }
                }

            });

            $(document).on('click', '.removeRow', function() {
                var _parent = $(this).parents('.item_row');
                var itemId = _parent.find(".items").val();
                _.remove(items, function(n) {
                    return n == itemId;
                });
                _parent.remove();
                calculateAmount();
            });

        });
        $(".select2").select2();
        function loadNewRow(_el) {
            let htmlDiv = $('.invoice-detail-table tbody');
            let _item = _el.parents('tr');

            loadingOverlay(htmlDiv);

            $.ajax({
                type: "GET",
                url: "{{ route('usedItems.listing') }}",
                dataType: "json",
                success: function(data, textStatus, jqXHR) {
                    if (data.success) {
                        var template = jQuery.validator.format(data.html);
                        $(template(i++)).appendTo(htmlDiv);


                    } else {
                        errorMessage(data.message);
                    }
                    stopOverlay(htmlDiv);
                }
            });
        }

    </script>
@endpush
