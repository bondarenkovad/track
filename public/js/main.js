$(document).ready(function ($) {

    setTimeout(function () {
        $('#flash').fadeOut('fast');
    }, 2000);

    $('#project').select2({
        multiply: true,
        minimumInputLength: 2
    });

    $(function () {
        $("#sortable1,#sortable2").sortable({
            connectWith: ".connectedSortable"
        }).disableSelection();
    });

    $editSprint = function (obj, content) {

        $('#sprintName').val(obj.name);
        tinymce.activeEditor.execCommand('mceInsertContent', false, obj.description);


        if ($('#sprintStatus').val() == obj.status)
            $('#sprintStatus').prop('checked');

        $('#sprintProject').val(obj.project);
        $('#sprintDate_start').val(obj.date_start);
        $('#sprintDate_finish').val(obj.date_finish);
        $('#sprintId').val(content);
    };

    $('#sprintEdit').on('show.bs.modal', function (event) {
        // получить кнопку, которая его открыло
        var button = $(event.relatedTarget);
        // извлечь информацию из атрибута data-content
        var content = button.data('content');
        var path = '/sprint/modalEdit/' + content + '';
        var obj = {};

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            }
        });

        $.ajax({
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');
                if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            url: path,
            dataType: 'json',
            type: 'GET',
            complete: function (data) { // data - ответ полученный с сервера
                obj = JSON.parse(data.responseText); // записываем полученные данные data в ранее подготовленную переменную

                $editSprint(obj, content);
            }
        });

        $('#sprintName').val('');
        tinymce.activeEditor.setContent('');
        $('#sprintProject').val('');
        $('#sprintDate_start').val('');
        $('#sprintDate_finish').val('');
        $('#sprintId').val('');
    });

    $action = function () {

        $projectKey = $("#projectKey").val();
        $sprintId = $("#sprintId").val();
        $boardId = $("#boardId").val();
        $data = {};
        var path = '/project/' + $projectKey + '/board/' + $boardId + '/backlog';

        $('.sprintContainer').each(function () {
            $key = $(this).attr('data-value');
            $id = $(this).attr('id');
            $data[$key] = [];
            $('#' + $id + ' li').each(function () {
                $data[$key].push($(this).attr('data-value'));
                $('#issueData-' + $key).val($data[$key]);
            });

        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            }
        });

        $.ajax({
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');
                if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            url: path,
            type: 'PUT',
            data: {Data: $data}
        });
    };

    $sprint = function ($issue_id) {

        $('#issueLog').modal();

        $dataMass = {};
        $data = {};

        $('#subBtn').on('click', function () {
            $dataMass = {
                'issueId': $issue_id,
                'time_spent': $("#time_spent").val(),
                'status_id': $("#status_id").val(),
                'comment': $("#comment").val()
            };

            $("#time_spent").val('');
            $("#status_id").val('');
            $("#comment").val('');

            $projectKey = $("#projectKey").val();
            $sprintId = $("#sprintId").val();
            $boardId = $("#boardId").val();

            var path = '/project/' + $projectKey + '/board/' + $boardId + '/sprint/' + $sprintId;

            $('.issueContainer').each(function () {
                $id = $(this).attr('id');
                $statusId = $(this).attr('data-value');
                $data[$statusId] = [];
                $('#' + $id + ' li').each(function () {
                    $data[$statusId].push($(this).attr('data-value'));
                });
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                }
            });

            $.ajax({
                beforeSend: function (xhr) {
                    var token = $('meta[name="csrf_token"]').attr('content');
                    if (token) {
                        return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                    }
                },
                url: path,
                type: 'PUT',
                data: {
                    Data: $data,
                    log: $dataMass
                }
            });
        });

        $('#closeBtn').on('click', function () {
            $projectKey = $("#projectKey").val();
            $sprintId = $("#sprintId").val();
            $boardId = $("#boardId").val();


            var path = '/project/' + $projectKey + '/board/' + $boardId + '/sprint/' + $sprintId;

            $('.issueContainer').each(function () {
                $id = $(this).attr('id');
                $statusId = $(this).attr('data-value');
                $data[$statusId] = [];
                $('#' + $id + ' li').each(function () {
                    $data[$statusId].push($(this).attr('data-value'));
                });
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                }
            });

            $.ajax({
                beforeSend: function (xhr) {
                    var token = $('meta[name="csrf_token"]').attr('content');
                    if (token) {
                        return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                    }
                },
                url: path,
                type: 'PUT',
                data: {
                    Data: $data
                }
            });
        });


    };

    $(function () {
        $(".issueContainer").sortable({
            connectWith: ".connectedIssueSortable",

            receive: function (event, ui) {
                $sprint(ui.item.attr('id'));
            }
        }).disableSelection()
    });

    $(function () {
        $(".sprintContainer").sortable({
            connectWith: ".connectedSortable",
            connectToSortable: '.sprintContainer',

            update: function (event, ui) {
                $action();
            },
            receive: function () {
                $action();

            },
            remove: function () {
                $action();
            }
        }).disableSelection()
    });

    $('#submitBtn').on('click', function () {
        $mass = [];

        $('#sortable1 li').each(function () {
            $mass.push($(this).attr('data-value'));
        });

        $("#statusesId").val($mass);
    });

    tinyMCE.init({
        selector: '.mytextarea',
        resize: false,
        menubar: false,
        plugins: [
            'advlist autolink lists link image charmap print preview anchor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table contextmenu paste code'
        ],
        toolbar: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | ' +
        'bullist numlist outdent indent | link image'
    });
});

