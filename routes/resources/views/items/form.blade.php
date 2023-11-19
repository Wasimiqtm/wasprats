<div class="form-group col-6">
    {!! Form::label('name', 'Name', ['class' => 'form-label required-input']) !!}
    {!! Form::text('name', null, [
        'class' => 'form-control ' . $errors->first('name', 'error'),
        'placeholder' => 'Name',
        'required',
        'maxlength' => '30',
    ]) !!}
    {!! $errors->first('name', '<label class="error">:message</label>') !!}
</div>
<div class="form-group col-6">
    {!! Form::label('description', 'Description', ['class' => 'form-label required-input']) !!}
    {!! Form::textarea('description', null, [
        'class' => 'form-control ' . $errors->first('description', 'error'),
        'placeholder' => 'Description',
        'rows' => 2,
    ]) !!}
    {!! $errors->first('name', '<label class="error">:message</label>') !!}
</div>
<div class="form-group col-6">
    {!! Form::label('cost', 'Cost', ['class' => 'form-label required-input']) !!}
    {!! Form::number('cost', null, [
        'class' => 'form-control ' . $errors->first('cost', 'error'),
        'placeholder' => 'Cost',
        'required',
        'min' => 0,
    ]) !!}
    {!! $errors->first('rate', '<label class="error">:message</label>') !!}
</div>
<div class="form-group col-6">
    {!! Form::label('tax_1', 'Tax 1', ['class' => 'form-label required-input']) !!}
    {!! Form::select('tax_1', $taxes, null, [
        'class' => 'form-control ' . $errors->first('tax_1', 'error'),
        'placeholder' => 'Tax 1',
    ]) !!}
    {!! $errors->first('tax_1', '<label class="error">:message</label>') !!}
</div>
<div class="form-group col-6">
    {!! Form::label('tax_2', 'Tax 2', ['class' => 'form-label required-input']) !!}
    {!! Form::select('tax_2', $taxes, null, [
        'class' => 'form-control ' . $errors->first('tax_2', 'error'),
        'placeholder' => 'Tax 2',
    ]) !!}
    {!! $errors->first('tax_2', '<label class="error">:message</label>') !!}
</div>
<div class="form-group col-6">
    {!! Form::label('is_active', 'Status', ['class' => 'form-label required-input']) !!}
    {!! Form::select('is_active', ['1' => 'Active', '0' => 'In Active'], null, [
        'class' => 'form-control',
        'required',
    ]) !!}
    {!! $errors->first('is_active', '<label class="error">:message</label>') !!}
</div>
