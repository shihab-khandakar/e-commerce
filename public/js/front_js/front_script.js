$(document).ready(function() {
    
    // sorting file latest product a-z product low price high price with ajax
    $("#sort").on("change",function() {
       var sort = $(this).val();
       var url = $("#url").val();
       
       $.ajax({
            url: url,
            method: "POST",
            data:{sort: sort,url: url},
            success: function(data) {
                $(".filter_products").html(data);
            },
            error: function(){
                alert("Error");
            }
       });

    });

});