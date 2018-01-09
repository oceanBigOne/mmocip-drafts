
$(document).ready(function(){

    $('[data-action=ajax]').submit(function(event){
        var $form=$(this);
        event.preventDefault();


        if($form.data('submited')!==true) {

            $form.data('submited', true);

            Pace.restart();
            $.ajax({
                type: "POST", data: $(this).serialize(), url: $form.attr("action"),
                success: function (response) {


                    //message
                    if (typeof response.data.message !== 'undefined' && response.data.message !== null) {
                        var type="success";
                        if (typeof response.data.messageType !== 'undefined' && response.data.messageType !== null) {
                            type=response.data.messageType;
                        }else{
                            if (response.status === "success") {
                                type="success";
                            } else {
                                type="error";
                            }
                        }

                        if (type!=="prompt") {
                            toastr[type](response.data.message);
                        } else {
                           //TODO MODAL !
                        }

                    }

                    //callback
                    if (typeof response.data.callback !== 'undefined' && response.data.callback !== null) {
                        if (response.data.callback.data) {
                            setTimeout(function () {
                                window[response.data.callback.function].apply(this, response.data.callback.data)
                            }, response.data.callback.timeout);
                        } else {
                            setTimeout(function () {
                                window[response.data.callback.function]()
                            }, response.data.callback.timeout);
                        }
                    }

                    //redirect
                    if (typeof response.data.redirect !== 'undefined' && response.data.redirect !== null) {

                        setTimeout(function () {
                            postData(response.data.redirect.url, response.data.redirect.data);
                        }, response.data.redirect.timeout);

                    }

                    //deverouille le formulaire
                    setTimeout(function(){ $form.data('submited', false);},1000);

                },
                error: function () {
                    toastr["error"]("Unknow error !");
                    setTimeout(function(){ $form.data('submited', false);},1000);
                }
            });
            return false;
        }

    });

});



function postData(url, data) {

    var form;
    form = $('<form />', {
        action: url,
        method: 'post',
        style: 'display: none;'
    });
    if (typeof data !== 'undefined' && data !== null) {
        $.each(data, function (name, value) {
            $('<input />', {
                type: 'hidden',
                name: name,
                value: value
            }).appendTo(form);
        });
    }
   form.appendTo('body').submit();
}

function callbackTest(param1,param2){
    console.log('Callback test called ! '+param1+'--'+param2);
}
