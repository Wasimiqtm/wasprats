
@push('styles')
    <style>
        .date{font-size: 11px}.comment-text{font-size: 12px}.fs-12{font-size: 12px}.shadow-none{box-shadow: none}.name{color: #007bff}.cursor:hover{color: blue}.cursor{cursor: pointer}.textarea{resize: none}
    </style>
@endpush
<div class="pcoded-main-container">
    <div class="pcoded-content">


        <div class="row">
            <div class="col-xl-12 col-md-12">
                <div class="card user-profile-list">
                    <div class="card-body-dd theme-tbl">
                        <a class="btn btn-primary" id="notess">Add Notes</a>
                      <div class="row"  >
                         @foreach($customerNotes as $value)
                              <div class="col-md-8">
                                  <div class="d-flex flex-column comment-section">
                                      <div class="bg-white p-2">
                                          <div class="d-flex flex-row user-info">
                                              <div class="d-flex flex-column justify-content-start ml-2"><span class="d-block font-weight-bold name">{{$value->customers->first_name.' '.$value->customers->last_name}}</span><span class="date text-black-50">{{\Carbon\Carbon::parse($value->created_at)->format('d/m/Y h:i a')}}</span></div>
                                          </div>
                                          <div class="mt-2">
                                              <p class="comment-text">{{$value->description}}</p>
                                          </div>
                                      </div>

                                      <div class="bg-light p-2">
                                          <div class="d-flex flex-row align-items-start"><textarea class="form-control ml-1 shadow-none textarea"></textarea></div>
                                          <div class="mt-2 text-right"><button class="btn btn-primary btn-sm shadow-none" type="button">Post comment</button><button class="btn btn-outline-primary btn-sm ml-1 shadow-none" type="button">Cancel</button></div>
                                      </div>
                                  </div>
                              </div>
                         @endforeach

                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade modal-animate" id="notesModal" tabindex="-1" aria-labelledby="animateModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white">Add Notes</h5>
                <button type=" button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Note</label>
                    <input type="text" id="notesData" class="form-control" placeholder="Write New Note">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary shadow-2" id="saveNotes">Save
                     </button>
            </div>
        </div>
    </div>
</div>
