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


function messageModal(reference){

}