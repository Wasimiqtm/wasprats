<x-app-layout>
    <!-- [ Main Content ] start -->
    <div class="pcoded-main-container">
        <div class="pcoded-wrapper">
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    
                    <!-- [ breadcrumb ] start -->
                    <x-breadcrumb title="Change Password" :breadcrumbs="[['name' => 'Users', 'allow' => true, 'link' => route('users.index')],['name' => 'Create', 'allow' => true, 'link' => route('users.create')]]" />
                    <!-- [ breadcrumb ] end -->
                    
                    <div class="main-body">
                        <div class="page-wrapper">
                            <!-- [ Main Content ] start -->
                            <div class="row">
                                <!-- [ basic-table ] start -->
                                <div class="col-xl-12">
                                    <div class="card card-custom gutter-b example example-compact">
                                        <!--begin::Form-->
                                        {!! Form::open(['route' => 'users.change-password', 'id' => 'formValidation']) !!}
                                            <div class="card-body">
                                                <div class="form-group col-md-6">
                                                    {!! Form::label('password', 'Password', ['class' => 'form-label required-input']) !!}
                                                    {!! Form::password('password', ['class' => 'form-control ' . $errors->first('password', 'error'), 'placeholder' => 'Password', 'required']) !!}
                                                    {!! $errors->first('password', '<label class="error">:message</label>') !!}
                                                </div>
                                                <div class="form-group col-md-6">
                                                    {!! Form::label('password_confirmation', 'Confirm Password', ['class' => 'form-label required-input']) !!}
                                                    {!! Form::password('password_confirmation', ['class' => 'form-control ' . $errors->first('password_confirmation', 'error'), 'placeholder' => 'Confirm Password', 'required']) !!}
                                                    {!! $errors->first('password_confirmation', '<label class="error">:message</label>') !!}
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <button type="submit" class="btn btn-primary mr-2">Update Password</button>
                                                <button type="button" onclick="window.location='{{ URL::previous() }}'" class="btn btn-secondary">Cancel</button>
                                            </div>
                                        {!! Form::close() !!}        <!--end::Card-->
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


    @push('scripts')    
    <script src="{{ asset('js/plugins/jquery.validate.min.js') }}"></script>
    <script type="text/javascript">
        $('document').ready(function () {
            $('#formValidation').validate();
        });
    </script>
    @endpush

</x-app-layout>