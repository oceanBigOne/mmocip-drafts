function updateUserPseudo(string){
    $('#current_pseudo').html(string);
    $('input[name=userselect]').attr('disabled',false);
}