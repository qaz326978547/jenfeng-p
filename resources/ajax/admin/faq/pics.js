// JavaScript Document
$(document).ready(function() {
    pics_get();
});

function pics_get() {
    $.ajax({
        url: $url + 'ajax/pics/' + $pid,
        cache: false,
        dataType: 'json',
        type: 'GET',
        data: {},
        error: function(xhr) {},
        success: function(response) {
            $('#picsList').html(response['html']);
        }
    });
}

function pics_upload() {
    var files = $("input[id=pics_file]")[0].files;
    var formData = new FormData();

    formData.append('pid', $pid);

    $.each(files, function(key, value) {
        formData.append("pics[" + key + "]", files[key]);
    });

    $.ajax({
        url: $url + 'ajax/pics/' + $pid,
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
            pics_get();
        },
        complete: function(xhr) {
        	if(xhr.status == 422) {
        		pics_get();
        	}
        }
    });
}

function pics_upd($id, $column, $value) {
    $.ajax({
        url: $url + 'ajax/pics/' + $pid + '/' + $id + '/' + $column,
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
                console.log(response['error']);
            } else {
                // alert_box(response['success']);
                pics_get();
            }
        },
        complete: function(xhr) {
        	if(xhr.status == 422) {
        		pics_get();
        	}
        }
    });
}

function pics_del($id) {
    $.ajax({
        url: $url + 'ajax/pics/' + $pid + '/' + $id,
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
                pics_get();
            }
        }
    });
}