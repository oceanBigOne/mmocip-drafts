$(document).ready(function(){

    //TODO multilangue avec un objet message contentant les traductions
    $body=$('body');

    $body.on('click','[data-action=delete]',function(event){
        var $me=$(this);
        console.log(  $me);
        bootbox.confirm({
            message: "Êtes-vous sur de vouloir supprimer cet élément ?",
            buttons: {
                confirm: {
                    label: 'Oui',
                    className: 'btn-success'
                },
                cancel: {
                    label: 'Non',
                    className: 'btn-danger'
                }
            },
            callback: function (result) {
              if(result===true){
                    $me.closest('form').find('[name=delete]').val(true);
                    $me.closest('form').submit();
              }

            }
        });
    });


});