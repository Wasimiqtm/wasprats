
<div class="form-group">
    {!! Form::label('role_group_id', 'Role Group', ['class' => 'form-label required-input']) !!}
    {!! Form::select('role_group_id', $groups, null, ['class' => 'form-control ' . $errors->first('role_group_id', 'error'), 'placeholder' => 'Role Group', 'required', 'maxlength' => '30']) !!}
    {!! $errors->first('role_group_id', '<label class="error">:message</label>') !!}
</div>
<div class="form-group">
    {!! Form::label('name', 'Name', ['class' => 'form-label required-input']) !!}
    {!! Form::text('name', null, ['class' => 'form-control ' . $errors->first('name', 'error'), 'placeholder' => 'Name', 'required', 'maxlength' => '30']) !!}
    {!! $errors->first('name', '<label class="error">:message</label>') !!}
</div>