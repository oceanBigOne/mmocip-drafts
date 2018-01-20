$(document).ready(function(){


    $body=$('body');

    $body.on('click','[data-jsbind=confirm-delete]',function(event){
        if($(this).data("clicked")!==true){
            $(this).data("clicked",true);
            messageModal("system/delete",$(this).data("jsbind-param"),$(this));
        }

    });

    $body.on('click','[data-jsbind=delete]',function(event){
        if($(this).data("clicked")!==true) {
            $(this).data("clicked", true);
            var deleteInput=$("[name=delete]");
            deleteInput.val(true);
            deleteInput.closest("form").submit();

        }
    });




});