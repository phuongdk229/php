<article>
	<div class="row">
		<div id="carousel-example-generic" class="carousel slide" data-ride="carousel" style="height: 400px">
		  <!-- Indicators -->
		  <ol class="carousel-indicators">
		    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
		    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
		    <li data-target="#carousel-example-generic" data-slide-to="2"></li>
		  </ol>

		  <!-- Wrapper for slides -->
		  <div class="carousel-inner" style="height: 100%;">
		    <div class="item active" style="height: 100%;">
		      <img src="<?= PATH_IMAGE.$data['slide'][0]['name_pic']; ?>" alt="..." style="width: 100%; height: 100%;">
		    </div>
		    <div class="item">
		      <img src="<?= PATH_IMAGE.$data['slide'][1]['name_pic']; ?>" alt="..." style="width: 100%; height: 400px;">
		    </div>
		    <div class="item">
		      <img src="<?= PATH_IMAGE.$data['slide'][2]['name_pic']; ?>" alt="..." style="width: 100%; height: 400px;">
		    </div>    
		  </div>

		  <!-- Controls -->
		  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev" style="background-image: none;">
		    <span class="glyphicon glyphicon-chevron-left"></span>
		  </a>
		  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next" style="background-image: none;">
		    <span class="glyphicon glyphicon-chevron-right"></span>
		  </a>
		</div>		
	</div>
</article>


<div class="row">
	<section>
		<div class="col-md-12" style="background-color:#D9EDF7;color: orange; height: 50px; ">
			<div class="col-md-4">
				<h3>Sách bán chạy</h3>
			</div>
		</div>
		<div class="col-md-12" style="display: inline;">
			<?php foreach ($data['lstBestSell'] as $key => $item): ?>
			<div class="col-md-3" style="padding: 10px;">
				<img src="<?php echo PATH_IMAGE.$item['image_pd'] ?>" width="90%" height="300">
				<hr>
				<div class="text-left" style="min-height: 130px;">
					<p>Tên Sách: <a href="?c=product&m=detail&id=<?= $item['id']; ?>"><b><?= $item['name_pd']; ?></b></a></p>
					<p>Giá bìa: <b style="text-decoration: line-through;"><?= number_format($item['price_pd']); ?></b></p>
					<p>Giá sale: <b><?= number_format($item['price_pd']-(($item['sale_off']*$item['price_pd'])/100)); ?></b></p>
					<p>Tình trạng: <b><?php echo (!empty($item['quanity_pd']))?"còn hàng" : "hết hàng"; ?></b></p>				
				</div>
				<hr>
				<a href="?c=product&m=detail&id=<?= $item['id']; ?>" class="btn btn-info">Mua ngay</a>
			</div>
		<?php endforeach; ?>
	</section>
	<section>
		<div class="col-md-12" style="background-color:#D9EDF7;color: orange; ">
			<div class="col-md-4">
				<h3>Sách mới cập nhật</h3>
			</div>
		</div>
		<div class="col-md-12">
			<?php foreach ($data['newProduct'] as $key => $item): ?>
			<div class="col-md-3" style="padding: 10px;">
				<img src="<?php echo PATH_IMAGE.$item['image_pd'] ?>" width="90%" height="300">
				<hr>
				<div class="text-left" style="min-height: 130px;">
					<p>Tên Sách: <a href="?c=product&m=detail&id=<?= $item['id']; ?>"><b><?= $item['name_pd']; ?></b></a></p>
					<p>Giá bìa: <b id="price" style="text-decoration: line-through;"><?= number_format($item['price_pd']); ?></b></p>
					<p>Giá sale: <b id="sale"><?= number_format($item['price_pd']-(($item['sale_off']*$item['price_pd'])/100)); ?></b></p>
					<p>Tình trạng: <b><?php echo (!empty($item['quanity_pd']))?"còn hàng" : "hết hàng"; ?></b></p>			
				</div>
				<hr>
				<a href="?c=product&m=detail&id=<?= $item['id']; ?>" class="btn btn-info">Mua ngay</a>
			</div>
		<?php endforeach; ?>
		</div>
	</section>
</div>
<script type="text/javascript">


    $('.left carousel-control').carousel('prev');
    $('.right carousel-control').carousel('next');
    $('#carousel-example-generic').carousel({
	  interval: 2000
	})
    $('#carousel-example-generic').carousel('cycle');

	// hien thong bao
	let url = $(location).attr('search');
	// alert(url);
	let state = 'state';
	let result = url.indexOf(state);
	if (result !== -1) {
		alert('Đăng ký tài khoản thành công');
		window.location.href = '?c=home';
	}
	// alert("chuoi: "+result);
</script>
