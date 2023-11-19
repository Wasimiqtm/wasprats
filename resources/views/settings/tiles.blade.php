<x-app-layout>
    <!-- [ Main Content ] start -->
    <div class="pcoded-main-container">
        <div class="pcoded-wrapper">
            <div class="pcoded-content">
                <div class="pcoded-inner-content">

                    <!-- [ breadcrumb ] start -->
                    <x-breadcrumb title="Tiles Settings" :breadcrumbs="[['name' => 'Settings', 'allow' => true, 'link' => '#']]" />
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
                                        {!! Form::hidden('type', 'tiles') !!}
                                        <div class="card-body row">

                                            <div class="alert alert-success d-none" role="alert">
                                                <p>{{ @$settings['tiles_company_name'] }}</p>
                                            </div>

                                            <div class="form-group col-6">
                                                {!! Form::label('company_name', 'Company', ['class' => 'form-label required-input']) !!}
                                                {!! Form::select('setting[tiles_company_name]', getCompanyList(), @$settings['tiles_company_name'], [
                                                    'class' => 'form-control',
                                                    'placeholder' => 'Company Name',
                                                ]) !!}
                                            </div>
                                            <div class="form-group col-6">
                                                {!! Form::label('undefined', '', ['class' => 'form-label required-input']) !!}
                                                {!! Form::select('setting[tiles_undefined]', [], @$settings['tiles_undefined'], [
                                                    'class' => 'form-control',
                                                    'placeholder' => '',
                                                ]) !!}
                                            </div>

                                            <div class="form-group col-6">
                                                {!! Form::label('customer_name', 'Customer', ['class' => 'form-label required-input']) !!}
                                                {!! Form::select('setting[tiles_customer_name]', getCustomerList(), @$settings['tiles_customer_name'], [
                                                    'class' => 'form-control',
                                                    'placeholder' => 'Customer Name',
                                                ]) !!}
                                            </div>
                                            <div class="form-group col-6">
                                                {!! Form::label('undefined', '', ['class' => 'form-label required-input']) !!}
                                                {!! Form::select('setting[tiles_undefined]', [], @$settings['tiles_undefined'], [
                                                    'class' => 'form-control',
                                                    'placeholder' => '',
                                                ]) !!}
                                            </div>

                                            <div class="form-group col-6">
                                                {!! Form::label('location_name', 'Location', ['class' => 'form-label required-input']) !!}
                                                {!! Form::select('setting[tiles_location_name]', [], @$settings['tiles_location_name'], [
                                                    'class' => 'form-control',
                                                    'placeholder' => 'Location Name',
                                                ]) !!}
                                            </div>
                                            <div class="form-group col-6">
                                                {!! Form::label('undefined', '', ['class' => 'form-label required-input']) !!}
                                                {!! Form::select('setting[tiles_undefined]', [], @$settings['tiles_undefined'], [
                                                    'class' => 'form-control',
                                                    'placeholder' => '',
                                                ]) !!}
                                            </div>

                                            <div class="form-group col-6">
                                                {!! Form::label('service_name', 'Service', ['class' => 'form-label required-input']) !!}
                                                {!! Form::select('setting[tiles_service_name]', getServiceList(), @$settings['tiles_service_name'], [
                                                    'class' => 'form-control',
                                                    'placeholder' => 'Service Name',
                                                ]) !!}
                                            </div>
                                            <div class="form-group col-6">
                                                {!! Form::label('invoice', 'Invoice', ['class' => 'form-label required-input']) !!}
                                                {!! Form::select(
                                                    'setting[tiles_invoice_total]',
                                                    ['invoice_total' => 'Invoice Total'],
                                                    @$settings['tiles_invoice_total'],
                                                    [
                                                        'class' => 'form-control',
                                                        'placeholder' => '',
                                                    ],
                                                ) !!}
                                            </div>

                                            <div class="form-group col-6">
                                                {!! Form::label('service_country', 'Service Country', ['class' => 'form-label required-input']) !!}
                                                {!! Form::select('setting[tiles_service_country]', getCountryList(), @$settings['tiles_service_country'], [
                                                    'class' => 'form-control',
                                                    'placeholder' => 'Service Country',
                                                ]) !!}
                                            </div>
                                            <div class="form-group col-6">
                                                {!! Form::label('service_city', 'Service City', ['class' => 'form-label required-input']) !!}
                                                {!! Form::select('setting[tiles_service_city]', getCountryList(), @$settings['tiles_service_city'], [
                                                    'class' => 'form-control',
                                                    'placeholder' => 'Service City',
                                                ]) !!}
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
