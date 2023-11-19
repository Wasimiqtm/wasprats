<x-app-layout>

    @php
        $tab = 'job';
        if (request()->filled('tab')) {
            if (in_array(request()->tab, ['invoice', 'estimate'])) {
                $tab = request()->tab;
            }
        }
    @endphp

    <!-- [ Main Content ] start -->
    <div class="pcoded-main-container">
        <div class="pcoded-wrapper">
            <div class="pcoded-content">
                <div class="pcoded-inner-content">

                    <!-- [ breadcrumb ] start -->
                    <x-breadcrumb title="Update Service" :breadcrumbs="[
                        ['name' => 'Services', 'allow' => true, 'link' => route('services.index')],
                        ['name' => 'Update', 'allow' => true, 'link' => '#'],
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
                                        {!! Form::model($service, [
                                            'method' => 'PATCH',
                                            'id' => 'formValidation',
                                            'route' => ['services.update', $service->uuid],
                                        ]) !!}
                                        {!! Form::hidden('id', null) !!}
                                        {!! Form::hidden('tab', $tab) !!}

                                        <div class="card-body">

                                            <ul class="nav nav-pills mb-4 bg-white" id="myTab" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link text-uppercase {{ $tab == 'job' ? 'active' : '' }}"
                                                        href="{{ route('services.edit', [$service->uuid, 'tab' => 'job']) }}">Job
                                                        Details</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link text-uppercase {{ $tab == 'invoice' ? 'active' : '' }}"
                                                        href="{{ route('services.edit', [$service->uuid, 'tab' => 'invoice']) }}">Invoice</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link text-uppercase {{ $tab == 'estimate' ? 'active' : '' }}"
                                                        href="{{ route('services.edit', [$service->uuid, 'tab' => 'estimate']) }}">Estimate</a>
                                                </li>
                                            </ul>
                                            <div class="tab-content" id="myTabContent">
                                                <div class="tab-pane fade show active">
                                                    <div class="row">
                                                        @if ($tab == 'job')
                                                            @include ('services.form')
                                                        @elseif($tab == 'invoice')
                                                            @include ('services.invoice')
                                                        @elseif($tab == 'estimate')
                                                            @include ('services.estimate')
                                                        @endif
                                                    </div>
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
