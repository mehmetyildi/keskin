window.appLang = document.querySelector('meta[name="language"]').getAttribute('content');

window.appGenerics = {
    required: {
        en: "This field is required.",
        tr: "Bu alan boş bırakılamaz."
    },
    remote: {
        en: "Please fix this field.",
        tr: "Lütfen bu alanı düzeltin."
    },
    email: {
        en: "Please enter a valid email address.",
        tr: "Lütfen geçerli bir e-posta adresi girin."
    },
    url: {
        en: "Please enter a valid URL.",
        tr: "Lütfen geçerli bir URL adresi girin."
    },
    date: {
        en: "Please enter a valid date.",
        tr: "Lütfen geçerli bir tarih girin."
    },
    dateISO: {
        en: "Please enter a valid date (ISO).",
        tr: "Lütfen geçerli bir tarih (ISO) girin."
    },
    number: {
        en: "Please enter a valid number.",
        tr: "Lütfen geçerli bir numara girin."
    },
    digits: {
        en: "Please enter only digits.",
        tr: "Lütfen sadece sayıları kullanın."
    },
    creditcard: {
        en: "Please enter a valid credit card number.",
        tr: "Lütfen geçerli bir kredi kartı numarası girin."
    },
    equalTo: {
        en: "Please enter the same value again.",
        tr: "Lütfen aynı değeri bir daha girin."
    },
    accept: {
        en: "Please enter a value with a valid extension.",
        tr: "Lütfen geçerli uzantıya sahip bir değer girin."
    },
    maxlength: {
        en: "Please enter no more than {0} characters.",
        tr: "Lütfen en fazla {0} karakter girin."
    },
    minlength: {
        en: "Please enter at least {0} characters.",
        tr: "Lütfen en az {0} karakter girin."
    },
    rangelength: {
        en: "Please enter a value between {0} and {1} characters long.",
        tr: "Lütfen {0} ile {1} arası uzunlukta bir değer girin."
    },
    range: {
        en: "Please enter a value between {0} and {1}.",
        tr: "Lütfen {0} ile {1} arasında bir değer girin."
    },
    max: {
        en: "Please enter a value less than or equal to {0}.",
        tr: "Lütfen {0} değerine eşit ya da daha düşük bir değer girin."
    },
    min: {
        en: "Please enter a value greater than or equal to {0}.",
        tr: "Lütfen {0} değerine eşit ya da daha yüksek bir değer girin."
    },
    nonValid: {
        en: "Not a valid address",
        tr: "Geçerli bir adres değil."
    },
    didYou: {
        en: "Did you mean",
        tr: "Şunu mu demek istediniz"
    }

};

jQuery.extend(jQuery.validator.messages, {
    required: appGenerics.required[appLang],
    remote: appGenerics.remote[appLang],
    email: appGenerics.email[appLang],
    url: appGenerics.url[appLang],
    date: appGenerics.date[appLang],
    dateISO: appGenerics.dateISO[appLang],
    number: appGenerics.number[appLang],
    digits: appGenerics.digits[appLang],
    creditcard: appGenerics.creditcard[appLang],
    equalTo: appGenerics.equalTo[appLang],
    accept: appGenerics.accept[appLang],
    maxlength: jQuery.validator.format(appGenerics.maxlength[appLang]),
    minlength: jQuery.validator.format(appGenerics.minlength[appLang]),
    rangelength: jQuery.validator.format(appGenerics.rangelength[appLang]),
    range: jQuery.validator.format(appGenerics.range[appLang]),
    max: jQuery.validator.format(appGenerics.max[appLang]),
    min: jQuery.validator.format(appGenerics.min[appLang])
});

$('.validateThisForm').click(function(){
    var form = $(this).parents("form");
    var button = $(this);
    button.prop('disabled', true);
    var currentHTML = button.html();
    button.html('<img src="'+globalBaseUrl+'/img/sending.gif" width="20"/>');
    if(form.valid()) {
        var emailInput = form.find("input[type='email']");
        var email = emailInput.val();
        request = $.ajax({
            data: email,
            type: 'GET',
            url: globalBaseUrl + '/validate-mailgun/'+email
        });
        request.done(function (response){
            if(response.is_valid === true){
                form.submit();
            }else{
                button.html(currentHTML);
                button.prop('disabled', false);
                if(response.did_you_mean === null){
                    emailInput.after('<small><em id="mailgunResponse">'+appGenerics.nonValid[appLang]+'</em></small>');
                }else{
                    emailInput.after('<small><em id="mailgunResponse">'+ appGenerics.didYou[appLang] +' '+ response.did_you_mean +'?</em></small>');
                }
            }
        });
    }else{
        button.html(currentHTML);
        button.prop('disabled', false);
        return false;
    }

});