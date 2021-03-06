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

    $(document).on("click",".updateSectionStatus",function(){
        var status = $(this).children("i").attr("status");
        var section_id = $(this).attr("section_id");

        $.ajax({
            type: "POST",
            url:"/admin/update-section-status",
            data:{status:status,section_id:section_id},
            success: function(response){
               if(response['status']==0){
                $("#section-"+section_id).html("<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>");
               }else if(response['status']==1){
                $("#section-"+section_id).html("<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>");
               }
            },error:function(){
                alert("Error");
            }
        });

    });

       //Update Banners Status

       $(document).on("click",".updateBannerStatus",function(){
        var status = $(this).children("i").attr("status");
        var banner_id = $(this).attr("banner_id");
      
        $.ajax({
            type: "POST",
            url:"/admin/update-banner-status",
            data:{status:status,banner_id:banner_id},
            success: function(response){
               if(response['status']==0){
                $("#banner-"+banner_id).html("<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>");
               }else if(response['status']==1){
                $("#banner-"+banner_id).html("<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>");
               }
            },error:function(){
                alert("Error");
            }
        });

    });

    //Update Brand Status

    
    $(document).on("click",".updateBrandStatus",function(){
        var status = $(this).children("i").attr("status");
        var brand_id = $(this).attr("brand_id");

        $.ajax({
            type: "POST",
            url:"/admin/update-brand-status",
            data:{status:status,brand_id:brand_id},
            success: function(response){
               if(response['status']==0){
                $("#brand-"+brand_id).html("<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>");
               }else if(response['status']==1){
                $("#brand-"+brand_id).html("<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>");
               }
            },error:function(){
                alert("Error");
            }
        });

    });

        //Update Category Status

    $(document).on("click",".updateCategoryStatus",function(){
        var status = $(this).children("i").attr("status");
        var category_id = $(this).attr("category_id");

        $.ajax({
            type: "POST",
            url:"/admin/update-category-status",
            data:{status:status,category_id:category_id},
            success: function(response){
               if(response['status']==0){
                $("#category-"+category_id).html("<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>");
               }else if(response['status']==1){
                $("#category-"+category_id).html("<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>");
               }
            },error:function(){
                alert("Error");
            }
        });

    });


    //Update Product Status

    $(document).on("click",".updateProductStatus",function(){
        var status = $(this).children("i").attr("status");
        var product_id = $(this).attr("product_id");

        $.ajax({
            type: "POST",
            url:"/admin/update-product-status",
            data:{status:status,product_id:product_id},
            success: function(response){
               if(response['status']==0){
                $("#product-"+product_id).html("<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>");
               }else if(response['status']==1){
                $("#product-"+product_id).html("<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>");
               }
            },error:function(){
                alert("Error");
            }
        });

    });


    //Update Attribute Status

    $(document).on("click",".updateAttributeStatus",function(){
        var status = $(this).children("i").attr("status");
        var attribute_id = $(this).attr("attribute_id");

        $.ajax({
            type: "POST",
            url:"/admin/update-attribute-status",
            data:{status:status,attribute_id:attribute_id},
            success: function(response){
               if(response['status']==0){
                $("#attribute-"+attribute_id).html("<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>");
               }else if(response['status']==1){
                $("#attribute-"+attribute_id).html("<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>");
               }
            },error:function(){
                alert("Error");
            }
        });

    });


    //Update Image Status

    
    $(document).on("click",".updateImageStatus",function(){
        var status = $(this).children("i").attr("status");
        var image_id = $(this).attr("image_id");

        $.ajax({
            type: "POST",
            url:"/admin/update-image-status",
            data:{status:status,image_id:image_id},
            success: function(response){
               if(response['status']==0){
                $("#image-"+image_id).html("<i class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>");
               }else if(response['status']==1){
                $("#image-"+image_id).html("<i class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>");
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
    
    $(document).on("click",".confirmDelete",function(){
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


    //Product Attributes Add/Remove Script

    var maxField = 10; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
    var fieldHTML = '<div><div style="height:10px;"></div><input type="text" name="size[]" style="width:110px" placeholder="Size"/>&nbsp;<input type="text" name="sku[]" style="width:110px" placeholder="Sku"/>&nbsp;<input type="text" name="price[]" style="width:110px" placeholder="Price"/>&nbsp;<input type="text" name="stock[]" style="width:110px" placeholder="Stock"/><a href="javascript:void(0);" class="remove_button">&nbsp;Delete</a></div>'; //New input field html 
    var x = 1; //Initial field counter is 1
    
    //Once add button is clicked
    $(addButton).click(function(){
        //Check maximum number of input fields
        if(x < maxField){ 
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); //Add field html
        }
    });
    
    //Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function(e){
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });
    


});