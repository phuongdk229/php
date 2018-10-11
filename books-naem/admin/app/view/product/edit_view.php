<div class="content-wrapper">
	<div class="container-fuild">
		<div class="col-lg-12">
			<h3 class="text-center">Edit Product</h3>
			<a class="btn btn-info" href="?c=product" title="list product">List Product</a>
			<hr>
		</div>
		<?php if(!empty($data['errEdit'])): ?>
			<div class="col-lg-12">
				<ul>
					<?php foreach ($data['errEdit'] as $key => $err): ?>
						<?php if($err !== ''): ?>
							<li style="color: red;"><?= $err; ?></li>
						<?php endif; ?>
					<?php endforeach; ?>
				</ul>
			</div>
		<?php endif; ?>
		<?php if(!empty($data['state']) && $data['errName'] !== ''): ?>
			<div class="col-lg-12">
				<h5 style="color: red;">product <b style="color: black;"><?= $data['errName']; ?></b> already exist!</h5>
			</div>
		<?php endif; ?>
		<div class="col-lg-12">
			<form action="?c=product&m=handleEdit&id=<?= $data['inf']['id']; ?>" method="POST" enctype="multipart/form-data">

				<div class="row">
					<div class="col-lg-6">
						<div class="form-group">
							<label for="namePd">Name</label>
							<input type="text" name="namePd" class="form-control" value="<?= $data['inf']['name_pd']; ?>">
						</div>
						<div class="form-group">
							<label>Status</label>
							<select class="form-control" name="statusPd">
								<option value="0" <?php echo ($data['inf']['status_pd']==0)? "selected= 'selected' " :"" ?> >Deactive</option>
								<option value="1" <?php echo ($data['inf']['status_pd']==1)? "selected= 'selected' " :"" ?> >Active</option>
							</select>
						</div> 
						<div class="form-group">
							<label for="slcCat">Categories</label>
							<select class="form-control" name="slcCat">
								<?php foreach ($data['lstCat'] as $key => $val): ?>
								<option value="<?php echo $val['id']; ?>"><?php echo $val['name_cat'] ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="form-group">
							<label for="imagePd">Image</label>
							<input type="file" name="imagePd" class="form-control">
							<img style="width: 200px;height: 200px;" src="<?= PATH_IMAGE.$data['inf']['image_pd']; ?>">
						</div>											
					</div>
					<div class="col-lg-6">
						<div class="form-group">
							<label for="inputPrice">Input Price</label>
							<input type="text" name="inputPrice" class="form-control" value="<?= $data['inf']['price_input']; ?>" >
						</div>						
						<div class="form-group">
							<label for="pricePd">Output Price</label>
							<input type="text" name="pricePd" class="form-control" value="<?= $data['inf']['price_pd']; ?>" >
						</div>
						<div class="form-group">
							<label for="sale_off">Sale Off</label>
							<input type="text" name="sale_off" class="form-control" value="<?= $data['inf']['sale_off']; ?>" >
						</div>						
						<div class="form-group">
							<label for="qtyPd">Quanity</label>
							<input type="number" name="qtyPd" class="form-control" value="<?= $data['inf']['quanity_pd']; ?>">
						</div>
						<div class="form-group">
							<label for="desPd">Description</label>
							<textarea class="form-control" rows="5" name="desPd"><?= $data['inf']['description_pd']; ?></textarea>
						</div>						
					</div>
					<div class="col-lg-6 offset-3">
						<button type="submit" name="btnEdit" class="btn btn-primary btn-block" style="margin: 10px 0px;">Update</button>
					</div>
				</div>

			</form>
		</div>
	</div>
</div>