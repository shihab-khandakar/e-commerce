$(document).ready(function() {
    // Check Admin password is correct or incorrect
    $('#current_pwd').keyup(function(){
        var current_pwd = $('#current_pwd').val();
        // alert(current_pwd);
        $.ajax({
            type: 'POST',
            url:"/admin/check-current-pwd",
            data:{current_pwd:current_pwd},
            success: function(response){
                // alert(response);
                if(response == 'false'){
                    $('#chkCurrentPwd').html('<font color="red">Current Password is incorrect</font>');
                }else if(response == 'true'){
                    $('#chkCurrentPwd').html('<font color="green">Current Password is correct</font>');
                }
            },
            error:function(){
                alert("Error");
            }

        });
    });


    $(".updateSectionStatus").click(function(){
        var status = $(this).text();
        var section_id = $(this).attr("section_id");

        $.ajax({
            type: "POST",
            url:"/admin/update-section-status",
            data:{status:status,section_id:section_id},
            success: function(response){
               if(response['status']==0){
                $("#section-"+section_id).html("<a class='updateSectionStatus' href='javascript:void(0)'>Inactive</a>");
               }else if(response['status']==1){
                $("#section-"+section_id).html("<a class='updateSectionStatus' href='javascript:void(0)'>Active</a>");
               }
            },error:function(){
                alert("Error");
            }
        });

    });


});