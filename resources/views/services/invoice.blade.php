<div class="table-responsive">
    <table class="table invoice-detail-table">
        <thead>
            <tr class="thead-default">
                <th width="40%">Item</th>
                <th>Cost</th>
                <th>Qty</th>
                <th>Tax</th>
                <th>Tax</th>
                <th>Total</th>
                <th><i class="btn btn-sm fa fa-plus loadRow text-success"></i></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($service->invoice_items as $key => $item)
                @include('services.partial.item-row')
            @empty
            @endforelse
        </tbody>
    </table>
</div>

<div class="col-sm-12">
    <table class="table table-responsive invoice-table invoice-total">
        <tbody>
            <tr>
                <th>Sub Total :</th>
                <td class="gross_total">0</td>
            </tr>
            <tr class="tax_tr">
                <th>Taxes:</th>
                <td class="total_tax">0</td>
            </tr>
            <tr>
                <th>
                    Discount: <br />
                    <div class="row" style="width: 52%;float: right;">
                        <div class="col-6 pl-1">
                            {!! Form::select('discount_type', ['$' => '$', '%' => '%'], $service->invoice_discount_type, [
                                'class' => 'form-control discount_type',
                            ]) !!}
                        </div>
                        <div class="col-6 p-0">
                            {!! Form::number('discount', $service->invoice_discount, [
                                'class' => 'form-control discount',
                            ]) !!}
                        </div>
                    </div>

                </th>
                <td class="total_discount">0</td>
            </tr>
            <tr class="text-info">
                <td>
                    <hr />
                    <h5 class="text-primary m-r-10">Total :</h5>
                </td>
                <td>
                    <hr />
                    <h5 class="text-primary total_amount">0</h5>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<div class="row">
    <div class="col-sm-6">
        <h6>Terms and Condition:</h6>
        {!! Form::textarea('term', $service->invoice_terms, ['class' => 'form-control', 'rows' => 2]) !!}
    </div>
    <div class="col-sm-6">
        <h6>Invoice notes visible to client:</h6>
        {!! Form::textarea('note', $service->invoice_note, ['class' => 'form-control', 'rows' => 2]) !!}
    </div>
</div>


@push('scripts')
    <script src="{{ asset('js/plugins/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('js/plugins/lodash.min.js') }}"></script>
    <script type="text/javascript">
        var i = {{ count($service->invoice_items) }};
        var items = [];

        @forelse ($service->invoice_items as $item)
            var wrapped = _(items).push({{ $item->item_id }});
            wrapped.commit();
            items = _.uniqBy(items);
        @empty
            loadNewRow($('.loadRow'));
        @endforelse

        $('document').ready(function() {

            setTimeout(function() {
                calculateAmount();
            }, 3000);

            $("#formValidation").validate();

            $(document).on("submit", "#formValidation", function(e) {
                e.preventDefault();

                let _form = $(this);
                let _loader = $("body");
                let formData = _form.serialize();
                loadingOverlay(_loader);
                $.ajax({
                    type: 'post',
                    url: route('services.updateInvoice'),
                    processData: false,
                    data: formData,
                    success: function(res) {

                        showMessage(res.message, res.success);

                        if (res.success) {
                            setTimeout(function() {
                                window.location = route('services.index');
                            }, 2000);
                        }
                    },
                    error: function(request, status, error) {
                        showAjaxErrorMessage(request, true);
                    },
                    complete: function() {
                        stopOverlay(_loader);
                    }
                });
            });

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

                        loadingOverlay(_el);

                        $.ajax({
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
                        });
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

            $(document).on('change',
                '.item_cost, .item_quantity, .item_tax_1, .item_tax_2, .discount_type, .discount',
                function(
                    e) {
                    calculateAmount();
                });
        });

        function loadNewRow(_el) {
            let htmlDiv = $('.invoice-detail-table tbody');
            let _item = _el.parents('tr');

            loadingOverlay(htmlDiv);

            $.ajax({
                type: "GET",
                url: "{{ route('services.getItemRow') }}",
                dataType: "json",
                success: function(data, textStatus, jqXHR) {
                    if (data.success) {
                        var template = jQuery.validator.format(data.html);
                        $(template(i++)).appendTo(htmlDiv);

                        $(".select2").select2();
                    } else {
                        errorMessage(data.message);
                    }
                    stopOverlay(htmlDiv);
                }
            });
        }

        function calculateAmount() {
            var grossTotal = 0;
            var totalDiscount = 0;
            var totalVat = 0;
            var totalAmount = 0;
            var totalTax = 0;

            var discountType = $(".discount_type").val();
            var discount = $(".discount").val();
            $('.invoice-detail-table tbody tr.item_row').each(function() {
                let _item = $(this);
                var itemId = _item.find(".item_id").val();
                if (itemId > 0) {
                    var itemUnitCost = _item.find('.item_cost').val();
                    var quantity = parseInt(_item.find('.item_quantity').val());

                    if (itemUnitCost > 0 && quantity > 0) {
                        var itemTotal = itemUnitCost * quantity;
                        _item.find(".item_total").text(itemTotal.toFixed(2));
                        grossTotal = grossTotal + itemTotal;
                    }

                    var totalTaxRate = 0;
                    var item_tax_1 = _item.find(".item_tax_1").val();
                    if (item_tax_1 > 0) {
                        var taxRate = _item.find(".item_tax_1 :selected").data('tax_rate');
                        totalTaxRate = totalTaxRate + taxRate;
                    }

                    var item_tax_2 = _item.find(".item_tax_2").val();
                    if (item_tax_2 > 0) {
                        var taxRate = _item.find(".item_tax_2 :selected").data('tax_rate');
                        totalTaxRate = totalTaxRate + taxRate;
                    }

                    if (totalTaxRate > 0) {
                        totalTax = totalTax + (itemTotal * totalTaxRate / 100);
                    }
                }
            });

            if (discountType == '$' && discount > 0) {
                totalDiscount = parseFloat(discount);
            } else if (discountType == '%' && discount > 0) {
                totalDiscount = grossTotal * parseFloat(discount) / 100;
            }

            totalAmount = grossTotal + totalTax - totalDiscount;
            $(".gross_total").text((grossTotal > 0) ? '$' + grossTotal.toFixed(2) : 0);
            $(".total_discount").text((totalDiscount > 0) ? '-$' + totalDiscount.toFixed(2) : 0);
            $(".total_tax").text((totalTax > 0) ? '$' + totalTax.toFixed(2) : 0);
            $(".total_amount").text((totalAmount > 0) ? '$ ' + totalAmount.toFixed(2) : 0);
        }
    </script>
@endpush
