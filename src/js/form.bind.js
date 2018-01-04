$(document).ready(function() {


    $(document).ready(function(){

        $('[data-action=ajax]').submit(function(event){
            var $fom=$(this);
            event.preventDefault();

            $.ajax({type:"POST", data: $(this).serialize(), url:$fom.attr("action"),
                success: function(response){

                    if(response.status=="success"){
                        toastr["success"](response.data.message);
                    }else{
                        toastr["error"](response.data.message)
                    }
                },
                error: function(){

                }
            });
            return false;
        });
    });

});

