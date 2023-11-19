<x-app-layout>
    <div class="pcoded-main-container">
        <div class="pcoded-content">
            <x-breadcrumb title="Customers Details"/>

            <div class="row">
                <div class="row">
                    <!-- [ basic-table ] start -->
                    <div class="col-xl-12">
                        <div class="card card-custom gutter-b example example-compact">
                            <!--begin::Form-->
                            <div class="card-body">
                                @include('customers.tab')

                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active">
                                        @if(request()->type=='notes')
                                            @include('customers.customer_details.notes')
                                        @elseif(request()->type=='task')
                                            @include('customers.customer_details.task')
                                        @elseif(request()->type =='estimate')
                                            @include('customers.customer_details.Estimates')
                                        @elseif(request()->type =='invoices')
                                            @include('customers.customer_details.Invoices')
                                        @elseif(request()->type ==='credit')
                                            @include('customers.customer_details.Credits')
                                        @elseif(request()->type =='payments')
                                            @include('customers.customer_details.Payments')
                                        @elseif(request()->type =='jobs')
                                            @include('customers.customer_details.job')
                                        @endif
                                    </div>
                                </div>

                            </div>
                            <!--end::Card-->
                        </div>
                    </div>
                    <!-- [ basic-table ] end -->
                </div>

            </div>
        </div>
    </div>
    @push('scripts')
        <script src="{{asset('js/plugins/datepicker-full.min.js')}}"></script>
        <script>

            $("body").on('click', "#notess", function () {
                $("#notesModal").modal('show')
            })

            $("#saveNotes").click(function () {
                if ($("#notesData").val() === '') {
                    alert('Pleas Provide Notes');
                    return false;
                } else {
                    $.ajax({
                        url: '{{route('customers.notes')}}',
                        type: 'POST',
                        "headers": {'X-CSRF-TOKEN': "{{csrf_token()}}"},
                        data: {
                            id: "{{request()->customer_id}}",
                            notes: $("#notesData").val()

                        },
                        success: function (data) {

                            $("#notesModal").hide();
                            $("div.modal-backdrop").remove();
                            $("body").css({'overflow': 'auto', 'padding-right': '0px'});
                            window.location.reload();

                        }
                    })
                }
            })

            $("body").on('click', "#addTask", function () {
                $("#task_name").val('')

                $("#datePick").val('')

                $("#timePick").val('')
                $("#userID").val('');
                $("#task_id").val(0);
                $("#taskModal").modal('show')
            })
            $("body").on('click', "#saveTask", function () {
                if ($("#task_name").val() === '') {
                    alert('Please add task')
                    return false
                }
                if ($("#datePick").val() === '') {
                    alert('Please select data')
                    return false
                }
                if ($("#timePick").val() === '') {
                    alert('Please select time')
                    return false
                }
                if ($("#userID").val() === '') {
                    alert('Please select user')
                    return false
                }

                $.ajax({
                    url: '{{route('customers.tasks')}}',
                    type: 'POST',
                    "headers": {'X-CSRF-TOKEN': "{{csrf_token()}}"},
                    data: {
                        id: "{{request()->customer_id}}",
                        task_name: $("#task_name").val(),
                        dated: $("#datePick").val(),
                        time: $("#timePick").val(),
                        user_id: $("#userID").val(),
                        task_id: $("#task_id").val(),


                    },
                    success: function (data) {

                        $("#taskModal").hide();
                        $("div.modal-backdrop").remove();
                        $("body").css({'overflow': 'auto', 'padding-right': '0px'});
                        window.location.reload();
                    }
                })

            })
            $("body").on('click', ".editTask", function () {
                var id = $(this).attr('data-id')
                $.ajax({
                    url: '{{route('customers.tasks.edit')}}',
                    type: 'POST',
                    "headers": {'X-CSRF-TOKEN': "{{csrf_token()}}"},
                    data: {
                        id: id,


                    },
                    success: function (data) {


                        $("#task_name").val(data.data.description)

                        $("#datePick").val(data.data.due_date)

                        $("#timePick").val(data.data.time)
                        $("#userID").val(data.data.user_id);
                        $("#task_id").val(data.data.id);
                        $("#taskModal").modal('show');
                    }
                })
            })
            $("body").on('click', ".completeTask", function () {
                var id = $(this).attr('data-id')
                $.ajax({
                    url: '{{route('customers.tasks.complete')}}',
                    type: 'POST',
                    "headers": {'X-CSRF-TOKEN': "{{csrf_token()}}"},
                    data: {
                        id: id,


                    },
                    success: function (data) {
                        window.location.reload();
                    }
                })
            });
            $("body").on('click', ".deleteTask", function () {
                var id = $(this).attr('data-id')

                $.ajax({
                    url: '{{route('customers.tasks.delete')}}',
                    type: 'POST',
                    "headers": {'X-CSRF-TOKEN': "{{csrf_token()}}"},
                    data: {
                        id: id,


                    },
                    success: function (data) {
                        window.location.reload();
                    }
                })
            });

            function defaultComponet(type) {

                $.ajax({
                    url: '{{route('customers.type')}}',
                    type: 'POST',
                    "headers": {'X-CSRF-TOKEN': "{{csrf_token()}}"},
                    data: {
                        id: "{{request()->customer_id}}",
                        type: type


                    },
                    success: function (data) {
                        if (type === 'notes') {
                            $("#pills-home").html('')
                            $("#pills-home").html(data)
                        } else {
                            $("#pills-profile").html('')
                            $("#pills-profile").html(data)
                        }

                    }
                })
            }
        </script>

    @endpush


</x-app-layout>
