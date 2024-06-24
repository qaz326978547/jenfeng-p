<script type="text/javascript" src="{{ resources_path('js/admin/jquery.js') }}"></script>
<script type="text/javascript" src="{{ resources_path('js/admin/jquery-ui-1.12.1.min.js') }}"></script>
<script type="text/javascript" src="{{ resources_path('js/admin/jquery-ui-timepicker-addon.js') }}"></script>
<script type="text/javascript" src="{{ resources_path('js/admin/jquery-ui-sliderAccess.js') }}" ></script>

<script type="text/javascript" src="{{ resources_path('js/admin/colorbox/jquery.colorbox-min.js') }}"></script>
<script type="text/javascript" src="{{ resources_path('js/admin/fancybox/jquery.fancybox.min.js') }}"></script>

<script type="text/javascript" src="{{ resources_path('js/admin/address.js') }}"></script>

<script type="text/javascript" src="{{ resources_path('js/admin/jquery.validate.js') }}"></script>

{{-- <script type="text/javascript" src="{{ resources_path('js/admin/multiselect/jquery.multiselect.js') }}"></script>	 --}}
<script type="text/javascript" src="{{ resources_path('js/admin/multiple-select.js') }}"></script>

<script type="text/javascript" src="{{ resources_path('js/admin/sweetalert.min.js') }}"></script>
<script type="text/javascript" src="{{ resources_path('js/admin/devtool.js') }}"></script>
<script type="text/javascript">
	var base_path = '{{ base_path() }}';

	$(function() {
		$('body').append(@json(View::make('common.includes.alert-box')->render()));

		@if(Session::has('message'))
		alert_box('{!! Session::get('message') !!}');
		@endif

		@if(Session::has('errors'))
		alert_box('{!! join('<br>', Session::get('errors')->all()) !!}');
		@endif

        // 搜尋
		$('.search').change(function(event) {
			var $parameters = [];
			var $get_str = '';
			var $get_array = [];
			var $search = location.search.replace('?', '').split('&');

			$.each($search, function(key, value) {
				var $array = value.split('=');

				if ($array[0] != 'page') {
					$parameters[$array[0]] = $array[1];
				}
			});

			$('.search').each(function(){
				if($(this).attr('type') == 'checkbox') {
					if($(this).prop('checked')){
						$parameters[this.name] = this.value;
					} else {
						$parameters[this.name] = 0;
					}
				} else {
					$parameters[this.name] = this.value;
				}
			});

            for(var key in $parameters) {
            	$get_array.push(key + '=' + $parameters[key]);
            }

			$get_str = $get_array.join('&');

			if($parameters.hasOwnProperty('class_id')) {
				location.href = '{{ base_path('admin/'.($config['link_tag'] ?? '')) }}/' + $parameters['class_id'] + '?' + $get_str;
			} else {
				location.href = location.pathname + '?' + $get_str;
			}
		});
	});
</script>
<script type="text/javascript" src="{{ resources_path('js/tinymce/tinymce.min.js') }}"></script>
<script type="text/javascript" src="{{ resources_path('js/tinymce/config_admin.js') }}"></script>