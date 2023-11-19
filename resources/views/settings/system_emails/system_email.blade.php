<x-app-layout>
    <div class="pcoded-main-container">
        <div class="pcoded-content">
            <x-breadcrumb title="System Sms and emails" :button="[]"/>

            <div class="row">
                <div class="col-xl-12 col-md-12">
                    <div class="card user-profile-list">
                        <div class="card-body-dd theme-tbl">
                            <div class="menu-right system-emails" style="display: block;">
                                <div id="system-emails-grid" class="grid-view">
                                    <table class="items table table-striped">
                                        <thead>
                                        <tr>
                                            <th id="system-emails-grid_c0"></th>
                                            <th id="system-emails-grid_c1"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($data as $value)


                                        <tr class="odd">
                                            <td><a class="preview-ajax" rel="625" templateid="{{$value->id}}">{{$value->name}}</a>
                                            </td>
                                            <td></td>
                                        </tr>

                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
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
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/plugins/simplemde.min.css') }}">
    @endpush
    @push('scripts')
        <script src="{{ asset('js/plugins/simplemde.min.js') }}"></script>
        <script>
            $("document").ready(function () {
                var editor = new SimpleMDE({ element: document.querySelector("#pc_demo1"),forceSync:true });
                $(".preview-ajax").on('click', function () {
                    var id = $(this).attr('templateid');
                   $.ajax({
                       url:'{{route('get.template')}}',
                       type:'POST',
                       "headers": {'X-CSRF-TOKEN': "{{csrf_token()}}"},
                       data:{
                           id:id,

                       },
                       success:function(data){



                           editor.value(data.description);
                           $("#sms").val(data.sms_text);
                           $("#subjectData").val(data.subject);

                          $('#exampleModalFullscreenLabel').text(data.name);
                           $('#exampleModalFullscreen').modal('show')
                       }
                   })

                })
                $('#exampleModalFullscreen').on('shown.bs.modal', function () {

                    editor.codemirror.refresh();
                });
                var lastFocused;
                $('input').on('focusin', function(){
                    lastFocused = $(this).attr('id');

                });

                editor.codemirror.on("focus", function(){
                    lastFocused='editor'
                });
                $('#tags').on('change',function(){

                    if(lastFocused =='editor') {
                        var pos = editor.codemirror.getCursor();
                        editor.codemirror.setSelection(pos, pos);
                        editor.codemirror.replaceSelection($(this).val());
                    }else{
                        setTextToCurrentPos(lastFocused,$(this).val())

                    }
                });

                function setTextToCurrentPos(lastFocused,value) {
                    var curPos =
                        document.getElementById(lastFocused).selectionStart;
                    console.log(curPos);
                    let x =$("#"+lastFocused).val();
                    let text_to_insert =value;
                    $("#"+lastFocused).val(
                        x.slice(0, curPos) + text_to_insert + x.slice(curPos));
                }
            });
        </script>
    @endpush
</x-app-layout>
