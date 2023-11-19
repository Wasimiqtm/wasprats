<x-app-layout>
    <div class="pcoded-main-container">
        <div class="pcoded-content">
            <x-breadcrumb title="Custom Automated Messages" :button="['name' => 'New Message', 'allow' => true, 'link' =>'javascript:void(0)']" />

            <div class="row">
                <div class="col-xl-12 col-md-12">
                    <div class="card user-profile-list">
                        <div class="card-body-dd theme-tbl">
                            <x-table action="false" checkbox="false" :keys="['Type', 'Name', '']" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.dataTablesFiles')
    <div class="modal fade" id="exampleModalFullscreen" tabindex="-1" aria-labelledby="exampleModalFullscreenLabel"
         style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h4" id="exampleModalFullscreenLabel">
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="subject" class="form-label">Subject</label>
                        <input type="text" class="form-control" id="subjectData" placeholder="subject">
                    </div>
                    <textarea class="form-control" id="pc_demo1"></textarea>


                    <select id="tags">
                        <option> Insert Email Variable</option>
                        @foreach(getTags() as $key=>$value)
                            <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                    </select>
                    <h3>SMS</h3>
                    <textarea  class="form-control"  id="sms" disabled cols="10" ></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script type="text/javascript">
            $("document").ready(function() {
                var datatable_url = route('custom.sms.ajax');
                var datatable_columns = [{
                    data: 'type'
                },
                    {
                        data: 'name'
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    }
                ];

                create_datatables(datatable_url, datatable_columns);
            });
        </script>
    @endpush


</x-app-layout>
