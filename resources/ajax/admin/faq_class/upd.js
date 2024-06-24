function ajax_upd_act($id, $col, $value, $type, $rule_mode) {
    $.ajax({
        url: $url + 'ajax/upd/' + $id + '/act',
        cache: false,
        dataType: 'json',
        type: 'PATCH',
        data: {id: $id, col: $col, value: $value, type: $type, rule_mode: $rule_mode},
        error: function (xhr) {},
        success: function (response) {
			if(response['error'] != '') {
				console.log(response['error']);
			}
			else {
				// alert_box(response['success']);
			}
        },
        complete: function(xhr) {
        	if(xhr.status == 422) {
        		$('#alert_area .close').click(function(event) { history.go(0); });
        	}
        }
    });
}

function ajax_upd($id, $column, $value) {
    $.ajax({
        url: $url + 'ajax/upd/' + $id + '/' + $column,
        cache: false,
        dataType: 'json',
        type: 'PATCH',
        data: {id: $id, value: $value},
        error: function (xhr) {},
        success: function (response) {
			if(response['error'] != '') {
				console.log(response['error']);
			}
			else {
				// alert_box(response['success']);
				// $('#alert_area .close').click(function(event) { history.go(0); });
				history.go(0);
			}
        },
        complete: function(xhr) {
        	if(xhr.status == 422) {
        		$('#alert_area .close').click(function(event) { history.go(0); });
        	}
        }
    });
}