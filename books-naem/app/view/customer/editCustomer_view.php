<section>
	<div class="row">
		<div class="col-lg-12">
			<h3 class="text-center">SỬA THÔNG TIN KHÁCH HÀNG</h3>
			<hr>
		</div>
		<?php if (!empty($data['errEdit'])): ?>
			<div class="col-lg-12">
				<ul>
					<?php foreach($data['errEdit'] as $key => $err): ?>
						<?php if(!empty($err)): ?>
							<li style="color: red;"><?= $err; ?></li>
						<?php endif; ?>
					<?php endforeach; ?>
				</ul>
			</div>
			<hr>			
		<?php endif; ?>

		<div class="col-lg-12">
			<form action="?c=customer&m=handleEdit" method="POST" enctype="multipart/form-data">
			<div class="col-md-6">
				<div class="form-group">
					<label for="">Tên Khách hàng:</label>
					<input type="text" name="txtName" class="form-control" value="<?= $_SESSION['name_cus'];?>" id="txtName">
				</div>
				<div class="form-group">
					<label for="">Email:</label>
					<input type="text" name="txtEmail" class="form-control" value="<?= $_SESSION['email_cus'];?>" readonly>
				</div>
				<div class="form-group">
					<label for="">Địa chỉ:</label>
					<input type="text" name="txtAddr" class="form-control" value="<?= $_SESSION['address_cus']?>"  id="txtAddr">
				</div>			
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="">Số điện thoại:</label>
					<input type="number" name="txtPhone" class="form-control" value="<?= $_SESSION['phone_cus'] ?>" id="txtPhone">
				</div>
				<div class="form-group">
					<label for="">Xu:</label>
					<input type="number" name="txtCoin" class="form-control" value="<?= $_SESSION['coin']; ?>" readonly>
				</div>
				<button type="submit" name="btnSubmit" id="btnSubmit" class="btn btn-primary">Perfect</button>
				<a href="#" class="btn btn-info">Cancel</a>			
			</div>
			</form>
		</div>		
	</div>
</section>
<script type="text/javascript">
	$(function(){
		$('#btnSubmit').click(function(){
			
			// let name = $('#txtName').val().trim();
			// let address = $('#txtAddr').val().trim();
			// let phone = $('#txtPhone').val().trim();
			// alert(name);
			// alert(`{name}-{address}-{phone}`);
			// $.ajax({
			// 	url:'?c=customer&m=handleEdit',
			// 	type: 'POST',
			// 	data:{name:name,address:address,phone:phone},
			// 	success:function(res){
			// 		// alert(res);
					
			// 	}
			// })
		})
	})

</script>
