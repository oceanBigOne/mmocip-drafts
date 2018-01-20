$(document).ready(function(){


    $body=$('body');

    $body.on('click','[data-action=confirm-delete]',function(event){
        if($(this).data("clicked")!==true){
            $(this).data("clicked",true);
            messageModal("system/delete",$(this).data("action-param"),$(this));
        }

    });

    $body.on('click','[data-action=delete]',function(event){
        if($(this).data("clicked")!==true) {
            $(this).data("clicked", true);
            var deleteInput=$("[name=delete]");
            deleteInput.val(true);
            deleteInput.closest("form").submit();

        }
    });




});