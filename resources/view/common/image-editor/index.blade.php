<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
		
		<meta name="_token" content="{{ csrf_token() }}" />

        <title>圖片編輯</title>

        <link type="text/css" href="{{ resources_path('js/tui-image-editor/css/tui-color-picker-2.2.1.min.css') }}" rel="stylesheet">
        <link type="text/css" href="{{ resources_path('js/tui-image-editor/css/service-basic.css') }}" rel="stylesheet">
        <link type="text/css" href="{{ resources_path('css/admin/image-editor.css') }}" rel="stylesheet">


		<script src="{{ resources_path('js/tui-image-editor/js/jquery-1.8.3.min.js') }}"></script>
        <script defer src="{{ resources_path('js/tui-image-editor/js/fabric-1.6.7.min.js') }}"></script>
        <script defer src="{{ resources_path('js/tui-image-editor/js/tui-code-snippet-1.5.0.min.js') }}"></script> 
        <script defer src="{{ resources_path('js/tui-image-editor/js/FileSaver-2.2.0.min.js') }}"></script> 
        <script defer src="{{ resources_path('js/tui-image-editor/js/tui-color-picker-1.0.2.min.js') }}"></script> 
        <script defer src="{{ resources_path('js/tui-image-editor/js/tui-image-editor-3.3.0.min.js') }}"></script>
        <script defer src="{{ resources_path('js/tui-image-editor/js/service-basic.js') }}"></script>

        <script type="text/javascript">

			$(function(){ 
				$('.main-menu .menu-item').click(function(){
					$('.main-menu .menu-item').removeClass('active');
					$(this).addClass('active');
				});

				imageEditor.loadImageFromURL('{{ $image_url }}', 'ediotrimage');

			});

        	function saveImage() {
				$.ajax({				   
				    url: '{{ base_path('image-editor/save') }}',
				    cache: false,
				    dataType: 'json',
				    type: 'POST',
				    data: {
				    	image_url: '{{ $image_url }}',	
						image_data: imageEditor.toDataURL(),
				    },
					headers: {
						'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
					},	
			        error: function(xhr) {}, 
			        success: function(response) { 
					    parent.$.fn.colorbox.close();
					    setTimeout(parent.location.reload(true), 500);
			        }
				});
        	}
        </script>        
    </head>
    <body>
        <div class="body-container">
            <div class="tui-image-editor-controls">
                <div class="header">
                    <!-- <img class="logo" src="img/TOAST UI Component.png"> -->
                    <span class="name">圖片編輯</span>
                    <ul class="menu">
<!--                         <li class="menu-item border input-wrapper">
                            Load
                            <input type="file" accept="image/*" id="input-image-file">
                        </li> -->
                        <!-- <li class="menu-item border" id="btn-download">Download</li> -->
                        <li class="menu-item border" onclick="saveImage();">編輯確認</li>
                    </ul>
                </div>

                <ul class="menu main-menu">
                    <li class="menu-item disabled" id="btn-undo">上一步</li>
                    <li class="menu-item disabled" id="btn-redo">下一步</li>
                    <li class="menu-item" id="btn-clear-objects">{{-- ClearObjects --}}清除全部物件</li>
                    {{-- 
                    	<li class="menu-item" id="btn-remove-active-object">RemoveActiveObject關閉選單(?)</li>--}}
                    <li class="menu-item" id="btn-crop">裁剪</li>
                    <li class="menu-item" id="btn-flip">{{--Flip--}}反轉</li>
                    <li class="menu-item" id="btn-rotation">{{--Rotation--}}旋轉</li>
                    <li class="menu-item" id="btn-draw-line">{{-- DrawLine --}}畫線</li>
                    <li class="menu-item" id="btn-draw-shape">{{-- Shape --}}繪框</li>
                    {{-- <li class="menu-item" id="btn-add-icon">Icon</li> --}}
                    <li class="menu-item" id="btn-text">{{-- Text --}}文字</li>
                    <li class="menu-item" id="btn-mask-filter">{{-- Mask --}}遮罩</li>
                    {{-- <li class="menu-item" id="btn-image-filter">Filter濾鏡</li> --}}
                </ul>
				
				{{-- 裁減 --}}
                <div class="sub-menu-container" id="crop-sub-menu">
                    <ul class="menu">
                    	<li class="menu-item" id="btn-crop-3-2" onclick="imageEditor.setCropzoneRect(3 / 2);">{{-- Apply --}}3:2</li>
                    	<li class="menu-item" id="btn-crop-4-3" onclick="imageEditor.setCropzoneRect(4 / 3);">{{-- Apply --}}4:3</li>
                    	<li class="menu-item" id="btn-crop-5-4" onclick="imageEditor.setCropzoneRect(5 / 4);">{{-- Apply --}}5:4</li>
                    	<li class="menu-item" id="btn-crop-7-5" onclick="imageEditor.setCropzoneRect(7 / 5);">{{-- Apply --}}7:5</li>
                    	<li class="menu-item" id="btn-crop-16-9" onclick="imageEditor.setCropzoneRect(16 / 9);">{{-- Apply --}}16:9</li>
                        <li class="menu-item" id="btn-apply-crop">{{-- Apply --}}應用</li>
                        <li class="menu-item" id="btn-cancel-crop">{{-- Cancel --}}取消</li>
                    </ul>
                </div>
				
				{{-- 反轉 --}}
                <div class="sub-menu-container" id="flip-sub-menu">
                    <ul class="menu">
                        <li class="menu-item" id="btn-flip-x">{{-- FlipX --}}X軸反轉</li>
                        <li class="menu-item" id="btn-flip-y">{{-- FlipY --}}Y軸反轉</li>
                        <li class="menu-item" id="btn-reset-flip">{{-- Reset --}}重置</li>
                        <li class="menu-item close">{{-- Close --}}關閉</li>
                    </ul>
                </div>

                {{-- 旋轉 --}}
                <div class="sub-menu-container" id="rotation-sub-menu">
                    <ul class="menu">
                        <li class="menu-item" id="btn-rotate-clockwise">{{-- Clockwise(30) --}}順時針(30)</li>
                        <li class="menu-item" id="btn-rotate-counter-clockwise">{{-- Counter-Clockwise(-30) --}}逆時針(30)</li>
                        <li class="menu-item no-pointer"><label>{{-- Range input --}}輸入範圍<input id="input-rotation-range" type="range" min="-360" value="0" max="360"></label></li>
                        <li class="menu-item close">{{-- Close --}}關閉</li>
                    </ul>
                </div>
				
				{{-- 線條 --}}
                <div class="sub-menu-container menu" id="draw-line-sub-menu">
                    <ul class="menu">
                        <li class="menu-item">
                            <label><input type="radio" name="select-line-type" value="freeDrawing" checked="checked">{{--  Free drawing --}}自由模式</label>
                            <label><input type="radio" name="select-line-type" value="lineDrawing"> {{-- Straight line --}}直線</label>
                        </li>
                        <li class="menu-item">
                            <div id="tui-brush-color-picker">{{-- Brush color --}}筆刷顏色</div>
                        </li>
                        <li class="menu-item"><label class="menu-item no-pointer">{{-- Brush width --}}筆刷寬度<input id="input-brush-width-range" type="range" min="5" max="30" value="12"></label></li>
                        <li class="menu-item close">{{-- Close --}}關閉</li>
                    </ul>
                </div>
				
				{{-- 繪框  --}}
                <div class="sub-menu-container" id="draw-shape-sub-menu">
                    <ul class="menu">
                        <li class="menu-item">
                            <label><input type="radio" name="select-shape-type" value="rect" checked="checked"> {{-- rect --}}矩形</label>
                            <label><input type="radio" name="select-shape-type" value="circle"> {{-- circle --}}圓形</label>
                            <label><input type="radio" name="select-shape-type" value="triangle"> {{-- triangle --}}三角</label>
                        </li>
                        <li class="menu-item">
                            <select name="select-color-type">
                                <option value="fill">{{-- Fill --}}填滿</option>
                                <option value="stroke">{{-- Stroke --}}框線</option>
                            </select>
                            <label><input type="checkbox" id="input-check-transparent">{{-- transparent --}}透明</label>
                            <div id="tui-shape-color-picker"></div>
                        </li>
                        <li class="menu-item"><label class="menu-item no-pointer">{{-- Stroke width --}}框線寬<input id="input-stroke-width-range" type="range" min="0" max="300" value="12"></label></li>
                        <li class="menu-item close">{{-- Close --}}關閉</li>
                    </ul>
                </div>
				
				{{-- ICON --}}
                <div class="sub-menu-container" id="icon-sub-menu">
                    <ul class="menu">
                        <li class="menu-item">
                            <div id="tui-icon-color-picker">Icon color</div>
                        </li>
                        <li class="menu-item border" id="btn-register-icon">Register custom icon</li>
                        <li class="menu-item icon-text" data-icon-type="arrow">➡</li>
                        <li class="menu-item icon-text" data-icon-type="cancel">✖</li>
                        <li class="menu-item close">{{-- Close --}}關閉</li>
                    </ul>
                </div>

				{{-- 文字 --}}
                <div class="sub-menu-container" id="text-sub-menu">
                    <ul class="menu">
                        <li class="menu-item">
                            <div>
                                <button class="btn-text-style" data-style-type="b">{{-- Bold --}}粗體</button>
                                <button class="btn-text-style" data-style-type="i">{{-- Italic --}}斜體</button>
                                <button class="btn-text-style" data-style-type="u">{{-- Underline --}}底線</button>
                            </div>
                            <div>
                                <button class="btn-text-style" data-style-type="l">{{-- Left --}}置左</button>
                                <button class="btn-text-style" data-style-type="c">{{-- Center --}}置中</button>
                                <button class="btn-text-style" data-style-type="r">{{-- Right --}}置右</button>
                            </div>
                        </li>
                        <li class="menu-item"><label class="no-pointer"><input id="input-font-size-range" type="range" min="10" max="100" value="10"></label></li>
                        <li class="menu-item">
                            <div id="tui-text-color-picker">{{-- Text color --}}顏色</div>
                        </li>
                        <li class="menu-item close">{{-- Close --}}關閉</li>
                    </ul>
                </div>

				{{-- 遮罩 --}}
                <div class="sub-menu-container" id="filter-sub-menu">
                    <ul class="menu">
                        <li class="menu-item border input-wrapper">
                            {{-- Load Mask Image --}}
                            讀取遮罩圖片
                            <input type="file" accept="image/*" id="input-mask-image-file">
                        </li>
                        <li class="menu-item" id="btn-apply-mask">{{-- Apply mask filter --}}儲存遮罩</li>
                        <li class="menu-item close">{{-- Close --}}關閉</li>
                    </ul>
                </div>
				
				{{-- 濾鏡 --}}
                <div class="sub-menu-container" id="image-filter-sub-menu">
                    <ul class="menu">
                        <li class="menu-item align-left-top">
                            <table>
                                <tbody>
                                    <tr>
                                        <td><label><input type="checkbox" id="input-check-grayscale">Grayscale</label></td>
                                        <td><label><input type="checkbox" id="input-check-invert">Invert</label></td>
                                        <td><label><input type="checkbox" id="input-check-sepia">Sepia</label></td>
                                    </tr>
                                    <tr>
                                        <td><label><input type="checkbox" id="input-check-sepia2">Sepia2</label></td>
                                        <td><label><input type="checkbox" id="input-check-blur">Blur</label></td>
                                        <td><label><input type="checkbox" id="input-check-sharpen">Sharpen</label></td>
                                    </tr>
                                    <tr>
                                        <td><label><input type="checkbox" id="input-check-emboss">Emboss</label></td>
                                    </tr>
                                </tbody>
                            </table>
                        </li>
                        <li class="menu-item align-left-top">
                            <p>
                                <label><input type="checkbox" id="input-check-remove-white">RemoveWhite</label><br>
                                <label>Threshold<input class="range-narrow" id="input-range-remove-white-threshold" type="range" min="0" value="60" max="255"></label><br>
                                <label>Distance<input class="range-narrow" id="input-range-remove-white-distance" type="range" min="0" value="10" max="255"></label>
                            </p>
                        </li>
                        <li class="menu-item align-left-top">
                            <p>
                                <label><input type="checkbox" id="input-check-brightness">Brightness</label><br>
                                <label>Value<input class="range-narrow" id="input-range-brightness-value" type="range" min="-255" value="100" max="255"></label>
                            </p>
                        </li>
                        <li class="menu-item align-left-top">
                            <p>
                                <label><input type="checkbox" id="input-check-noise">Noise</label><br>
                                <label>Value<input class="range-narrow" id="input-range-noise-value" type="range" min="0" value="100" max="1000"></label>
                            </p>
                        </li>
                        <li class="menu-item align-left-top">
                            <p>
                                <label><input type="checkbox" id="input-check-gradient-transparancy">GradientTransparency</label><br>
                                <label>Value<input class="range-narrow" id="input-range-gradient-transparency-value" type="range" min="0" value="100" max="255"></label>
                            </p>
                        </li>
                        <li class="menu-item align-left-top">
                            <p>
                                <label><input type="checkbox" id="input-check-pixelate">Pixelate</label><br>
                                <label>Value<input class="range-narrow" id="input-range-pixelate-value" type="range" min="2" value="4" max="20"></label>
                            </p>
                        </li>
                        <li class="menu-item align-left-top">
                            <p>
                                <label><input type="checkbox" id="input-check-tint">Tint</label><br>
                                <div id="tui-tint-color-picker"></div>
                                <label>Opacity<input class="range-narrow" id="input-range-tint-opacity-value" type="range" min="0" value="1" max="1" step="0.1"></label>
                            </p>
                        </li>
                        <li class="menu-item align-left-top">
                            <p>
                                <label><input type="checkbox" id="input-check-multiply">Multiply</label>
                                <div id="tui-multiply-color-picker"></div>
                            </p>
                        </li>
                        <li class="menu-item align-left-top">
                            <p>
                                <label><input type="checkbox" id="input-check-blend">Blend</label>
                                <div id="tui-blend-color-picker"></div>
                                <select name="select-blend-type">
                                    <option value="add" selected>Add</option>
                                    <option value="diff">Diff</option>
                                    <option value="diff">Subtract</option>
                                    <option value="multiply">Multiply</option>
                                    <option value="screen">Screen</option>
                                    <option value="lighten">Lighten</option>
                                    <option value="darken">Darken</option>
                                </select>
                            </p>
                        </li><li class="menu-item align-left-top">
                            <p>
                                <label><input type="checkbox" id="input-check-color-filter">ColorFilter</label><br>
                                <label>Threshold<input class="range-narrow" id="input-range-color-filter-value" type="range" min="0" value="45" max="255"></label>
                            </p>
                        </li>
                        <li class="menu-item close">{{-- Close --}}關閉</li>
                    </ul>

                </div>
            </div>
            <div class="tui-image-editor"></div>
        </div>
    </body>
</html>