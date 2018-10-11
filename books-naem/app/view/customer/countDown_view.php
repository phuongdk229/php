<section>
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<!-- <input type="number" name="s_val" id="s_val" readonly="readonly"> -->
			<h4>Bạn vui lòng lấy mã xác nhận đã được gửi đến email của bạn</h4>
			<p id="s_val">0</p>
			<!-- <button type="button">Start</button> -->
			<!-- <button type="button" onclick="stop();">Stop</button> -->
			<div class="row">
				<form action="?c=customer&m=getcode" method="POST" enctype="multipart/form-data">
					<div class="form-group">
						<label>Nhập mã xác nhận</label>
						<input type="number" name="txtNumber">
						<button type="submit">Hoàn thành</button>
					</div>
					
				</form>
			</div>
		</div>
	</div>
</section>
<script type="text/javascript">
	window.onload = function(){
		let t = 0;
		let count = setInterval(function(){
					++t;
			document.getElementById('s_val').innerHTML = t;
					// start();
			if (t == 60) {
				alert('hêt thời hạn');
				window.location.href = '?c=customer&m=failCus';
			}
		},1000);			
	}
	let url = $(location).attr('search');
	// alert(url);
	let state = 'err';
	let result = url.indexOf(state);
	if (result !== -1) {
		alert('Mã xác nhận không đúng');
		window.location.href = '?c=customer&m=countDown';
	}
</script>