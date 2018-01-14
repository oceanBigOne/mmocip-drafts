$(document).ready(function(){

    //message au chargement de la page
    var $messageLoader=$(".message-loader");
    if($messageLoader.length==1){
        var type=$messageLoader.data("type");
        if(!type){
            type="error";
        }
        messageTop(type,$messageLoader.html());
    }


});


function messageTop(type,message){
    toastr[type](message);
}


function messageModal(reference,data,$obj){
   // Pace.restart();
    var language = $(location).attr('pathname');
    language.indexOf(1);
    language.toLowerCase();
    language = language.split("/")[1];
    var idModal=reference.replace("/","-")+"_"+md5(JSON.stringify(data));
    var $modal=$('#'+idModal);
    if($modal.length===0) {
        var param=jQuery.param(data);
        $.ajax({
            type: "POST", data: "modal_id="+idModal+"&modal_ref="+reference+'&'+param, url: "/"+language+"/message/"})
            .done(function(response){
                $('body').append(response);
                $modal=$('#'+idModal);
                if($modal.length<1){
                    messageTop("error","Modal undefined !");
                }else{
                    $obj.data("clicked",false);
                    $modal.modal('show');
                }
            }).fail(function(){
                $obj.data("clicked",false);
                messageTop("error","System error !");
            });
    }else{
        $obj.data("clicked",false);
        $modal.modal('show');
    }

}