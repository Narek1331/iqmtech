/*==============================================================*/
// Medip Contact Form  JS
/*==============================================================*/
(function ($) {
    "use strict"; // Start of use strict
    $("#contactForm").validator().on("submit", function (event) {
        if (event.isDefaultPrevented()) {
            formError();
            submitMSG(false, "Проверьте правильность заполнения формы");
        }
        else {
            event.preventDefault();
            let checkAgree = document.getElementById('checkAgree');
            if (checkAgree.checked) {
                submitForm();

            }else{
                formError();
                submitMSG(false, "Просим подтвердить своё согласие");

            }
        }
    });

    function submitForm(){
        // Initiate Variables With Form Content
        var name = $("#name").val();
        var email = $("#email").val();
        var msg_subject = $("#msg_subject").val();
        var phone_number = $("#phone_number").val();
        var message = $("#message").val();
        var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            type: "POST",
            url: "/contact",
            data: "name=" + name + "&email=" + email + "&msg_subject=" + msg_subject + "&phone_number=" + phone_number + "&message=" + message,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success : function(text){
                if (text == "success" || text.success){
                    formSuccess();
                }
                else {
                    formError();
                    submitMSG(false,text);
                }
            }
        });
    }
    function formSuccess(){
        $("#contactForm")[0].reset();
        submitMSG(true, "Сообщение отправлено!")
    }
    function formError(){
        $("#contactForm").removeClass().addClass('shake animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
            $(this).removeClass();
        });
    }
    function submitMSG(valid, msg){
        if(valid){
            var msgClasses = "h4 tada animated text-success";
        }
        else {
            var msgClasses = "h4 text-danger";
        }
        $("#msgSubmit").removeClass().addClass(msgClasses).text(msg);
    }


}(jQuery)); // End of use strict
