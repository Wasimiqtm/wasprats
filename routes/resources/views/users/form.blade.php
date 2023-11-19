<?php
$required = 'required';
if(@$user) {
    $required = '';
}
?>
<div class="form-group col-md-6">
    {!! Form::label('first_name', 'First Name', ['class' => 'form-label required-input']) !!}
    {!! Form::text('first_name', null, ['class' => 'form-control ' . $errors->first('first_name', 'error'), 'placeholder' => 'First Name', 'required', 'maxlength' => '50']) !!}
    {!! $errors->first('first_name', '<label class="error">:message</label>') !!}
</div>
<div class="form-group col-md-6">
    {!! Form::label('last_name', 'Last Name', ['class' => 'form-label required-input']) !!}
    {!! Form::text('last_name', null, ['class' => 'form-control ' . $errors->first('last_name', 'error'), 'placeholder' => 'Last Name', 'required', 'maxlength' => '50']) !!}
    {!! $errors->first('last_name', '<label class="error">:message</label>') !!}
</div>
<div class="form-group col-md-6">
    {!! Form::label('email', 'Email', ['class' => 'form-label required-input']) !!}
    {!! Form::email('email', null, ['class' => 'form-control ' . $errors->first('email', 'error'), 'placeholder' => 'Email', 'required', 'maxlength' => '30']) !!}
    {!! $errors->first('email', '<label class="error">:message</label>') !!}
</div>
<div class="form-group col-md-6">
    {!! Form::label('username', 'Username', ['class' => 'form-label required-input']) !!}
    {!! Form::text('username', null, ['class' => 'form-control ' . $errors->first('username', 'error'), 'placeholder' => 'Username', 'required', 'maxlength' => '50', 'onkeypress' => "return ((event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || event.charCode == 8 || event.charCode == 32 || (event.charCode >= 48 && event.charCode <= 57));"]) !!}
    {!! $errors->first('username', '<label class="error">:message</label>') !!}
</div>
<div class="form-group col-md-6">
    {!! Form::label('password', 'Password', ['class' => 'form-label required-input']) !!}
    {!! Form::password('password', ['class' => 'form-control ' . $errors->first('password', 'error'), 'placeholder' => 'Password', $required]) !!}
    {!! $errors->first('password', '<label class="error">:message</label>') !!}
</div>
<div class="form-group col-md-6">
    {!! Form::label('password_confirmation', 'Confirm Password', ['class' => 'form-label required-input']) !!}
    {!! Form::password('password_confirmation', ['class' => 'form-control ' . $errors->first('password_confirmation', 'error'), 'placeholder' => 'Confirm Password', $required]) !!}
    {!! $errors->first('password_confirmation', '<label class="error">:message</label>') !!}
</div>
<div class="form-group col-md-6">
    {!! Form::label('license_no', 'License#', ['class' => 'form-label required-input']) !!}
    {!! Form::text('license_no', null, ['class' => 'form-control ' . $errors->first('license_no', 'error'), 'placeholder' => 'License#']) !!}
    {!! $errors->first('license_no', '<label class="error">:message</label>') !!}
</div>
<div class="form-group col-md-6">
    {!! Form::label('role_id', 'Role', ['class' => 'form-label required-input']) !!}
    {!! Form::select('role_id', $roles, null, ['class' => 'form-control ' . $errors->first('role_id', 'error'), 'placeholder' => 'Role', 'required']) !!}
    {!! $errors->first('role_id', '<label class="error">:message</label>') !!}
</div>
