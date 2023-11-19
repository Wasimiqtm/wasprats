<div class="form-group col-6">
    {!! Form::label('name', 'Serivce Name', ['class' => 'form-label required-input']) !!}
    {!! Form::text('name', null, [
        'class' => 'form-control ' . $errors->first('name', 'error'),
        'placeholder' => 'Serivce Name',
        'required',
        'maxlength' => '100',
    ]) !!}
    {!! $errors->first('name', '<label class="error">:message</label>') !!}
</div>
<div class="form-group col-6">
    {!! Form::label('length', 'Length', ['class' => 'form-label required-input']) !!}
    <div class="row">
        <div class="col-6">
            {!! Form::select('hours', $lengthHours, null, [
                'class' => 'form-control ' . $errors->first('hours', 'error'),
                'required',
            ]) !!}
        </div>
        <div class="col-6">
            {!! Form::select('minutes', $lengthMinutes, null, [
                'class' => 'form-control ' . $errors->first('minutes', 'error'),
                'required',
            ]) !!}
        </div>
    </div>
</div>
<div class="form-group col-6">
    {!! Form::label('repeat', 'Repeat', ['class' => 'form-label required-input']) !!}
    {!! Form::select('repeat', $repeat, null, [
        'class' => 'form-control ' . $errors->first('repeat', 'error'),
        'required',
    ]) !!}
</div>

<div class="form-group col-6 repeat_yes">
    {!! Form::label('repeat_every', 'Every', ['class' => 'form-label required-input']) !!}
    <div class="input-group">
        {!! Form::select('repeat_every', $repeatEvery, null, [
            'class' => 'form-control ' . $errors->first('repeat_every', 'error'),
        ]) !!}
        <span class="input-group-text repeat_every_text"></span>
    </div>
    {!! $errors->first('repeat_every', '<label class="error">:message</label>') !!}
</div>
<div class="form-group col-6 repeat_yes">
    {!! Form::label('ends', 'Ends', ['class' => 'form-label required-input']) !!}
    {!! Form::select('ends', ['Never' => 'Never', 'After' => 'After'], null, [
        'class' => 'form-control ' . $errors->first('ends', 'error'),
    ]) !!}
    {!! $errors->first('ends', '<label class="error">:message</label>') !!}
</div>
<div class="form-group col-6 ends_yes">
    {!! Form::label('ends_after_jobs', 'After', ['class' => 'form-label required-input']) !!}
    <div class="input-group">
        {!! Form::select('ends_after_jobs', $repeatEvery, null, [
            'class' => 'form-control ' . $errors->first('ends_after_jobs', 'error'),
        ]) !!}
        <span class="input-group-text">jobs</span>
    </div>
    {!! $errors->first('ends_after_jobs', '<label class="error">:message</label>') !!}
</div>
<div class="form-group col-6 repeat_yes">
    {!! Form::label('except', 'Except', ['class' => 'form-label required-input']) !!}
    <div class="row">
        <div class="col-4">
            {!! Form::select('except_1', $excepts['except_1'], null, [
                'class' => 'form-control ' . $errors->first('except_1', 'error'),
                'required',
            ]) !!}
        </div>
        <div class="col-4">
            {!! Form::select('except_2', $excepts['except_2'], null, [
                'class' => 'form-control ' . $errors->first('except_2', 'error'),
                'required',
            ]) !!}
        </div>
        <div class="col-4">
            {!! Form::select('except_3', $excepts['except_3'], null, [
                'class' => 'form-control ' . $errors->first('except_3', 'error'),
                'required',
            ]) !!}
        </div>
    </div>
    {!! $errors->first('except_1', '<label class="error">:message</label>') !!}
    {!! $errors->first('except_2', '<label class="error">:message</label>') !!}
    {!! $errors->first('except_3', '<label class="error">:message</label>') !!}
</div>
<div class="form-group col-6">
    {!! Form::label('job_status', 'Recurring Job Status', ['class' => 'form-label required-input']) !!}
    {!! Form::select('job_status', ['Unconfirmed' => 'Unconfirmed', 'Confirmed' => 'Confirmed'], null, [
        'class' => 'form-control ' . $errors->first('job_status', 'error'),
        'required',
    ]) !!}
</div>
<div class="form-group col-6">
    {!! Form::label('color_code', 'Color Code', ['class' => 'form-label required-input']) !!}
    {!! Form::color('color_code', null, [
        'class' => 'form-control ' . $errors->first('color_code', 'error'),
        'required',
    ]) !!}
</div>
<div class="form-group col-6">
    {!! Form::label('is_active', 'Status', ['class' => 'form-label required-input']) !!}
    {!! Form::select('is_active', ['1' => 'Active', '0' => 'In Active'], null, [
        'class' => 'form-control',
        'required',
    ]) !!}
    {!! $errors->first('is_active', '<label class="error">:message</label>') !!}
</div>

@push('scripts')
    <script src="{{ asset('js/plugins/jquery.validate.min.js') }}"></script>
    <script type="text/javascript">
        $(".repeat_yes, .ends_yes").hide();

        $('document').ready(function() {

            const repeatEvery = {
                'Daily': 'days',
                'Weekly': 'weeks',
                'Monthly': 'months',
                'Yearly': 'years'
            };

            $(document).on("change", "#repeat", function() {
                const val = this.value;

                if (val == "Not") {
                    $(".repeat_yes").hide();
                } else {
                    $(".repeat_yes").show();

                    $(".repeat_every_text").text(repeatEvery[val]);
                }
            });

            $(document).on("change", "#ends", function() {
                const val = this.value;

                if (val == "Never") {
                    $(".ends_yes").hide();
                } else {
                    $(".ends_yes").show();
                }
            });

            @if (@$service)
                $("#repeat").val('{{ $service->repeat }}').change();
                $("#ends").val('{{ $service->ends }}').change();
            @endif

            $('#formValidation').validate();
        });
    </script>
@endpush
