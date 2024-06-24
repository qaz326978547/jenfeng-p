// CSRF
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
    }
});

// Global error
$(document).ajaxError(function(event, xhr, settings, thrownError) {
	switch (xhr.status) {
        case 403:
            res = $.parseJSON(xhr.responseText);

            if (res['error'] == '') {
                location.href = res['location'];
            } else {
                alert_box(res['error']);
                $('#alert_area .close').click(function(event) { location.href = res['location']; });
            }

            break;
		case 405:
			alert_box('連線逾時，請重新操作(Please re-operate when the connection expires)');
			$('#alert_area .close').click(function(event) { history.go(0); });

			break;
		case 422:
        	var message = '';

        	$.each($.parseJSON(xhr.responseText), function(key, value) {
        		message += value + '<br>';
        	})

        	alert_box(message);

            if (typeof grecaptcha === "object") {
                grecaptcha.reset();
            }

            return false;
			break;
		default:
			alert_box('發生錯誤,Status code：' + xhr.status);
			$('#alert_area .close').click(function(event) { history.go(0); });
	}
});

/**
 * 警告視窗
 */
function alert_box($string, $close_time) {
	if(typeof $string == 'string') {
		if($string != '') {
        	$('#alert_area').find('i.content').html($string);
        	$('#alert_area').addClass('active');

        	if ($close_time != undefined) {
	        	setTimeout(function() {
	        		$('#alert_area').removeClass('active');
	        	}, $close_time);
        	}
		}
	}
}

/**
 * 驗證器
 *
 * @param  string $form
 * @param  string $rule
 * @param  string $rule_message
 * @param  string $validate_path
 * @param  boolen $submit
 */
function validate($form, $rule, $rule_message, $validate_path, $submit) {
    var formData = new FormData($($form)[0]);
    var check = false;

    if ($submit == undefined) {
        $submit = true;
    }

    formData.append('rule', $rule);
    formData.append('rule_message', $rule_message);
    formData.append('validate_path', $validate_path);

    $.ajax({
        url: base_path + 'tool-ajax-validate',
        dataType: 'json',
        type:'POST',
        data: formData,
        async: false,
        cache: false,
        contentType: false,
        processData: false,
        error: function(xhr) {},
        success: function(response) {
            if($submit) {
                $($form).submit();
            } else {
                check = true;
            }
        }
    });

    return check;
};

/**
 * 圖片編輯視窗
 *
 * image_url 請先利用 base64_encode 傳進來, js本身的需要另外裝js或者原生函數(只支援IE10以上)
 */
function image_editor_box($image_url) {
	$.colorbox({
		href: base_path + 'image-editor/' + $image_url,
		iframe: true,
		innerWidth: 1000,
		innerHeight: 640,
	});
}

function temp_input($form, $key_string) {
    var formData = new FormData($($form)[0]);

    formData.append('key_string', $key_string);

    $.ajax({
        url: base_path + 'tool-ajax-temp-input',
        dataType: 'json',
        type:'POST',
        data: formData,
        async: false,
        cache: false,
        contentType: false,
        processData: false,
        error: function(xhr) {},
        success: function(response) {
            // console.log('save');
        }
    });
};