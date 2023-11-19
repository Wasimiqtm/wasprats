<div class="form-group">
    {!! Form::label('name', 'Name', ['class' => 'form-label required-input']) !!}
    {!! Form::text('name', null, [
        'class' => 'form-control ' . $errors->first('name', 'error'),
        'placeholder' => 'Name',
        'required',
        'maxlength' => '30',
    ]) !!}
    {!! $errors->first('name', '<label class="error">:message</label>') !!}
</div>
