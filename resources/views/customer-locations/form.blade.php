<div class="form-group col-md-6">
    {!! Form::label('name', 'Address Name', ['class' => 'form-label required-input']) !!}
    {!! Form::text('name', null, [
        'class' => 'form-control ' . $errors->first('name', 'error'),
        'placeholder' => 'Address Name',
        'required',
        'maxlength' => '50',
    ]) !!}
    {!! $errors->first('name', '<label class="error">:message</label>') !!}
</div>
<div class="form-group col-md-6">
    {!! Form::label('street', 'Street', ['class' => 'form-label required-input']) !!}
    {!! Form::text('street', null, [
        'class' => 'form-control ' . $errors->first('street', 'error'),
        'placeholder' => 'Street',
        'required',
        'maxlength' => '100',
    ]) !!}
    {!! $errors->first('street', '<label class="error">:message</label>') !!}
</div>
<div class="form-group col-md-6">
    {!! Form::label('city', 'City', ['class' => 'form-label required-input']) !!}
    {!! Form::text('city', null, [
        'class' => 'form-control ' . $errors->first('city', 'error'),
        'placeholder' => 'City',
        'required',
        'maxlength' => '30',
    ]) !!}
    {!! $errors->first('city', '<label class="error">:message</label>') !!}
</div>
<div class="form-group col-md-6">
    {!! Form::label('state', 'State', ['class' => 'form-label required-input']) !!}
    {!! Form::text('state', null, [
        'class' => 'form-control ' . $errors->first('state', 'error'),
        'placeholder' => 'State',
        'required',
        'maxlength' => '100',
    ]) !!}
    {!! $errors->first('state', '<label class="error">:message</label>') !!}
</div>
<div class="form-group col-md-6">
    {!! Form::label('zip', 'Zip', ['class' => 'form-label required-input']) !!}
    {!! Form::text('zip', null, [
        'class' => 'form-control ' . $errors->first('zip', 'error'),
        'placeholder' => 'Zip',
        'required',
        'maxlength' => '30',
    ]) !!}
    {!! $errors->first('zip', '<label class="error">:message</label>') !!}
</div>
<div class="form-group col-md-6">
    {!! Form::label('latitude', 'Latitude', ['class' => 'form-label']) !!}
    {!! Form::text('latitude', null, [
        'class' => 'form-control ' . $errors->first('latitude', 'error'),
        'placeholder' => 'Latitude',
        'maxlength' => '50',
    ]) !!}
    {!! $errors->first('latitude', '<label class="error">:message</label>') !!}
</div>
<div class="form-group col-md-6">
    {!! Form::label('longitude', 'Longitude', ['class' => 'form-label']) !!}
    {!! Form::text('longitude', null, [
        'class' => 'form-control ' . $errors->first('longitude', 'error'),
        'placeholder' => 'Longitude',
        'maxlength' => '50',
    ]) !!}
    {!! $errors->first('longitude', '<label class="error">:message</label>') !!}
</div>
<div class="form-group col-md-6">
    {!! Form::label('is_active', 'Status', ['class' => 'form-label required-input']) !!}
    {!! Form::select('is_active', ['1' => 'Active', '0' => 'In Active'], null, [
        'class' => 'form-control',
        'required',
    ]) !!}
    {!! $errors->first('is_active', '<label class="error">:message</label>') !!}
</div>
