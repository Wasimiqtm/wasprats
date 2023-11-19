
    <div class="pcoded-main-container">
        <div class="pcoded-content">


            <div class="row">
                <div class="col-xl-12 col-md-12">
                    <div class="card user-profile-list">
                        <div class="card-body-dd theme-tbl">
                            <a class="btn btn-primary" id="addTask">Add New Task</a>
                            <div class="row"  >
                                @if(isset($customerTask))
                                    @foreach($customerTask as $value)
                                        <div class="col-xl-4 col-md-6">

                                            <div class="card user-card user-card-2 shape-center">
                                                <div class="card-header border-0 p-2 pb-0">
                                                    <div class="cover-img-block">

                                                    </div>
                                                </div>
                                                <div class="card-body pt-0">
                                                    <div class="user-about-block text-center">
                                                        <div class="row align-items-end">
                                                            <div class="col text-left pb-3"></div>

                                                            <div class="col text-end pb-3">
                                                                <div class="dropdown">
                                                                    <a class="drp-icon dropdown-toggle"
                                                                       data-bs-toggle="dropdown"
                                                                       aria-haspopup="true" aria-expanded="false"><i
                                                                            class="feather icon-more-horizontal"></i></a>
                                                                    <div class="dropdown-menu dropdown-menu-end">

                                                                        <a class="dropdown-item deleteTask"
                                                                           href="javascript:void(0)" data-id="{{$value->id}}"><i class="feather icon-delete"></i></a>
                                                                        @if($value->status =='pending')
                                                                            <a class="dropdown-item editTask"
                                                                               href="javascript:void(0)" data-id="{{$value->id}}" ><i class="feather icon-edit"></i></a>
                                                                            <a class="dropdown-item completeTask"
                                                                               href="javascript:void(0)" data-id="{{$value->id}}"><i class="feather icon-check"></i></a>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="text-center">
                                                        <h6 class="mb-1 mt-3">{{$value->description}}</h6>
                                                        <p class="mb-3 text-muted">{{$value->due_date}}</p>
                                                        <p class="mb-1">{{date('h:i A', strtotime($value->time))}}</p>
                                                        <p class="mb-0">{{$value->users->name}}</p>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="taskModal" tabindex="-1" aria-labelledby="exampleModalFullscreenLabel"
         style="display: none;" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h4" id="exampleModalFullscreenLabel">
                        Add Notes
                    </h5>


                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="task_id" value="0">
                    <div class="form-group row">
                        <label class="col-form-label col-lg-3 col-sm-12 text-lg-end">Task</label>
                        <div class="col-lg-9 col-sm-12">
                            <input type="text" class="form-control " id="task_name" placeholder="Select Task">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-3 col-sm-12 text-lg-end">Date</label>
                        <div class="col-lg-9 col-sm-12">
                            <input type="date" class="form-control datepicker-input" id="datePick"
                                   placeholder="Select date">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-3 col-sm-12 text-lg-end">Time</label>
                        <div class="col-lg-9 col-sm-12">
                            <input type="time" class="form-control datepicker-input" id="timePick"
                                   placeholder="Select date">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-3 col-sm-12 text-lg-end" for="inputState">Select user</label>
                        <div class="col-lg-9 col-sm-12">
                            <select id="userID" class="form-select">
                                @foreach($users as $value)
                                    <option value="{{$value->id}}">{{$value->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary shadow-2" id="saveTask">Save
                        changes
                    </button>
                </div>
            </div>
        </div>
    </div>

