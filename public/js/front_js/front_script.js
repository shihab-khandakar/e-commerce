$(document).ready(function() {
    
    // sorting file latest product a-z product low price high price with ajax
    $("#sort").on("change",function() {
       var sort = $(this).val();
       var fabric = get_filter('fabric');
       var sleeve = get_filter('sleeve');
       var pattern = get_filter('pattern');
       var fit = get_filter('fit');
       var occasion = get_filter('occasion');
       var url = $("#url").val();
       
       $.ajax({
            url: url,
            method: "POST",
            data:{fabric: fabric,sleeve:sleeve,pattern: pattern,fit:fit,occasion:occasion,sort: sort,url: url},
            success: function(data) {
                $(".filter_products").html(data);
            },
            error: function(){
                alert("Error");
            }
       });

    });

    //fabric filters are selected
    $(".fabric").on('click',function(){
        var fabric = get_filter('fabric');
        var sleeve = get_filter('sleeve');
        var pattern = get_filter('pattern');
        var fit = get_filter('fit');
        var occasion = get_filter('occasion');
        var sort = $('#sort option:selected').val();
        var url = $("#url").val();

        $.ajax({
            url: url,
            method: "POST",
            data:{fabric: fabric,sleeve:sleeve,pattern: pattern,fit:fit,occasion:occasion,sort: sort,url: url},
            success: function(data) {
                $(".filter_products").html(data);
            },
            error: function(){
                alert("Error");
            }
       });

    });

    //sleeve filters are selected
    $(".sleeve").on('click',function(){
        var fabric = get_filter('fabric');
        var sleeve = get_filter('sleeve');
        var pattern = get_filter('pattern');
        var fit = get_filter('fit');
        var occasion = get_filter('occasion');
        var sort = $('#sort option:selected').val();
        var url = $("#url").val();

        $.ajax({
            url: url,
            method: "POST",
            data:{fabric: fabric,sleeve:sleeve,pattern: pattern,fit:fit,occasion:occasion,sort: sort,url: url},
            success: function(data) {
                $(".filter_products").html(data);
            },
            error: function(){
                alert("Error");
            }
       });

    });

    //pattern filters are selected
    $(".pattern").on('click',function(){
        var fabric = get_filter('fabric');
        var sleeve = get_filter('sleeve');
        var pattern = get_filter('pattern');
        var fit = get_filter('fit');
        var occasion = get_filter('occasion');
        var sort = $('#sort option:selected').val();
        var url = $("#url").val();

        $.ajax({
            url: url,
            method: "POST",
            data:{fabric: fabric,sleeve:sleeve,pattern: pattern,fit:fit,occasion:occasion,sort: sort,url: url},
            success: function(data) {
                $(".filter_products").html(data);
            },
            error: function(){
                alert("Error");
            }
       });

    });

    //fit filters are selected
    $(".fit").on('click',function(){
        var fabric = get_filter('fabric');
        var sleeve = get_filter('sleeve');
        var pattern = get_filter('pattern');
        var fit = get_filter('fit');
        var occasion = get_filter('occasion');
        var sort = $('#sort option:selected').val();
        var url = $("#url").val();

        $.ajax({
            url: url,
            method: "POST",
            data:{fabric: fabric,sleeve:sleeve,pattern: pattern,fit:fit,occasion:occasion,sort: sort,url: url},
            success: function(data) {
                $(".filter_products").html(data);
            },
            error: function(){
                alert("Error");
            }
       });

    });

    //occasion filters are selected
    $(".occasion").on('click',function(){
        var fabric = get_filter('fabric');
        var sleeve = get_filter('sleeve');
        var pattern = get_filter('pattern');
        var fit = get_filter('fit');
        var occasion = get_filter('occasion');
        var sort = $('#sort option:selected').val();
        var url = $("#url").val();

        $.ajax({
            url: url,
            method: "POST",
            data:{fabric: fabric,sleeve:sleeve,pattern: pattern,fit:fit,occasion:occasion,sort: sort,url: url},
            success: function(data) {
                $(".filter_products").html(data);
            },
            error: function(){
                alert("Error");
            }
       });

    });


    //get filter array function
    function get_filter(class_name){
        var filter = [];
        $('.'+class_name+':checked').each(function(){
            filter.push($(this).val());
        });
        return filter;
    }


});