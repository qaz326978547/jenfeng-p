// 編輯器設定
tinyMCE.init({
	selector: ".tinymce_editor",
	language: "zh_TW",
	theme: "silver",
	plugins : "importcss advlist autolink link image media lists charmap print preview table fullscreen help hr nonbreaking paste searchreplace textcolor contextmenu pagebreak charmap anchor directionality code emoticons wordcount",
	toolbar: 'undo redo | formatselect fontsizeselect fontselect lineheight | bold italic underline strikethrough ltr rtl forecolor backcolor | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent | image media link | emoticons charmap hr anchor | removeformat code preview fullscreen searchreplace',
	statusbar: false,
	min_height: 500,

	// mobile: {
	//   	theme: "mobile",
	// 	plugins: [ "autosave", "lists", "autolink" ],
	// 	toolbar: [ "undo", "bold", "italic", "styleselect" ]
	// },

	font_formats: '微軟正黑體=微軟正黑體,Microsoft JhengHei;新細明體=新細明體,PMingLiU;標楷體=標楷體,DFKai-sb;Andale Mono=andale mono,monospace;Arial=arial,helvetica,sans-serif;Arial Black=arial black,sans-serif;Book Antiqua=book antiqua,palatino,serif;Comic Sans MS=comic sans ms,sans-serif;Courier New=courier new,courier,monospace;Georgia=georgia,palatino,serif;Helvetica=helvetica,arial,sans-serif;Impact=impact,sans-serif;Terminal=terminal,monaco,monospace;Trebuchet MS=trebuchet ms,geneva,sans-serif;Verdana=verdana,geneva,sans-serif',

	forced_root_block: false,

	lineheight_formats: '1 1.1 1.2 1.3 1.4 1.5 2',

	// content_security_policy: 'default-src \'self\'',	// 放在前台時記得打開

	relative_urls : false,
	remove_script_host : true,
	convert_urls : true,

	media_alt_source: false,
	media_poster: false,

	// extended_valid_elements : "script[src|async|defer|type|charset],style,link[href|rel]",
	// custom_elements:"style,link,~link",

	// CONFIG: Paste
	paste_retain_style_properties: 'all',
	paste_word_valid_elements: '*[*]',        // word需要它
	paste_data_images: true,                  // 粘贴的同时能把内容里的图片自动上传，非常强力的功能
	paste_convert_word_fake_lists: false,     // 插入word文档需要该属性
	paste_webkit_styles: 'all',
	paste_merge_formats: true,
	nonbreaking_force_tab: false,
	paste_auto_cleanup_on_paste: false,

	image_title: true,
	image_description: true,
	images_reuse_filename: true,
	image_advtab: true,
	images_upload_handler: function (blobInfo, success, failure) {
		var formData = new FormData();
		formData.append('pic', blobInfo.blob());
		formData.append('filename', blobInfo.filename());

	    $.ajax({
	        url: base_path + 'admin/html-editor/image-upload',
	        data: formData,
	        // dataType: "json",
	        type: "POST",
	        cache: false,
	        contentType: false,
	        processData: false,
	        global: false,
	        error: function(xhr) {
		    	if(xhr.status == 404 || xhr.status == 405) {
		    		failure('發生錯誤,狀態碼：' + xhr.status)
		    		history.go(0);
		    	} else {
		        	var message = '';

		        	$.each($.parseJSON(xhr.responseText), function(key, value) {
		        		message += value + '\n';
		        	})

		        	failure(message);
		        }
	        },
	        success: function(response) {
	        	if(response['error'] != '') {
	        		failure(response.error);
	        	} else {
	        		success(response.location);
	        	}
	        },
	        complete: function(response) {}
	    });

	},
	file_picker_types: 'image',
	file_picker_callback: function (callback, value, meta) {

		window.tinymceCallBackURL = '';

		$.colorbox({
			href: base_path + 'admin/html-editor/manager',
			iframe: true,
			innerWidth: 1100,
			innerHeight: 640,
			onClosed: function() {
				callback(window.tinymceCallBackURL);
			},
		});

  //       var windowManagerURL = base_path + 'admin/html-editor/manager'; // filemanager path

  //       var windowManagerCSS = '<style type="text/css">' +
  //           '.tox-dialog {max-width: 1200px!important; width:1100px!important; overflow: hidden; height:610px!important; border-radius:0.25em;}' +
  //           // '.tox-dialog__header{ display:none!important; }' + // for custom header in filemanage
  //           // '.tox-dialog__footer { display: none!important; }' + // for custom footer in filemanage
  //           // '.tox-dialog__body { padding: 0!important; }' +
  //           // '.tox-dialog__body-content > div { height: 100%; overflow:hidden}' +
  //           '</style > ';

  //       window.tinymceCallBackURL = '';

		// tinymce.activeEditor.windowManager.open({
		// 	url: base_path + 'admin/html-editor/manager',
		// 	title: '編輯器-圖片管理 (點擊兩次選擇圖片)',
  //           body: {
  //               type: 'panel',
  //               items: [{
  //                   type: 'htmlpanel',
  //                   html: windowManagerCSS + '<iframe src="' + windowManagerURL + '"  frameborder="0" style="width:1100px; height:600px"></iframe>'
  //               }]
  //           },
  //           buttons: [] ,
		// 	resizable: 'yes',
  //           onClose: function () {
  //               callback(tinymceCallBackURL);
  //           }
		// });
	}
});