<section>
	<div class="row">
		<div class="col-md-4">
			<img src="<?= PATH_IMAGE.$data['detail']['image_pd'] ?>" width="90%" height="400">
		</div>
		<div class="col-md-8"">
			<h3><b><?= $data['detail']['name_pd']; ?></b></h3>
			<h4>Giá bìa: <b><?= number_format($data['detail']['price_pd']); ?></b>đ</h4>
			<?php $piceOutput = $data['detail']['price_pd']-(($data['detail']['sale_off']*$data['detail']['price_pd'])/100); ?>
			<h4>Giá Bán: <b><?= number_format($piceOutput); ?></b>đ (giảm <?= $data['detail']['sale_off']?>%)</h4>
			<h4>Tình trạng: <b><?= ($data['detail']['quanity_pd'] > 0)?'Còn hàng' :'Hết hàng'; ?></b></h4>
			<h4><b>Giới thiệu sách: </b> <?= $data['detail']['description_pd']; ?></h4>
			<a href="?c=cart&m=add&id=<?= $data['detail']['id']?>" class="btn btn-primary">Mua ngay</a>
			<a href="?c=cart&m=add&id=<?= $data['detail']['id']?>" class="btn btn-info">Thêm vào giỏ hàng</a>
		</div>
	</div>
</section>
<section>
	<div class="row" style="background-color:#D9EDF7;color: orange; margin: 10px 0px; ">
		<div class="col-md-4">
			<h3>Đánh giá sản phẩm</h3>
		</div>
	</div>
	<h4><b><?php echo count($data['comment']);?> Comment</b></h4>
	<hr>
	<div class="row">
		<?php foreach ($data['comment'] as $key => $item): ?>
			<div class="col-md-2">
				<span class="glyphicon glyphicon-user">
					<b>
						<?php echo $item['name_cus']?>
					</b>					
				</span>
			</div>
			<div class="col-md-10">
				<p class="text-info"><?= $item['content'] ?></p>
			</div>	
		<?php endforeach ?>
	</div>
	<hr>
	<?php if(isset($_SESSION['id_cus'])): ?>
	<div class="row">
		<div class="col-md-2">
			<span class="glyphicon glyphicon-user">
				<b>
				<?php echo $_SESSION['name_cus']; ?>
				</b>
			</span>
		</div>
		<div class="col-md-10">
			<p id="error" style="display: none; color: red;">Bạn vui lòng đánh giá sản phẩm vào ô dưới đây</p>
			<input type="text" name="txtComment" id="txtComment" class="form-control" style="margin-bottom: 10px; width: 80%;">
			<button type="submit" class="btn btn-info" name="btnCom" id="btnCom">Post</button>
		</div>
	</div>
	<?php endif; ?>
</section>
<section>
	<div class="row" style="background-color:#D9EDF7;color: orange; margin: 10px 0px; ">
		<div class="col-md-4">
			<h3>Sản phẩm cùng loại</h3>
		</div>
	</div>
	<div class="row" style="margin: 10px 0px">
		<?php foreach ($data['withKind'] as $key => $item): ?>
			<div class="col-md-3">
				<img src="<?php echo PATH_IMAGE.$item['image_pd'] ?>" width="90%" height="300">
				<hr>
				<div class="text-left" style="min-height: 130px;">
					<p>Tên Sách: <a href="?c=product&m=detail&id=<?= $item['id']; ?>"><b><?= $item['name_pd']; ?></b></a></p>
					<p>Giá bìa: <b id="price"><?= number_format($item['price_pd']); ?></b></p>
					<p>Giá sale: <b id="sale"><?= number_format($item['sale_off']); ?></b></p>
					<p>Tình trạng: <b><?php echo (!empty($item['quanity_pd']))?"còn hàng" : "hết hàng"; ?></b></p>			
				</div>
				<hr>
				<a href="?c=product&m=detail&id=<?= $item['id']; ?>" class="btn btn-info">Mua ngay</a>
			</div>
		<?php endforeach; ?>
	</div>
</section>
<script type="text/javascript">
	function getVariableFromUrl(variable)
	{
	    var query = window.location.search.substring(1);
	    var vars  = query.split('&');
	    for (var i= 0;i < vars.length; i++) {
	           var pair = vars[i].split("=");
	           if(pair[0] == variable){return pair[1];}
	    }
	    return(false);
	}
	var idPd = getVariableFromUrl('id');
	$('#btnCom').click(function(){
		// alert('uow');
		content = $('#txtComment').val().trim();
		// alert(content);
		if (content != '') {
			$.ajax({
				url:"?c=product&m=handleCom",
				type:"POST",
				data: {content:content,idPd:idPd},
				success:function(res){
					alert(res);
				}
			});			
		}else{
			document.getElementById('error').style.display = 'block';
		}

	});
</script>