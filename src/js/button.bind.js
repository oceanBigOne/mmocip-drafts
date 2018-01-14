$(document).ready(function(){


    $body=$('body');

    $body.on('click','[data-action=confirm-delete]',function(event){
        if($(this).data("clicked")!==true){
            $(this).data("clicked",true);
            messageModal("system/delete",$(this).data("message-param"),$(this));
        }

    });

    $body.on('click','[data-action=delete]',function(event){
        if($(this).data("clicked")!==true) {
            $(this).data("clicked", true);
            alert("SUPPRESSION DE : " + $(this).data("model") + " ID=" + $(this).data("id"));
        }
    });


});