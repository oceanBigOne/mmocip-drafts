function cb__UpdateUserPseudo(string){
    $('#current_pseudo').html(string);
    $('input[name=userselect]').attr('disabled',false);
}