let _$ = $(document);

$.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

_$.ajaxError(function (event, jqxhr, settings, thrownError) {
   if (jqxhr.status === 401) {
       console.log(401);
      //document.location.href = route('login');
   }
});

document.querySelectorAll('.dropdown-menu a').forEach(function(element){
    element.addEventListener('click', function (e) {
        let nextEl = this.nextElementSibling;
        if(nextEl && nextEl.classList.contains('submenu')) {
          // prevent opening link if link needs to open dropdown
          e.preventDefault();
          if(nextEl.style.display == 'block'){
            nextEl.style.display = 'none';
          } else {
            nextEl.style.display = 'block';
          }

        }
    });
  })

_$.ready(function(){

    if (typeof $(".datepicker") !== 'undefined' && $(".datepicker").datepicker) {
        $(".datepicker").datepicker();
    }


    $('[data-toggle="tooltip"]').tooltip();

    if (typeof $(".select2") !== 'undefined' && $(".select2").select2) {
        $(".select2").select2({
            placeholder: "Select Option",
            allowClear: true
        });
    }

    $('#datatable').on('click', '.btn-delete', function (e)
    {
        e.preventDefault();
        $datatable = $(this).parents('.datatable');
        var url= $(this).attr('href');

        $.confirm({
            title: 'Confirm!',
            content: 'Are you sure! You want remove this record',
            type: 'red',
            typeAnimated: true,
            closeIcon: true,
            buttons: {
                confirm: function () {
                    $datatable.find("tbody").LoadingOverlay("show");
                    $.ajax({
                        type: "delete",
                        url: url,
                        dataType: "json",
                        complete:function (res) {
                            $datatable.find("tbody").LoadingOverlay("hide");
                            var result = JSON.parse(res.responseText);
                            //var result = j.result;
                            if(res.status == 200){
                                reloadDatatable($datatable);
                                successMessage(result.message);
                            }else{
                                errorMessage(result.message);
                            }
                        },
                          error: function (request, status, error) {
                              $datatable.find("tbody").LoadingOverlay("hide");
                              var result = request.responseJSON.result;
                              var err = JSON.parse(request.responseText);
                              if(status == 401){
                                errorMessage(result.message);
                            }else{
                                errorMessage(err.message);
                            }
                          }
                    });
                },
                cancel: function () { },
            }
        });

        return false;
    });

});

/**
 * Create Ajax Datatables
 * @param url
 * @param columns
 * @param index_field
 * @param ordering
 * @param pageLength
 * @param permitOrder
 */
function create_datatables (url, columns, index_field = true, ordering = [], pageLength=10, permitOrder = true, exportData = false, exportButtons = ['csv', 'excel', 'pdf', 'print'],postData={})
{

    let datatable_id = 'datatable';
    if (index_field) {
        $('#'+datatable_id+' thead tr').prepend("<th>#</th>");
        $('#'+datatable_id+' tfoot tr').prepend("<th>#</th>");

        columns.unshift({name:'index', data: 'index', width: '2%', className: 'text-center', orderable: false, searchable: false});
    }

    var options = {
        // search: {return: true},
        oLanguage: { sProcessing: '<img src="'+ Ziggy.url +'/images/bx_loader.gif">' },
        processing: true,
        serverSide: true,
        ordering: permitOrder,
        responsive: true,
        pageLength: pageLength,
        bLengthChange: (pageLength>0)?(pageLength==30?false:true):false,
        paging: (pageLength>0)?true:false,
        info: (pageLength>0)?(pageLength==30?false:true):false,
        ajax: {
            url: url,
            type:'POST',
            "data": function ( d ) {
                return $.extend( {}, d, {
                    "extra_search": JSON.stringify(postData)
                } );
            }
        },
        columns: columns,
        order: ordering,
        drawCallback: function ( settings ) {
            var api = this.api();

            if (index_field) {
                api.column(0).nodes().each(function (cell, i) {
                    var index = (i+1) + (t.page.info().page * t.page.info().length);
                    cell.innerHTML = index;
                });
            }
        }
    };

    if (exportData) {
        options.dom = 'Bfrtip';
        options.buttons = exportButtons;
    }

    var t = $('#'+datatable_id).DataTable(options);

    return t;
}

/**
 * Show Dropdown
 * @param el
 * @param show
 */
function loadDropdown(el, show = false) {
    $url = el.attr('data-url');
    $ddName = el.attr('name');
    $selected = el.attr('data-selectedid');
    $otherIdName = (el.attr('data-otheridname')) ? el.attr('data-otheridname') : '';
    $otherIdValue = (el.attr('data-otheridvalue')) ? el.attr('data-otheridvalue') : '';

    $id = $selected;
    $ddName = $ddName;

    let _self = $('#select2-' + $ddName + '-container');
    loadingOverlay(_self, show);
    $.ajax({
        type: "POST",
        url: $url,
        data: {
            'id': $id,
            'ddName': $ddName,
            'otherIdValue': $otherIdValue
        },
        dataType: "json",
        success: function (data, textStatus, jqXHR) {
            stopOverlay(_self, show);
            $('select[name=' + data.request.ddName + ']').html(data.options);
        },
        error: function (data, textStatus, jqXHR) {
            stopOverlay(_self, show);
            //process error msg
        },
    });
}

/**
 * Show Ajax Error Message
 * @param response
 */
function showAjaxErrorMessage(response, form = false)
{
    let responseJson = JSON.parse(response.responseText);
    let errors = responseJson.errors;

    if (form) {
        if (errors !== undefined) {
            Object.keys(errors).forEach(function (item) {
                for (let value of errors[item]) {
                    $('[name=' + item + ']').parent('.form-group').find(".text-danger").text(value);
                    $('#' + item + '-error').text(value);
                    $('[name=' + item + ']').addClass('is-invalid');
                }
            });
        }
    }
    if (errors !== undefined) {
        Object.keys(errors).forEach(function (item) {
            for (let value of errors[item]) {
                errorMessage(value);
            }
        });
    } else if (responseJson.message !== undefined) {
        errorMessage(responseJson.message);
    }

}

/**
 * Loading overlay js
 * @param _ele
 */
let loadingOverlay = (_ele, show = true) => {
    if (show) {
        _ele.LoadingOverlay('show');
    }
}

/**
 * Stopping overlay js
 * @param _ele
 */
let stopOverlay = (_ele, hide = true) => {
    if (hide) {
        _ele.LoadingOverlay('hide');
    }
}

$.fn.serializeFiles = function () {
    let form = $(this),
        formData = new FormData(),
        formParams = form.serializeArray();

    $.each(form.find('input[type="file"]'), function (i, tag) {
        $.each($(tag)[0].files, function (i, file) {
            formData.append(tag.name, file);
        });
    });

    $.each(formParams, function (i, val) {
        formData.append(val.name, val.value);
    });

    return formData;
};

/**
 * Reload Datatable
 * @param _ele
 */
function reloadDatatable (tableId = '#datatable') {
    let _datatable = $(tableId);
    let reloadDatatable = _datatable.dataTable({ bRetrieve : true });
    if(reloadDatatable != ""){
        reloadDatatable.fnDraw();
    }
}

/**
 * Generate Random Number
 * @param length
 */
function generateRandomNumber (length) {
    if(!length) { length = 16; }
    //var chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    var chars = "1234567890";
    var result="";

    for (var i = length; i > 0; --i)
        result += chars[Math.round(Math.random() * (chars.length - 1))]
    return result
}

_$.ready(function(){
    $('.tooltips').tooltip();
    $('[data-toggle="tooltip"]').tooltip();
});


/**
 * Show Success Message
 * @param message
 * @param flag
 */
function showMessage(message, flag = true)
{
    if (flag) {
        successMessage(message);
    } else {
        errorMessage(message);
    }
}

/**
 * Show Success Message
 * @param message
 * @param title
 */
function successMessage(message, title)
{
    if (!title) title = "Success!";
    toastr.remove();
    toastr.success(message, title, {
        closeButton: true,
        timeOut: 4000,
        progressBar: true,
        newestOnTop: true
    });
}

/**
 * Show Error Message
 * @param message
 * @param title
 */
function errorMessage(message, title)
{
    if (!title) title = "Error!";
    toastr.remove();
    toastr.error(message, title, {
        closeButton: true,
        timeOut: 4000,
        progressBar: true,
        newestOnTop: true
    });
}

/**
 * Validate Phone Number
 * @param $number
 */
function validatePhoneNumber(number)
{
    regex = /^03[0-9]{9}$/;
    return regex.test(number);
}

/**
 * Validate Cnic Number
 * @param $number
 */
function validateCnicNumber(number)
{
    regex = /^[1-9]{1}[0-9]{12}$/;
    $format = regex.test(number);
    $repeat0 = /^[0-9]*[0]{6}[0-9]*$/.test(number);
    $repeat1 = /^[0-9]*[1]{6}[0-9]*$/.test(number);
    $repeat2 = /^[0-9]*[2]{6}[0-9]*$/.test(number);
    $repeat3 = /^[0-9]*[3]{6}[0-9]*$/.test(number);
    $repeat4 = /^[0-9]*[4]{6}[0-9]*$/.test(number);
    $repeat5 = /^[0-9]*[5]{6}[0-9]*$/.test(number);
    $repeat6 = /^[0-9]*[6]{6}[0-9]*$/.test(number);
    $repeat7 = /^[0-9]*[7]{6}[0-9]*$/.test(number);
    $repeat8 = /^[0-9]*[8]{6}[0-9]*$/.test(number);
    $repeat9 = /^[0-9]*[9]{6}[0-9]*$/.test(number);

    if ($format && !$repeat0 && !$repeat1 && !$repeat2 && !$repeat3 && !$repeat4 && !$repeat5 && !$repeat6 && !$repeat7 && !$repeat8 && !$repeat9) {
        return true;
    }
    return false;
}




