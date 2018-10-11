<section>
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<h3 class="text-center">Đăng ký tài khoản Pbook </h3>
			<?php if(!empty($data['errAdd'])): ?>
					<div>
						<ul>
							<?php foreach ($data['errAdd'] as $key => $err): ?>
								<?php if(!empty($err)): ?>
									<li style="color: red;">
									<?= $err; ?>
								</li>
								<?php endif; ?>
							<?php endforeach ?>
						</ul>
					</div>
				<?php endif; ?>
				<?php if(!empty($data['state']) && $data['errEmail'] !== ''): ?>
					<div>
						<h5 style="color: red;">Email <b style="color: black;"><?= $data['errEmail']; ?></b> already exist!</h5>
					</div>
				<?php endif; ?>
			<form role="form" action="?c=customer&m=handleAddCusOnMenu" enctype="multipart/form-data" method="POST" style="padding: 5px;">
				<div class="form-group">
					<input class="form-control" type="email" id="txtEmailCus" name="txtEmailCus" placeholder="Email">
				</div>
				<div class="form-group">
					<input type="text" name="txtNameCus" id="txtNameCus" class="form-control" placeholder="Name Customer" >
				</div>
				<div class="form-group">
					<input type="password" name="txtPassCus" id="txtPassCus" class="form-control" placeholder="Password Customer" >
				</div>				
				<div class="form-group">
					<input type="number" name="phoneCus" id="phone" class="form-control" placeholder="Phone Number">
				</div>
				<div class="form-group">
					<input type="text" name="addressCus" id="address" class="form-control" placeholder="Specific address" >
				</div>
				<button type="submit" name="btnSubmit" class="btn btn-info">Tạo tài khoản</button>
			</form>			
		</div>
	</div>
</section>
<script type="text/javascript">
	let url = $(location).attr('search');
	// alert(url);
	let state = 'err';
	let result = url.indexOf(state);
	if (result !== -1) {
		alert('Xảy ra lỗi. Vui lòng kiểm tra lại thông tin');
		window.location.href = '?c=customer&m=addCustomer';
	}
</script>