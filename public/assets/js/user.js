var table;
$(document).ready(function() {
     "use strict";

    var inputdata = {};
        inputdata[BDTASK.csrf_token()] = BDTASK.csrf_hash();

    //datatables
    table = $('#ajaxtable').DataTable({ 

        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [],        //Initial no order.
        "pageLength": 10,   // Set Page Length
        "lengthMenu":[[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url":  BDTASK.getSiteAction('backend/user/ajax-list'),
            "type": "POST",
            "data": inputdata
        },
        //Set column definition initialisation properties.
        "columnDefs": [
            { 
                "targets": [0], //first column / numbering column
                "orderable": false, //set not orderable
            },
        ],
        dom: "<'row'<'col-sm-6 text-left'B><'col-sm-6'f>>tp", 
        buttons: [
            {
                extend: 'copy',
                text: '<i class="far fa-copy"></i>',
                titleAttr: 'Copy',
                className: 'btn-success',                               
               "action": newexportaction

            },
            {
                extend: 'excel',
                text: '<i class="far fa-file-excel"></i>',
                titleAttr: 'Excel',
                className: 'btn-success',                               
               "action": newexportaction
            },
            {
                extend: 'pdf',
                text: '<i class="far fa-file-pdf"></i>',
                titleAttr: 'PDF',
                className: 'btn-success',                               
               "action": newexportaction
            },
            {
                extend: 'print',
                text: '<i class="fa fa-print" aria-hidden="true"></i>',
                titleAttr: 'Print',
                className: 'btn-success',                               
               "action": newexportaction
            },
            {
                extend: 'colvis',
                className: 'btn-success',                               
               "action": newexportaction
            },
        ],

       "fnInitComplete": function (oSettings, response) {
        }
    });
    $.fn.dataTable.ext.errMode = 'none';


    $('#ajaxtable').on('click', '.actionDelete', function(e){
            e.preventDefault();
            var id = $(this).attr('data-id');
            var url = $(this).attr('data-url');
            var message = $(this).attr('data-message');
            swal({
                title: "You are about to delete this user and all of user's information. ",
                text: "Do you wish to delete this user?",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                cancelButtonClass: "btn-success",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel!",
                closeOnConfirm: false,
                closeOnCancel: false
              },
              function(isConfirm) {
                if (isConfirm) {               
                 $.ajax({
                     type: 'DELETE',
                     url: url, 
                     dataType: 'JSON',
                     error: function() {
                       swal("Not deleted!", "Something is wrong. Please try again", "error");
                       // alert('Sorry dear Something is wrong');
                     },
                     success: function(data) {
                        if(data.success==true){
                            swal("Deleted!", data.message, "success");
                            $('#ajaxtable').DataTable().ajax.reload(null, false);
                        }else{
                             swal("Not deleted!", "Something is wrong. Please try again", "error");                            
                        }                          
                     }
                  });
                } else {
                  swal("Cancelled", "User is safe :)", "error");
                }
              });
        
    });

    $('#ajaxtable').on('click', '.manualVerify', function(e){

            e.preventDefault();

            var id          = $(this).attr('data-id');
            var message     = $(this).attr('data-message');
            var verify_type = $(this).attr('verify-type');

            var inputdata                  = {};
            inputdata['id']                = id;
            inputdata['verify_type']       = verify_type;
            inputdata[BDTASK.csrf_token()] = BDTASK.csrf_hash();

            $(this).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading.');
            $(this).removeClass('btn-success');
            $(this).addClass('btn-success');


            swal({
                title: "You are about to verify this user. ",
                text: "Do you wish to verify this user?",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-success ",
                cancelButtonClass: "btn-danger",
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                closeOnConfirm: false,
                closeOnCancel: false
              },
              function(isConfirm) {
                if (isConfirm) {               
                 $.ajax({
                     url: BDTASK.getSiteAction('backend/user/manual-verify'), 
                     type: 'POST',
                     data: inputdata,
                     dataType: 'JSON',
                     success: function(data) {

                        if(data.status=='success'){
                            swal("Verified!", data.msg, "success");
                            $('#ajaxtable').DataTable().ajax.reload(null, false);
                        } else {
                            swal("Not verify!", "Something is wrong. Please try again", "error");
                            $('#ajaxtable').DataTable().ajax.reload(null, false);                            
                        }                          
                     },
                     error: function() {
                       swal("Not verify!", "Something is wrong. Please try again", "error");
                        $('#ajaxtable').DataTable().ajax.reload(null, false);
                     }
                    
                  });
                } else {
                  swal("Cancelled", "User is unverified :)", "warning");
                  $('#ajaxtable').DataTable().ajax.reload(null, false);
                }
              });
        
    });

"use strict";    
function newexportaction(e, dt, button, config) {
    var self = this;
    var oldStart = dt.settings()[0]._iDisplayStart;
    dt.one('preXhr', function (e, s, data) {
        // Just this once, load all data from the server...
        data.start = 0;
        data.length = 2147483647;
        dt.one('preDraw', function (e, settings) {
            // Call the original action function
            if (button[0].className.indexOf('buttons-copy') >= 0) {
                $.fn.dataTable.ext.buttons.copyHtml5.action.call(self, e, dt, button, config);
            } else if (button[0].className.indexOf('buttons-excel') >= 0) {
                $.fn.dataTable.ext.buttons.excelHtml5.available(dt, config) ?
                    $.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, button, config) :
                    $.fn.dataTable.ext.buttons.excelFlash.action.call(self, e, dt, button, config);
            } else if (button[0].className.indexOf('buttons-csv') >= 0) {
                $.fn.dataTable.ext.buttons.csvHtml5.available(dt, config) ?
                    $.fn.dataTable.ext.buttons.csvHtml5.action.call(self, e, dt, button, config) :
                    $.fn.dataTable.ext.buttons.csvFlash.action.call(self, e, dt, button, config);
            } else if (button[0].className.indexOf('buttons-pdf') >= 0) {
                $.fn.dataTable.ext.buttons.pdfHtml5.available(dt, config) ?
                    $.fn.dataTable.ext.buttons.pdfHtml5.action.call(self, e, dt, button, config) :
                    $.fn.dataTable.ext.buttons.pdfFlash.action.call(self, e, dt, button, config);
            } else if (button[0].className.indexOf('buttons-print') >= 0) {
                $.fn.dataTable.ext.buttons.print.action(e, dt, button, config);
            }
            dt.one('preXhr', function (e, s, data) {
                // DataTables thinks the first item displayed is index 0, but we're not drawing that.
                // Set the property to what it was before exporting.
                settings._iDisplayStart = oldStart;
                data.start = oldStart;
            });
            // Reload the grid with the original page. Otherwise, API functions like table.cell(this) don't work properly.
            setTimeout(dt.ajax.reload, 0);
            // Prevent rendering of the full data to the DOM
            return false;
        });
    });
    // Requery the server with the new one-time export settings
    dt.ajax.reload();
};



});
