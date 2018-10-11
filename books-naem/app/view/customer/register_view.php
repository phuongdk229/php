<?php if (!isset($_SESSION['idCus'])): ?>

	<div class="row">
		<div class="col-md-4">
			<h3><b>Thông tin mua hàng</b></h3>
			<?php if(!isset($_SESSION['id_cus'])): ?>
				<p>Quý khách vui lòng đăng nhập tài khoản hoặc đăng ký tài khoản để hoàn thành các bước thanh toán sản phẩm</p>
				<a href="?c=login&m=index" style="margin-right: 20px;">Đăng nhập</a>
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
				<div id="register-nember">
					<form role="form" action="?c=customer&m=handleAddCus" method="POST">
						<div class="form-group">
							<input class="form-control" type="email" id="txtEmailCus" name="txtEmailCus" placeholder="Email" required="required">
						</div>
						<div class="form-group">
							<input type="text" name="txtNameCus" id="txtNameCus" class="form-control" placeholder="Name Customer" required="required">
						</div>
						<div class="form-group">
							<input type="password" name="txtPassCus" id="txtPassCus" class="form-control" placeholder="Password Customer" required="required">
						</div>					
						<div class="form-group">
							<input type="number" name="phoneCus" id="phoneCus" class="form-control" placeholder="Phone Number" required="required">
						</div>
						<div class="form-group">
							<input type="text" name="addressCus" id="addressCus" class="form-control" placeholder="Specific address" required="required">
						</div>
						<button type="submit" name="btnRegister" class="btn btn-info">Register Member</button>	
					</form>				
				</div>
			<?php else: ?>
				<div id="infoCus">
					<div class="form-group">
						<input class="form-control" type="email" id="txtEmailCus" name="txtEmailCus" value="<?= $_SESSION['email_cus']; ?>" " readonly="readonly">
					</div>
					<div class="form-group">
						<input type="text" name="txtNameCus" id="txtNameCus" class="form-control" value="<?= $_SESSION['name_cus'];?>" readonly="readonly">
					</div>					
					<div class="form-group">
						<input type="number" name="phoneCus" id="phoneCus" class="form-control" value="<?= $_SESSION['phone_cus'];?>" readonly="readonly">
					</div>
					<div class="form-group">
						<input type="text" name="addressCus" id="addressCus" class="form-control" value="<?= $_SESSION['address_cus'];?>" readonly="readonly">
					</div>
					<div class="form-group">
						<input type="text" name="coinCus" id="coinCus" class="form-control" value="<?= $_SESSION['coin'];?>" readonly="readonly">
						<?php if (isset($_SESSION['cartPd'])): ?>
							<?php foreach ($_SESSION['cartPd'] as $key => $item): ?>
								<?php $sumMoney =0; ?>
								<?php $sumMoney += ($item['price']*$item['qtyPd']); ?>							
							<?php endforeach; ?>
						<?php endif; ?>
						<?php if($_SESSION['coin'] > 10 && $sumMoney < 500000 && ($_SESSION['coin']*1000) < $sumMoney ): ?>
							<button class="btn btn btn-primary" id="handleCoin" name="handleCoin" >Dùng xu  [-<?= number_format($_SESSION['coin']*1000) ?>]</button>
						<?php endif; ?>
					</div>										
					<div class="form-group">
						<select class="form-control" id="city">
							<option>Chọn Tỉnh/Thành phố</option>
							<?php foreach ($data['city'] as $key => $item): ?>
								<option value="<?= $item['id']; ?>"><?= $item['name_city']; ?></option>
							<?php endforeach; ?>
						</select>				
					</div>
					<div class="form-group">
						<select class="form-control" id="district">
							<option>Chọn Quận/Huyện</option>
						</select>				
					</div>
				
				</div>								
			<?php endif; ?>

		</div>
		<div class="col-md-4">
			<h3><b>Phí Vận chuyển:</b></h3>
			<h4 class="ship"></h4>
			<!-- <input type="number" name="ship" id="ship"> -->
			<h3><b>Thanh Toán: </b></h3>
			<h4>Thanh toán khi giao hàng</h4>
		</div>
		<div class="col-md-4">
			<h3 class="text-center"><b>Đơn Hàng</b></h3>
			<?php 
				$sumMoney = 0;
				// $ship = $data['city']['ship_pay'];
			?>
			<?php if (isset($_SESSION['cartPd'])): ?>
				<?php foreach ($_SESSION['cartPd'] as $key => $val): ?>
					<div class="row">
						<div class="col-md-4">
							<img src="<?= PATH_IMAGE.$val['imagePd']; ?>" style="height: 150px; width: 80%;">	
						</div>
						<div class="col-md-8">
							<p><b>Tên Sách: </b><?= $val['namePd']; ?></p>
							<p><b>Số lượng: </b> <?= $val['qtyPd']; ?></p>
							<?php $money = $val['qtyPd']*$val['price']; ?>
							<p><b>Thành Tiền: </b><?php echo number_format($money); ?>đ</p>					
						</div>
					</div>
					<hr>
					<?php $sumMoney += ($val['price']*$val['qtyPd']); ?>
				<?php endforeach; ?>
			<?php endif; ?>
			<div class="row">
				<div class="col-md-8"><p><b>Tạm tính:</b></hp></div>
				<div class="col-md-4"><?= number_format($sumMoney); ?></div>
			</div>
			<div class="row">
				<div class="col-md-8"><p><b>Phí vận chuyển</b>:</p></div>
				<div class="col-md-4"><p class="ship">...</p></div>
			</div>
			<div class="row" id="useCoin">
				<div class="col-md-8"><p><b>Đã dùng xu</b>: -</p></div>
				<div class="col-md-4"><p id="coin">0</p></div>
				<!-- <?php if($_SESSION['coin'] > 10): ?> -->
				<!-- <div class="col-md-4" ><p id="coin" style="display: none;">- </p></div> -->
				<!-- <?php else: ?> -->
				<!-- <div class="col-md-4" ><p class="coin" id="coin">- </p></div> -->
			<!-- <?php endif; ?> -->
			</div>
			<div class="row" id="freeShip">
				<div class="col-md-8"><p><b>Ưu đãi</b>: -</p></div>
				<?php if($sumMoney >= 500000): ?>
					<div class="col-md-4"><p class="ship">0</p></div>
				<?php else: ?>
					<div class="col-md-4"><p class="freeship">0</p></div>
				<?php endif; ?>
			</div>			
			<hr>
			<div class="row">
				<div class="col-md-8"><p><b>Tổng cộng:</b></p></div>
				<div class="col-md-4"><p id="pay"></p></div>
			</div>
			<div class="row">
				<div class="col-md-6"><a href="?c=cart&m=index" class="btn btn-info">Quay về giỏ hàng</a></div>
				<!-- <div class="col-md-6"><a href="?c=customer&m=handleBill" class="btn btn-primary">Xác nhận đặt hàng</a></div> -->

					<div class="col-md-6">
						<button type="submit" name="btnSubmit" id="btnSubmit" class="btn btn-primary" style="display: none;">Xác nhận đặt hàng</button>
					</div>					
			</div>					
			
		</div>
	</div>
<?php endif; ?>
<script type="text/javascript">
	// hien district
	$(document).ready(function(){
		$("#city").change(function(){
			id = $("#city").val();
			// alert(id);
			$.ajax({
				url: "?c=customer&m=ajax_city",
				type: "POST",
				data: {id:id},
				success:function(res){
					// alert(res);
					$("#district").html(res);
				}
			});
		});
	});
	// hien phi ship
	$(document).ready(function(){
		$("#city").change(function(){
			idCity = $("#city").val();
			// alert(idCity);

			$.ajax({
				url: "?c=customer&m=ajax_ship",
				type: "POST",
				data: {idCity,idCity},
				success:function(res){
					// alert(res);
					$('.ship').html(res);
				}
			});
		});
	});
	// hien tong tien khi co xu
	$('#handleCoin').click(function(){
		$("#city").change(function(){
			let coinCustomer = 0;
			idCity = $("#city").val();
			coin = $('#coinCus').val();
			if ($('#handleCoin').click) {}
			if (coin >= 10 ) {
					coinCustomer = coin;
			}
			// alert(coin);
			$.ajax({
				url:"?c=customer&m=ajax_pay",
				type:"POST",
				data:{idCity:idCity,coinCustomer:coinCustomer},
				success:function(res){
						// alert(res);
					$('#pay').html(res);
				}
			});
		});
	});
	// thay doi tinh xu
	document.getElementById('city').addEventListener('change',function(){
		document.getElementById('btnSubmit').style.display = 'block';
		document.getElementById('handleCoin').style.display = 'none';
		
	});
	// 
	$("#city").change(function(){
		let coinCustomer = 0;
		idCity = $("#city").val();
			// alert(coin);
		$.ajax({
			url:"?c=customer&m=ajax_pay",
			type:"POST",
			data:{idCity:idCity,coinCustomer:coinCustomer},
			success:function(res){
						// alert(res);
				$('#pay').html(res);
			}
		});
	});
	// khi nut thanh toan duoc an
	$('#btnSubmit').click(function(){
		let idCity = $('#city').val();
		let idDis = $('#district').val();
		let coinCus = $('#coin').text();

		if (idCity == '') {
			alert('Vui lòng lựa chọn tỉnh/thành phố');
		}else{
			$.ajax({
				url: "?c=customer&m=handleBill",
				type: "POST",
				data:{idCity:idCity,idDis:idDis,coinCus:coinCus},
				success:function(res){
					alert(res);
					window.location.href= '?c=home';
				}
			});			
		}
	});

	// hien tien xu khi duoc tinh vao hoa don
	document.getElementById('handleCoin').addEventListener('click',function(){
		let coin = $('#coinCus').val();
		document.getElementById('coin').innerHTML = coin*1000;
	});

	// thong bao loi
	let url = $(location).attr('search');
	// alert(url);
	let state = 'err';
	let result = url.indexOf(state);
	if (result !== -1) {
		alert('Xảy ra lỗi. Vui lòng kiểm tra lại thông tin');
		window.location.href = '?c=customer&m=register';
	}
</script>
