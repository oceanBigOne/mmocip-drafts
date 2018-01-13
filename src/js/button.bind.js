$(document).ready(function(){


    $body=$('body');

    $body.on('click','[data-action=confirm-delete]',function(event){
        messageModal("system/delete",$(this).data("message-param"));
    });

    $body.on('click','[data-action=delete]',function(event){
        alert("SUPPRESSION DE : "+$(this).data("model")+" ID="+$(this).data("id"));
    });


});