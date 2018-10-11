<?php if(isset($data['lstLit'])): ?>
<div class="row">
	<section>
	<div class="col-md-12" style="background-color:#D9EDF7;color: orange; height: 50px; ">
		<div class="col-md-6">
			<h3 class="text-justify">Sách <?php echo $data['nameCat']['name_cat']; ?></h3>
		</div>
	</div>
	<div class="col-md-12" style="display: inline;">
			<?php foreach ($data['lstLit'] as $key => $item): ?>
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
</div>	
<?php elseif(isset($data['lstSci'])): ?>
<div class="row">
	<section>
	<div class="col-md-12" style="background-color:#D9EDF7;color: orange; height: 50px; ">
		<div class="col-md-6">
			<h3>Sách <?php echo $data['nameCat']['name_cat']; ?></h3>
		</div>
	</div>
	<div class="col-md-12" style="display: inline;">
		<?php foreach ($data['lstSci'] as $key => $item): ?>
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
</div>
<?php elseif(isset($data['lstSkill'])): ?>
<div class="row">
	<section>
	<div class="col-md-12" style="background-color:#D9EDF7;color: orange; height: 50px; ">
		<div class="col-md-6">
			<h3>Sách <?php echo $data['nameCat']['name_cat']; ?></h3>
		</div>
	</div>
	<div class="col-md-12" style="display: inline;">
		<?php foreach ($data['lstSkill'] as $key => $item): ?>
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
</div>
<?php elseif(isset($data['lstChil'])): ?>
<div class="row">
	<section>
	<div class="col-md-12" style="background-color:#D9EDF7;color: orange; height: 50px; ">
		<div class="col-md-6">
			<h3>Sách <?php echo $data['nameCat']['name_cat']; ?></h3>
		</div>
	</div>
	<div class="col-md-12" style="display: inline;">
		<?php foreach ($data['lstChil'] as $key => $item): ?>
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
</div>
<?php elseif(isset($data['lstTech'])): ?>
<div class="row">
	<section>
	<div class="col-md-12" style="background-color:#D9EDF7;color: orange; height: 50px; ">
		<div class="col-md-6">
			<h3>Sách <?php echo $data['nameCat']['name_cat']; ?></h3>
		</div>
	</div>
	<div class="col-md-12" style="display: inline;">
		<?php foreach ($data['lstTech'] as $key => $item): ?>
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
</div>
<?php endif; ?>
<div class="row">
	<div class="col-lg-6 offset-3">
		<?php echo $data['pageHtml']; ?>
	</div>
</div>