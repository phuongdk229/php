<div class="content-wrapper">
	<div class="container-fuild">
		<div class="col-lg-12">
			<h3 class="text-center">Add Product</h3>
			<a class="btn btn-info" href="?c=product" title="list product">List Product</a>
			<hr>
		</div>
		<?php if(!empty($data['errAdd'])): ?>
			<div class="col-lg-12">
				<ul>
					<?php foreach ($data['errAdd'] as $key => $err): ?>
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
			<form action="?c=product&m=handleAdd" method="POST" enctype="multipart/form-data">

				<div class="row">
					<div class="col-lg-6">
						<div class="form-group">
							<label for="namePd">Name</label>
							<input type="text" name="namePd" class="form-control">
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
						</div>
						<div class="form-group">
							<label for="inputPrice">Input Price</label>
							<input type="text" name="inputPrice" class="form-control">
						</div>						
						<div class="form-group">
							<label for="pricePd">Output Price</label>
							<input type="text" name="pricePd" class="form-control">
						</div>																	
					</div>
					<div class="col-lg-6">

						<div class="form-group">
							<label for="sale_off">Sale Off</label>
							<input type="text" name="sale_off" class="form-control">
						</div>
						<div class="form-group">
							<label for="qtyPd">Quanity</label>
							<input type="number" name="qtyPd" class="form-control">
						</div>
						<div class="form-group">
							<label for="desPd">Description</label>
							<textarea class="form-control" rows="5" name="desPd"></textarea>
						</div>						
					</div>
					<div class="col-lg-6 offset-3">
						<button type="submit" name="btnAdd" class="btn btn-primary btn-block" style="margin: 10px 0px;">Add</button>
					</div>
				</div>

			</form>
		</div>
	</div>
</div>