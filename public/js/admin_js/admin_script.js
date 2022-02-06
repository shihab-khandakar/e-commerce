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


    //Update Section Status

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

        //Update Category Status

    $(".updateCategoryStatus").click(function(){
        var status = $(this).text();
        var category_id = $(this).attr("category_id");

        $.ajax({
            type: "POST",
            url:"/admin/update-category-status",
            data:{status:status,category_id:category_id},
            success: function(response){
               if(response['status']==0){
                $("#category-"+category_id).html("<a class='updateCategoryStatus' href='javascript:void(0)'>Inactive</a>");
               }else if(response['status']==1){
                $("#category-"+category_id).html("<a class='updateCategoryStatus' href='javascript:void(0)'>Active</a>");
               }
            },error:function(){
                alert("Error");
            }
        });

    });


    //Update Product Status

    $(".updateProductStatus").click(function(){
        var status = $(this).text();
        var product_id = $(this).attr("product_id");

        $.ajax({
            type: "POST",
            url:"/admin/update-product-status",
            data:{status:status,product_id:product_id},
            success: function(response){
               if(response['status']==0){
                $("#product-"+product_id).html("<a class='updateProductStatus' href='javascript:void(0)'>Inactive</a>");
               }else if(response['status']==1){
                $("#product-"+product_id).html("<a class='updateProductStatus' href='javascript:void(0)'>Active</a>");
               }
            },error:function(){
                alert("Error");
            }
        });

    });

    //Append Category Level

    $("#section_id").change(function(){
        var section_id = $(this).val();
        // alert(section_id);

        $.ajax({
            type: "POST",
            url:"/admin/append-category-level",
            data:{section_id:section_id},
            success: function(response){

                $("#appendCategoryLevel").html(response);

            },error:function(){
                alert("Error");
            }
        });

    });

    // Delete Confirmation
    // $(".confirmDelete").click(function(){
    //     var name = $(this).attr("name");
    //     if(confirm("Are you sure you want to delete this "+name+"???")){
    //         return true;
    //     }
    //     return false;
    // });

    // Delete Confirmation of sweet alert
    $(".confirmDelete").click(function(){
        var record = $(this).attr("record");
        var recordid = $(this).attr("recordid");

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
            if (result.isConfirmed) {
                window.location.href="/admin/delete-"+record+"/"+recordid;
            }
          });
          return false;
    });
    


});