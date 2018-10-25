$(".selectImageToCrop").change(function() {
    var $this = $(this);
    var container = $this.data('container');
    console.log($(container+' > .jcrop-holder'));
    $(container+' > .jcrop-holder').remove();
    var field = $this.data('field');
    var ratio = $this.data('ratio');
    generateJcrop(this, field, ratio);
});

function generateJcrop(input, field, ratio) {
    if(input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#'+field+'_preview').attr('src', e.target.result);
            var cropOptions = {
                fileInput : '#'+field+'_preview',
                targetInput: '#'+field,
                aspectRatio:ratio,
                cropX: '#'+field+'_crop_x',
                cropY: '#'+field+'_crop_y',
                cropW: '#'+field+'_crop_w',
                cropH: '#'+field+'_crop_h'
            }

            $(cropOptions.fileInput).attr('src', e.target.result);
            $(cropOptions.targetInput).val(e.target.result);
            $.Jcrop(cropOptions.fileInput).destroy();
            $(cropOptions.fileInput).Jcrop({
                boxWidth: 600,
                boxHeight: 400,
                onSelect: updateCoords,
                onChange: updateCoords,
                setSelect:[400,400,200,200],
                bgOpacity: 0.4,
                aspectRatio: cropOptions.aspectRatio
            });

            function updateCoords(c){
                $(cropOptions.cropX).val(c.x);
                $(cropOptions.cropY).val(c.y);
                $(cropOptions.cropW).val(c.w);
                $(cropOptions.cropH).val(c.h);
            };
        }
        reader.readAsDataURL(input.files[0]);

    }
}

function initializeDatatable($selector){
    $($selector).DataTable({
        pageLength: 25,
        responsive: true,
        dom: '<"html5buttons"B>lTfgitp',
        buttons: [
            { extend: 'copy'},
            {extend: 'csv'},
            {extend: 'excel', title: 'Roles'},
            {extend: 'pdf', title: 'Roles'},

            {extend: 'print',
                customize: function (win){
                    $(win.document.body).addClass('white-bg');
                    $(win.document.body).css('font-size', '10px');

                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
                }
            }
        ]

    });

}