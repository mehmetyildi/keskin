$(document).ready(function(){
    $("#todo, #completed").sortable({
        connectWith: ".connectList",
        update: function( event, ui ) {
            var todo = $( "#todo" ).sortable( "toArray" );
            var completed = $( "#completed" ).sortable( "toArray" );
            $.ajax({
                data: { ids : window.JSON.stringify(todo), _token: window.Laravel.csrfToken},
                type: 'POST',
                url: globalBaseUrl + '/piyetracms/tasks/order',
                success: function(response) {
                    //
                },
            });
            $.ajax({
                data: { ids : window.JSON.stringify(completed), _token: window.Laravel.csrfToken},
                type: 'POST',
                url: globalBaseUrl + '/piyetracms/tasks/orderCompleted',
                success: function(response) {
                    //
                },
            });
        },
        stop: function( event, ui ) {
            toastr.success('İş listeleri güncellendi.');
        }
        

    }).disableSelection();

    $(document).delegate('#addTaskForm', 'submit', function(e){
        e.preventDefault();
        var $form = $('#addTaskForm');
        var serializedData = $form.serialize();
        request = $.ajax({
            data: serializedData,
            type: 'POST',
            url: globalBaseUrl + '/piyetracms/tasks',
            success: function (response) {
                $("#currentTaskList").load(location.href + " #currentTaskList");
                toastr.success(response);
                $('#addTaskForm')[0].reset();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                toastr.error(fullErrors);
            },
        });
    });

    $(document).delegate('.updateTaskForm', 'submit', function(e){
        e.preventDefault();
        var $form = $(this);
        var serializedData = $form.serialize();
        request = $.ajax({
            data: serializedData,
            type: 'POST',
            url: globalBaseUrl + '/piyetracms/tasks/update',
            success: function (response) {
                $("#currentTaskList").load(location.href + " #currentTaskList");
                toastr.success(response);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                toastr.error(fullErrors);
            },
        });
    });

     $(document).ajaxSuccess(function() {
        $("#todo, #completed").sortable({
            connectWith: ".connectList",
            update: function( event, ui ) {
                var todo = $( "#todo" ).sortable( "toArray" );
                var completed = $( "#completed" ).sortable( "toArray" );
                $.ajax({
                    data: { ids : window.JSON.stringify(todo), _token: window.Laravel.csrfToken},
                    type: 'POST',
                    url: globalBaseUrl + '/piyetracms/tasks/order',
                    success: function(response) {
                        //
                    },
                });
                $.ajax({
                    data: { ids : window.JSON.stringify(completed), _token: window.Laravel.csrfToken},
                    type: 'POST',
                    url: globalBaseUrl + '/piyetracms/tasks/orderCompleted',
                    success: function(response) {
                        //
                    },
                });
            },
            stop: function( event, ui ) {
                toastr.success('İş listeleri güncellendi.');
            }
        }).disableSelection();
    });

     $(document).delegate('.editTaskBtn', 'click', function(){
        var $this = $(this);
        var parent = $this.parent('.agile-detail');
        var input = parent.siblings('.editTaskInput');
        var description = parent.siblings('.currentTaskDescription');
        var updateBtn = $this.siblings('.updateTaskBtn');
        var cancelBtn = $this.siblings('.cancelTaskEditBtn');
        description.hide();
        $this.hide();
        input.fadeIn();
        updateBtn.fadeIn();
        cancelBtn.fadeIn();
        input.focus();
     });

     $(document).delegate('.cancelTaskEditBtn', 'click', function(){
        var $this = $(this);
        var parent = $this.parent('.agile-detail');
        var input = parent.siblings('.editTaskInput');
        var description = parent.siblings('.currentTaskDescription');
        var updateBtn = $this.siblings('.updateTaskBtn');
        var editBtn = $this.siblings('.editTaskBtn');
        description.fadeIn();
        $this.hide();
        input.hide();
        updateBtn.hide();
        editBtn.fadeIn();
     });
});