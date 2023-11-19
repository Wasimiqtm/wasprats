<x-app-layout>
    <!-- [ Main Content ] start -->
    <div class="pcoded-main-container">
        <div class="pcoded-wrapper">
            <div class="pcoded-content">
                <div class="pcoded-inner-content">

                    <!-- [ breadcrumb ] start -->
                    <x-breadcrumb title="Template Settings" :breadcrumbs="[['name' => 'Settings', 'allow' => true, 'link' => '#']]" />
                    <!-- [ breadcrumb ] end -->

                    <div class="main-body">
                        <div class="page-wrapper">
                            <!-- [ Main Content ] start -->
                            <div class="row">
                                <!-- [ basic-table ] start -->
                                <div class="col-xl-12">
                                    <div class="card card-custom gutter-b example example-compact">
                                        <!--begin::Form-->
                                        {!! Form::open(['route' => 'settings.update', 'id' => 'formValidation']) !!}
                                        {!! Form::hidden('type', 'templates') !!}
                                        <div class="card-body row">
                                            <div class="form-group col-6">
                                                {!! Form::label('invoice_title', 'Invoice Title', ['class' => 'form-label required-input']) !!}
                                                {!! Form::text('setting[invoice_title]', @$settings['invoice_title'], [
                                                    'class' => 'form-control',
                                                    'placeholder' => 'Invoice Title',
                                                    'maxlength' => '100',
                                                ]) !!}
                                            </div>
                                            <div class="form-group col-6">
                                                {!! Form::label('company_address', 'Company Address', ['class' => 'form-label required-input']) !!}
                                                {!! Form::textarea('setting[company_address]', @$settings['company_address'], [
                                                    'class' => 'form-control',
                                                    'placeholder' => 'Company Address',
                                                    'rows' => 1,
                                                ]) !!}
                                            </div>
                                            <div class="form-group col-6">
                                                {!! Form::label('text_below_logo', 'Text Below Your Logo', ['class' => 'form-label required-input']) !!}
                                                {!! Form::text('setting[text_below_logo]', @$settings['text_below_logo'], [
                                                    'class' => 'form-control',
                                                    'placeholder' => 'Text Below Your Logo',
                                                ]) !!}
                                            </div>
                                            <div class="form-group col-6">
                                                {!! Form::label('service_address', 'Service Address', ['class' => 'form-label required-input']) !!}
                                                <br />
                                                <div class="form-check form-check-inline">
                                                    {!! Form::radio('setting[service_address]', 'show', @$settings['service_address'] == 'show', [
                                                        'class' => 'form-check-input',
                                                        'id' => 'r1',
                                                    ]) !!}
                                                    <label class="form-check-label" for="r1">Show</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    {!! Form::radio('setting[service_address]', 'hide', @$settings['service_address'] == 'hide', [
                                                        'class' => 'form-check-input',
                                                        'id' => 'r3',
                                                    ]) !!}
                                                    <label class="form-check-label" for="r2">Always hide</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    {!! Form::radio('setting[service_address]', 'hide_on_print', @$settings['service_address'] == 'hide_on_print', [
                                                        'class' => 'form-check-input',
                                                        'id' => 'r3',
                                                    ]) !!}
                                                    <label class="form-check-label" for="r2">Hide only when
                                                        printing</label>
                                                </div>
                                            </div>
                                            <div class="form-group col-6">
                                                {!! Form::label('location_address_name', 'Location Address Name', ['class' => 'form-label required-input']) !!}
                                                <br />
                                                <div class="form-check">
                                                    {!! Form::checkbox('setting[location_address_name]', 'show', @$settings['location_address_name'] == 'show', [
                                                        'class' => 'form-check-input',
                                                        'id' => 'c1',
                                                    ]) !!}
                                                    <label class="form-check-label" for="c1">Show</label>
                                                </div>
                                            </div>
                                            <div class="form-group col-6">
                                                {!! Form::label('display_payment_method', 'Display Payment Method', ['class' => 'form-label required-input']) !!}
                                                <br />
                                                <div class="form-check">
                                                    {!! Form::checkbox('setting[display_payment_method]', 'show', @$settings['display_payment_method'] == 'show', [
                                                        'class' => 'form-check-input',
                                                        'id' => 'c2',
                                                    ]) !!}
                                                    <label class="form-check-label" for="c2">Show</label>
                                                </div>
                                            </div>
                                            <div class="form-group col-6">
                                                {!! Form::label('check_in_out', 'Check In/Out', ['class' => 'form-label required-input']) !!}
                                                <br />
                                                <div class="form-check">
                                                    {!! Form::checkbox('setting[check_in_out]', 'show', @$settings['check_in_out'] == 'show', [
                                                        'class' => 'form-check-input',
                                                        'id' => 'c2',
                                                    ]) !!}
                                                    <label class="form-check-label" for="c2">Show Check
                                                        In/Out</label>
                                                </div>
                                            </div>
                                            <div class="form-group col-6">
                                                {!! Form::label('service_date', 'Service Date', ['class' => 'form-label required-input']) !!}
                                                <br />
                                                <div class="form-check">
                                                    {!! Form::checkbox('setting[service_date]', 'show', @$settings['service_date'] == 'show', [
                                                        'class' => 'form-check-input',
                                                        'id' => 'c2',
                                                    ]) !!}
                                                    <label class="form-check-label" for="c2">Show the Job Service
                                                        Date</label>
                                                </div>
                                            </div>
                                            <div class="form-group col-6">
                                                {!! Form::label('next_service_date', 'Next Service Date', ['class' => 'form-label required-input']) !!}
                                                <br />
                                                <div class="form-check">
                                                    {!! Form::checkbox('setting[next_service_date]', 'show', @$settings['next_service_date'] == 'show', [
                                                        'class' => 'form-check-input',
                                                        'id' => 'c2',
                                                    ]) !!}
                                                    <label class="form-check-label" for="c2">Show Next Recurring
                                                        Service
                                                        Date</label>
                                                </div>
                                            </div>
                                            <div class="form-group col-6">
                                                {!! Form::label('weather', 'Weather', ['class' => 'form-label required-input']) !!}
                                                <br />
                                                <div class="form-check">
                                                    {!! Form::checkbox('setting[weather]', 'show', @$settings['weather'] == 'show', [
                                                        'class' => 'form-check-input',
                                                        'id' => 'c2',
                                                    ]) !!}
                                                    <label class="form-check-label" for="c2">Show Weather</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-primary mr-2">Submit</button>
                                            <button type="button" onclick="window.location='{{ URL::previous() }}'"
                                                class="btn btn-secondary">Cancel</button>
                                        </div>
                                        {!! Form::close() !!}
                                        <!--end::Card-->
                                    </div>
                                </div>
                                <!-- [ basic-table ] end -->
                            </div>
                            <!-- [ Main Content ] end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ Main Content ] end -->

</x-app-layout>
