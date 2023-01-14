var table;
$(document).ready(function() {
     "use strict";

    $('#languageTable').on('click', '.actionDelete', function(e){
            e.preventDefault();
            var id = $(this).attr('data-id');
            var url = $(this).attr('data-url');
            var message = $(this).attr('data-message');
            swal({
                title: "You are about to delete this language. ",
                text: "Do you wish to delete this language?",
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
                            location.reload(true);
                        }else{
                             swal("Not deleted!", data.message, "error");                            
                        }                          
                     }
                  });
                } else {
                  swal("Cancelled", "Language is safe :)", "error");
                }
              });
        
    });

 
});
