<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Error</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ resources_path() }}css/font-awesome.min.css">
        <style>
            .main {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 36px;
                padding: 20px;
            }
        </style>

		<script src="{{ resources_path() }}js/jquery.js"></script>
		<script type="text/javascript">
			$(function() {

			@if(Session::has('message'))
				$('#message').html('{!! Session::get('message') !!}');
			@endif

			@if(Session::has('errors'))
				$('#message').html('{!! join('<br>', Session::get('errors')->all()) !!}');
			@endif

			});
		</script>
    </head>
    <body>
        <div class="flex-center position-ref full-height main">
            <div class="content">
                <div class="title">
                	<div id="message">

                	</div>
                	<br>
                    發生了一些錯誤，請通知網站管理員!<br>
                    Something went wrong, please notify the webmaster!
                    <br>
                    <button onclick="location.href='{{ base_path() }}index'" style="cursor: pointer;">{{ lang('common.go-home') }}</button>
                </div>
            </div>
        </div>
    </body>
</html>