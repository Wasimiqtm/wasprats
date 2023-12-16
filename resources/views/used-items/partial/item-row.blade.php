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
        <input required type='number' style='width:60px' name='item_quantity[{{ $key }}]'
            class='form-control item_quantity' value="{{ @$item->quantity ? $item->quantity : 1 }}" step="1"
            min="1" />
        <label id="item_quantity[{{ $key }}]-error" class="error"
            for="item_quantity[{{ $key }}]"></label>
    </td>
    <td class="text-center"><i class="btn btn-sm fa fa-trash removeRow text-danger"></i></td>
</tr>
