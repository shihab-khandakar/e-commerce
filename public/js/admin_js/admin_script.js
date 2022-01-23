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
});