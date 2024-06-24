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
        formData.append("files[" + value['name'] + "]", files[key]);
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

            setTimeout(function() {
                $("#files_percent").text('0%'); // 進度條百分比文字
                $("#files_bar").width('0%');    // 進度條顏色
            }, 3000);
        },
        complete: function(xhr) {
            if(xhr.status == 422) {
                files_get();
            }
        },
        xhr: function() {
            var xhr = new window.XMLHttpRequest(); // 建立xhr(XMLHttpRequest)物件
            xhr.upload.addEventListener("progress", function(progressEvent){ // 監聽ProgressEvent
                if (progressEvent.lengthComputable) {
                    var percentComplete = progressEvent.loaded / progressEvent.total;
                    var percentVal = Math.round(percentComplete*100) + "%";
                    $("#files_percent").text(percentVal); // 進度條百分比文字
                    $("#files_bar").width(percentVal);    // 進度條顏色
                }
            }, false);

            return xhr; // 注意必須將xhr(XMLHttpRequest)物件回傳
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