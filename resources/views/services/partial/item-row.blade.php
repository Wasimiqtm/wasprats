@php
    if (!isset($key)) {
        $key = '{0}';
    }
@endphp
<tr class='item_row'>
    <td>
        {!! Form::select('item_id[' . $key . ']', $items, @$item->item_id ? $item->item_id : null, [
            'class' => 'form-control select2 items',
            'required' => 'required',
            @$item->item_id ? 'disabled' : '',
        ]) !!}
        <label id="item_id[{{ $key }}]-error" class="error" for="item_id[{{ $key }}]"></label>
        <input type="hidden" name="item_id[{{ $key }}]" value="{{ @$item->item_id ? $item->item_id : 0 }}"
            class="item_id" />
    </td>
    <td>
        <input required type='number' style='width:70px' name='item_cost[{{ $key }}]'
            class='form-control item_cost' value="{{ @$item->cost ? $item->cost : 0 }}" step="any" min="0" />
        <label id="item_cost[{{ $key }}]-error" class="error" for="item_cost[{{ $key }}]"></label>
    </td>
    <td>
        <input required type='number' style='width:60px' name='item_quantity[{{ $key }}]'
            class='form-control item_quantity' value="{{ @$item->quantity ? $item->quantity : 1 }}" step="1"
            min="1" />
        <label id="item_quantity[{{ $key }}]-error" class="error"
            for="item_quantity[{{ $key }}]"></label>
    </td>

    <td>
        <select name="item_tax_1[{{ $key }}]" class="form-control item_tax_1">
            <option>Select Tax</option>
            @foreach ($taxes as $tax)
                <option value="{{ $tax->id }}" data-tax_rate="{{ $tax->rate }}"
                    {{ @$item->tax_id_1 && $item->tax_id_1 == $tax->id ? 'selected' : '' }}>{{ $tax->name }}
                </option>
            @endforeach
        </select>

    </td>
    <td>
        <select name="item_tax_2[{{ $key }}]" class="form-control item_tax_2">
            <option>Select Tax</option>
            @foreach ($taxes as $tax)
                <option value="{{ $tax->id }}" data-tax_rate="{{ $tax->rate }}"
                    {{ @$item->tax_id_2 && $item->tax_id_2 == $tax->id ? 'selected' : '' }}>{{ $tax->name }}
                </option>
            @endforeach
        </select>
    </td>
    <td class="item_total">0</td>
    <td class="text-center"><i class="btn btn-sm fa fa-trash removeRow text-danger"></i></td>
</tr>
