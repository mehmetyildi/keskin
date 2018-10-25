$(document).ready(function(){
    $('.disableOnSubmit').submit(function () {
        $(this).find("button[type='submit'], input[type='submit']").prop('disabled', true);
        $(this).find("button[type='submit'], input[type='submit']").after('<img src="' + globalBaseUrl + '/img/sending.gif" style="margin-left:8px; margin-top:15px; float: right;" />');
    });

    jQuery(function () {
        jQuery('#subForm').submit(function (e) {
            e.preventDefault();
            jQuery(this).find("button[type='submit'], input[type='submit']").prop('disabled', true);
            jQuery(this).find("button[type='submit'], input[type='submit']").html('<img src="'+globalBaseUrl+'/img/sending.gif" width="20" />');
            jQuery('#gif').show();
            jQuery.getJSON(
                this.action + "?callback=?",
                jQuery(this).serialize(),
                function (data) {
                    if (data.Status === 400) {
                        alert("Error: " + data.Message);
                    } else { // 200
                        jQuery('#bulletinRegular').hide();
                        jQuery('#subForm').hide();
                        jQuery('#success').show();
                    }
                });
        });
    });
});