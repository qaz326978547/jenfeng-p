<style type="text/css">
	#alert_area {
		width: 100vw;
		height: 100vh;
		background: rgba(0, 0, 0, 0.5);
		position: fixed;
		left: 0;
		top: 0;
		z-index: 9999999;
		display: none;
	}
	#alert_area.active {
		display: block;
	}
	#alert_area #text-area {
		padding: 20px;
		text-align: center;
		border: 3px #EEEEEE solid;
		border-radius: 10px;
		background: #FFFFFF;
		width: 95%;
		height: auto;
		max-width: 600px;
		margin: 0 auto;
		position: relative;
		top: 50%;
		-webkit-transform: translateY(-50%);
		-ms-transform: translateY(-50%);
		transform: translateY(-50%);
	}
	#alert_area #text-area .content {
		display: block;
		margin: 20px auto;
		font-size: 1rem;
		line-height: 1.75;
		max-height: 280px;
		overflow: auto;
		font-style: normal;
	}
	#alert_area #text-area .close {
		position: absolute;
		width: 45px;
		height: 45px;
		font-size: 35px;
		line-height: 45px;
		cursor: pointer;
		color: red;
		right: 0;
		top: 0;
	}
</style>
<div id="alert_area">
	<div id="text-area" onclick="$('#alert_area').removeClass('active');">
		<div class="close" onclick="$('#alert_area').removeClass('active');">
			<i class="fa fa-times-circle" aria-hidden="true"></i>
		</div>
		<i class="content">{{-- 錯誤訊息 --}}</i>
	</div>
</div>