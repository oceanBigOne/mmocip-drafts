$(document).ready(function(){

    $body.on('change','input[name=userselect]',function(event){
        var $form=$(this).closest("form");
        if($form.data('submited')!==true) {
            $form.submit();
            $('input[name=userselect]').attr('disabled', true);
        }

    });
});
