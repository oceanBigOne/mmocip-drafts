$(document).ready(function() {


    $(document).ready(function(){

        $('[data-action=ajax]').submit(function(event){
            var $fom=$(this);
            event.preventDefault();
            $.ajax({type:"POST", data: $(this).serialize(), url:$fom.attr("action"),
                success: function(data){

                },
                error: function(){

                }
            });
            return false;
        });
    });

});

