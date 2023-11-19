<div class="form-group col-6">
    {!! Form::label('name', 'Name', ['class' => 'form-label required-input']) !!}
    {!! Form::text('name', null, [
        'class' => 'form-control ' . $errors->first('name', 'error'),
        'placeholder' => 'Name',
        'required',
        'maxlength' => '100',
    ]) !!}
    {!! $errors->first('name', '<label class="error">:message</label>') !!}
</div>
<div class="form-group col-6">
    {!! Form::label('nickname', 'Nickname', ['class' => 'form-label required-input']) !!}
    {!! Form::text('nickname', null, [
        'class' => 'form-control ' . $errors->first('name', 'error'),
        'placeholder' => 'Nickname',
        'required',
        'maxlength' => '50',
    ]) !!}
    {!! $errors->first('nickname', '<label class="error">:message</label>') !!}
</div>
<div class="form-group col-6">
    {!! Form::label('user_id', 'Assigned To', ['class' => 'form-label required-input']) !!}
    {!! Form::select('user_id', $users, null, [
        'class' => 'form-control ' . $errors->first('user_id', 'error'),
        'placeholder' => 'Assigned To',
        'required',
    ]) !!}
    {!! $errors->first('user_id', '<label class="error">:message</label>') !!}
</div>
<div class="form-group col-6">
    {!! Form::label('group_ids', 'Schedule Group', ['class' => 'form-label required-input']) !!}
    {!! Form::select('group_ids[]', $groups, @$groupIds, [
        'class' => 'form-control ' . $errors->first('group_ids', 'error'),
        'required',
        'multiple',
    ]) !!}
    {!! $errors->first('group_ids', '<label class="error">:message</label>') !!}
</div>
<div class="form-group col-6">
    {!! Form::label('start', 'Start Address', ['class' => 'form-label required-input']) !!}
    {!! Form::text('start', null, [
        'class' => 'form-control ' . $errors->first('start', 'error'),
        'placeholder' => 'Start Address',
        'maxlength' => '100',
    ]) !!}
    {!! $errors->first('start', '<label class="error">:message</label>') !!}
</div>
<div class="form-group col-6">
    {!! Form::label('end', 'End Address', ['class' => 'form-label required-input']) !!}
    {!! Form::text('end', null, [
        'class' => 'form-control ' . $errors->first('end', 'error'),
        'placeholder' => 'End Address',
        'maxlength' => '100',
    ]) !!}
    {!! $errors->first('end', '<label class="error">:message</label>') !!}
</div>
