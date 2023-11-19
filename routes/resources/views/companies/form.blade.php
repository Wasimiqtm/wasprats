<div class="form-group col-md-6">
    {!! Form::label('Comapny name', 'Name', ['class' => 'form-label required-input']) !!}
    {!! Form::text('name', null, ['class' => 'form-control ' . $errors->first('name', 'error'), 'placeholder' => 'Comapny Name', 'required', 'maxlength' => '150']) !!}
    {!! $errors->first('name', '<label class="error">:message</label>') !!}
</div>
<div class="form-group col-md-6">
    {!! Form::label('email', 'Comapny Email', ['class' => 'form-label required-input']) !!}
    {!! Form::email('email', null, ['class' => 'form-control ' . $errors->first('email', 'error'), 'placeholder' => 'Comapny Email', 'required', 'maxlength' => '100']) !!}
    {!! $errors->first('email', '<label class="error">:message</label>') !!}
</div>
<div class="form-group col-md-6">
    {!! Form::label('phone', 'Phone', ['class' => 'form-label required-input']) !!}
    {!! Form::text('phone', null, ['class' => 'form-control ' . $errors->first('phone', 'error'), 'placeholder' => 'Phone', 'maxlength' => '30']) !!}
    {!! $errors->first('phone', '<label class="error">:message</label>') !!}
</div>
<div class="form-group col-md-6">
    {!! Form::label('fax', 'Fax', ['class' => 'form-label required-input']) !!}
    {!! Form::text('fax', null, ['class' => 'form-control ' . $errors->first('fax', 'error'), 'placeholder' => 'Fax', 'maxlength' => '30']) !!}
    {!! $errors->first('fax', '<label class="error">:message</label>') !!}
</div>
<div class="form-group col-md-6">
    {!! Form::label('address', 'Address', ['class' => 'form-label required-input']) !!}
    {!! Form::textarea('address', null, ['class' => 'form-control ' . $errors->first('address', 'error'), 'placeholder' => 'Address', 'rows' => '1']) !!}
    {!! $errors->first('address', '<label class="error">:message</label>') !!}
</div>
<div class="form-group col-md-6">
    {!! Form::label('city', 'City', ['class' => 'form-label required-input']) !!}
    {!! Form::text('city', null, ['class' => 'form-control ' . $errors->first('city', 'error'), 'placeholder' => 'City']) !!}
    {!! $errors->first('city', '<label class="error">:message</label>') !!}
</div>
<div class="form-group col-md-6">
    {!! Form::label('state', 'State', ['class' => 'form-label required-input']) !!}
    {!! Form::text('state', null, ['class' => 'form-control ' . $errors->first('state', 'error'), 'placeholder' => 'State']) !!}
    {!! $errors->first('state', '<label class="error">:message</label>') !!}
</div>
<div class="form-group col-md-6">
    {!! Form::label('zip', 'Zip', ['class' => 'form-label required-input']) !!}
    {!! Form::text('zip', null, ['class' => 'form-control ' . $errors->first('zip', 'error'), 'placeholder' => 'Zip']) !!}
    {!! $errors->first('zip', '<label class="error">:message</label>') !!}
</div>
<div class="form-group col-md-6">
    {!! Form::label('website', 'Website', ['class' => 'form-label required-input']) !!}
    {!! Form::text('website', null, ['class' => 'form-control ' . $errors->first('website', 'error'), 'placeholder' => 'Website']) !!}
    {!! $errors->first('website', '<label class="error">:message</label>') !!}
</div>
<div class="form-group col-md-6">
    {!! Form::label('license', 'Business License', ['class' => 'form-label required-input']) !!}
    {!! Form::text('license', null, ['class' => 'form-control ' . $errors->first('license', 'error'), 'placeholder' => 'Business License']) !!}
    {!! $errors->first('license', '<label class="error">:message</label>') !!}
</div>
<div class="form-group col-md-6">
    {!! Form::label('opening_time', 'Opening Time', ['class' => 'form-label required-input']) !!}
    {!! Form::time('opening_time', null, ['class' => 'form-control ' . $errors->first('opening_time', 'error')]) !!}
    {!! $errors->first('opening_time', '<label class="error">:message</label>') !!}
</div>
<div class="form-group col-md-6">
    {!! Form::label('closing_time', 'Closing Time', ['class' => 'form-label required-input']) !!}
    {!! Form::time('closing_time', null, ['class' => 'form-control ' . $errors->first('closing_time', 'error')]) !!}
    {!! $errors->first('closing_time', '<label class="error">:message</label>') !!}
</div>
<div class="form-group col-md-6">
    {!! Form::label('industry_id', 'Industry', ['class' => 'form-label required-input']) !!}
    {!! Form::select('industry_id', $industries, null, ['class' => 'form-control select2 ' . $errors->first('industry_id', 'error')]) !!}
    {!! $errors->first('industry_id', '<label class="error">:message</label>') !!}
</div>
<div class="form-group col-md-6">
    {!! Form::label('timezone_id', 'Timezone', ['class' => 'form-label required-input']) !!}
    {!! Form::select('timezone_id', $timezones, null, ['class' => 'form-control select2 ' . $errors->first('timezone_id', 'error')]) !!}
    {!! $errors->first('timezone_id', '<label class="error">:message</label>') !!}
</div>
<div class="form-group col-md-6">
    {!! Form::label('country_id', 'Country', ['class' => 'form-label required-input']) !!}
    {!! Form::select('country_id', $countries, null, ['class' => 'form-control select2 ' . $errors->first('country_id', 'error'), 'required']) !!}
    {!! $errors->first('country_id', '<label class="error">:message</label>') !!}
</div>
<div class="form-group col-md-6">
    {!! Form::label('date_format', 'Date Format', ['class' => 'form-label required-input']) !!}
    {!! Form::select('date_format', $dateFormats, null, ['class' => 'form-control select2 ' . $errors->first('date_format', 'error')]) !!}
    {!! $errors->first('date_format', '<label class="error">:message</label>') !!}
</div>
<div class="form-group col-md-6">
    {!! Form::label('currency_id', 'Currency', ['class' => 'form-label required-input']) !!}
    {!! Form::select('currency_id', $currencies, null, ['class' => 'form-control select2 ' . $errors->first('currency_id', 'error')]) !!}
    {!! $errors->first('currency_id', '<label class="error">:message</label>') !!}
</div>
<div class="form-group col-md-6">
    {!! Form::label('temperature', 'Temperature', ['class' => 'form-label required-input']) !!}
    {!! Form::select('temperature', $temperatures, null, ['class' => 'form-control select2 ' . $errors->first('temperature', 'error')]) !!}
    {!! $errors->first('temperature', '<label class="error">:message</label>') !!}
</div>
<div class="form-group col-md-6">
    {!! Form::label('is_active', 'Status', ['class' => 'form-label required-input']) !!}
    {!! Form::select('is_active', ['1' => 'Active', '0' => 'In Active'], null, ['class' => 'form-control', 'required']) !!}
    {!! $errors->first('is_active', '<label class="error">:message</label>') !!}
</div>