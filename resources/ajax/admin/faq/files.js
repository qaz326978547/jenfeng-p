$(document).ready(function() {
    files_get();
});

function files_get() {
    $.ajax({
        url: $url + 'ajax/files/' + $pid,
        cache: false,
        dataType: 'json',
        type: 'GET',
        data: {},
        error: function(xhr) {},
        success: function(response) {
            $('#filesList').html(response['html']);
        }
    });
}

function files_upload() {
    var files = $("input[id=files_file]")[0].files;
    var formData = new FormData();

    formData.append('pid', $pid);

    $.each(files, function(key, value) {
        formData.append("files[" + key + "]", files[key]);
    });

    $.ajax({
        url: $url + 'ajax/files/' + $pid,
        data: formData,
        // dataType: "json",
        type: "POST",
        cache: false,
        contentType: false,
        processData: false,
        error: function(xhr) {},
        success: function(response) {
            if (response['error'] != '') {
                console.log(response['error']);
            }
            files_get();
        },
        complete: function(xhr) {
        	if(xhr.status == 422) {
        		files_get();
        	}
        }
    });
}

function files_upd($id, $column, $value) {
    $.ajax({
        url: $url + 'ajax/files/' + $pid + '/' + $id + '/' + $column,
        cache: false,
        dataType: 'json',
        type: 'PATCH',
        data: {
            id: $id,
            column: $column,
            value: $value,
        },
        error: function(xhr) {},
        success: function(response) {
            if (response['error'] != '') {
                // console.log(response['error']);
            } else {
                // alert_box(response['success']);
                files_get();
            }
        },
        complete: function(xhr) {
        	if(xhr.status == 422) {
        		files_get();
        	}
        }
    });
}

function files_del($id) {
    $.ajax({
        url: $url + 'ajax/files/' + $pid + '/' + $id,
        cache: false,
        dataType: 'json',
        type: 'DELETE',
        data: {
            id: $id
        },
        error: function(xhr) {},
        success: function(response) {
            if (response['error'] != '') {
                console.log(response['error']);
            } else {
                // alert_box(response['success']);
                files_get();
            }
        }
    });
}