
<x-app-layout>
    <div class="pcoded-main-container">
        <div class="pcoded-content">
            <x-breadcrumb title="Estimates" :button="[]" />

            <div class="row">
                <div style="margin: 20px 0px;">

                    <input type="text" name="daterange" value="" />
                    <span data-href="/export-estimates" id="export" class="btn btn-success btn-sm" onclick ="exportTasks (event.target);">Export</span>
                </div>
                <div class="col-xl-12 col-md-12">
                    <div class="card user-profile-list">
                        <div class="card-body-dd theme-tbl">
                            <x-table action="false" checkbox="false" :keys="[
                                'Status	Customer',
                                'Service Address',
                                'Last Service Type',
                                'Job Status',
                                'Last Service Date',

                            ]"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @push('scripts')

        <script src="{{asset('js/plugins/highchart.min.js')}}"></script>
        <script src="{{asset('js/plugins/daterange-picker.js')}}"></script>
        <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.j"></script>
      

    @endpush

</x-app-layout>
