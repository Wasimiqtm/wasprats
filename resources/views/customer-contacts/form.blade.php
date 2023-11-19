<div class="form-group col-md-6">
    {!! Form::label('first_name', 'First Name', ['class' => 'form-label required-input']) !!}
    {!! Form::text('first_name', null, [
        'class' => 'form-control ' . $errors->first('first_name', 'error'),
        'placeholder' => 'First Name',
        'required',
        'maxlength' => '50',
    ]) !!}
    {!! $errors->first('first_name', '<label class="error">:message</label>') !!}
</div>
<div class="form-group col-md-6">
    {!! Form::label('last_name', 'Last Name', ['class' => 'form-label required-input']) !!}
    {!! Form::text('last_name', null, [
        'class' => 'form-control ' . $errors->first('name', 'error'),
        'placeholder' => 'Last Name',
        'maxlength' => '50',
    ]) !!}
    {!! $errors->first('last_name', '<label class="error">:message</label>') !!}
</div>
<div class="form-group col-md-6">
    {!! Form::label('email', 'Email', ['class' => 'form-label required-input']) !!}
    {!! Form::email('email', null, [
        'class' => 'form-control ' . $errors->first('email', 'error'),
        'placeholder' => 'Email',
        'maxlength' => '100',
    ]) !!}
    {!! $errors->first('email', '<label class="error">:message</label>') !!}
</div>
<div class="form-group col-md-6">
    {!! Form::label('phone', 'Phone', ['class' => 'form-label required-input']) !!}
    {!! Form::text('phone', null, [
        'class' => 'form-control ' . $errors->first('phone', 'error'),
        'placeholder' => 'Phone',
        'maxlength' => '30',
    ]) !!}
    {!! $errors->first('phone', '<label class="error">:message</label>') !!}
</div>
<div class="form-group col-md-6">
    {!! Form::label('is_active', 'Status', ['class' => 'form-label required-input']) !!}
    {!! Form::select('is_active', ['1' => 'Active', '0' => 'In Active'], null, [
        'class' => 'form-control',
        'required',
    ]) !!}
    {!! $errors->first('is_active', '<label class="error">:message</label>') !!}
</div>
