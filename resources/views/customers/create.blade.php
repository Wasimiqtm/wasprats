<x-app-layout>
    <!-- [ Main Content ] start -->
    <div class="pcoded-main-container">
        <div class="pcoded-wrapper">
            <div class="pcoded-content">
                <div class="pcoded-inner-content">

                    <!-- [ breadcrumb ] start -->
                    <x-breadcrumb title="Add Customer" :breadcrumbs="[
                        ['name' => 'Customers', 'allow' => true, 'link' => route('customers.index')],
                        ['name' => 'Add', 'allow' => true, 'link' => route('customers.create')],
                    ]" />
                    <!-- [ breadcrumb ] end -->

                    <div class="main-body">
                        <div class="page-wrapper">
                            <!-- [ Main Content ] start -->
                            <div class="row">
                                <!-- [ basic-table ] start -->
                                <div class="col-xl-12">
                                    <div class="card card-custom gutter-b example example-compact">
                                        <!--begin::Form-->
                                        {!! Form::open(['route' => 'customers.store', 'id' => 'formValidation']) !!}
                                        <div class="card-body row">
                                            @include ('customers.form')
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


    @push('scripts')
        <script src="{{ asset('js/plugins/jquery.validate.min.js') }}"></script>
        <script type="text/javascript">
            $('document').ready(function() {
                $('#formValidation').validate();
            });
        </script>
    @endpush

</x-app-layout>
