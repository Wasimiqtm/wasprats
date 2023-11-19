<div class="form-group">
    {!! Form::label('name', 'Name', ['class' => 'form-label required-input']) !!}
    {!! Form::text('name', null, ['class' => 'form-control ' . $errors->first('name', 'error'), 'placeholder' => 'Name', 'required', 'maxlength' => '30']) !!}
    {!! $errors->first('name', '<label class="error">:message</label>') !!}
</div>
<div class="form-group">
    {!! Form::label('is_active', 'Status', ['class' => 'form-label required-input']) !!}
    {!! Form::select('is_active', ['1' => 'Active', '0' => 'In Active'], null, ['class' => 'form-control', 'required']) !!}
    {!! $errors->first('is_active', '<label class="error">:message</label>') !!}
</div>