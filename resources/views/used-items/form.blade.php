<div class="form-group col-6">
    {!! Form::label('code', 'Code', ['class' => 'form-label required-input']) !!}
    {!! Form::text('code', null, [
        'class' => 'form-control ' . $errors->first('code', 'error'),
        'placeholder' => 'Code',
        'required',
        'maxlength' => '50',
    ]) !!}
    {!! $errors->first('name', '<label class="error">:message</label>') !!}
</div>

<div class="form-group col-6">
    {!! Form::label('description', 'Description', ['class' => 'form-label required-input']) !!}
    {!! Form::textarea('description', null, [
        'class' => 'form-control ' . $errors->first('description', 'error'),
        'placeholder' => 'Description',
        'rows' => 5
]) !!}
</div>
