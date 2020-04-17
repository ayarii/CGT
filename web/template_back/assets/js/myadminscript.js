$(function(){
    $("td:has(a)").click(function(){
        let id = $(this).attr("id").substr($(this).attr("id").indexOf("-") + 1) ;
        if($(this).attr("id").substr(0, $(this).attr("id").indexOf("-")) == "delete_comment") {
            $.ajax({
                url: "/comment/" + id + "/delete",
                method: "DELETE",
            });
            //send ajax removal request
            $("#publication-" + id).remove();
            $('.table').draw();
        }
        else if($(this).attr("id").substr(0, $(this).attr("id").indexOf("-")) == "delete_post") {
            $.ajax({
                url: "/" + id + "/delete",
                method: "DELETE",
                });
            //send ajax removal request
            $("#publication-" + id).remove();
            $('.table').draw();
        }
        else if($(this).attr("id").substr(0, $(this).attr("id").indexOf("-")) == "show_post") {
            let title = $("#title_post-" + id).html();
            let type = $("#type_post-" + id).html();
            let src = $("#srcfull_post-" + id).val();
            $(".modal-title").html(title);
            if( type == "img"){
                $(".modal-body").html('<img src="/uploads/img/'+src+'"></img>');
            }
            else if(type == "audio")
            {
                $(".modal-body").html('<center><audio controls><source src="/uploads/audio/'+src+'" type="audio/mpeg">Your browser does not support the audio element.</audio></center>');
            }
            else if( type == "video"){

                $(".modal-body").html('<center><video width="415" controls><source src="/uploads/video/'+src+'" type="video/mp4">Your browser does not support HTML5 video.</video></center>');
            }
            else if( type == "text"){
                $(".modal-body").html(src);
            }
        }
        else if($(this).attr("id").substr(0, $(this).attr("id").indexOf("-")) == "make_visible_post") {
            //send ajax visible request
            let td = $(this) ;
            $.ajax({
                url: "/" + id + "/make_visible",
                method: "GET",
                success: function(){
                    td.html('<a class="btn btn-default waves-effect waves-float waves-red"><i class="zmdi zmdi-eye"></i></a>') ;
                    td.attr('id', 'make_unvisible_post-' + id );

                }
            });
        }
        else if($(this).attr("id").substr(0, $(this).attr("id").indexOf("-")) == "make_unvisible_post") {
            //send ajax visible request
            let td = $(this).attr("id") ;
            $.ajax({
                url: "/" + id + "/make_unvisible",
                method: "GET",
                success: function(){
                    $("#" + td).html('<a class="btn btn-default waves-effect waves-float waves-green"><i class="zmdi zmdi-eye-off"></i></a>') ;
                    $("#" + td).attr('id', 'make_visible_post-' + id );
                }
            });
        }
    });
})