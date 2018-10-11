<div class="content-wrapper">
	<div class="container-fuild">
		<div class="col-lg-12">
			<h3 class="text-center">Add image for slide</h3>
			<a class="btn btn-info" href="?c=product" title="list product">List Product</a>
			<hr>
		</div>
		<?php if(!empty($data['errPic'])): ?>
			<div class="col-lg-12">
				<h5 style="color: red;"><?= $data['errPic']; ?></h5>
			</div>
		<?php endif; ?>
		<?php if(!empty($data['state']) && $data['errName'] !== ''): ?>
			<div class="col-lg-12">
				<h5 style="color: red;">Image <b style="color: black;"><?= $data['errName']; ?></b> already exist!</h5>
			</div>
		<?php endif; ?>			
		<div class="col-lg-12">
				<div class="col-md-6 col-md-offset-3">
					<form action="?c=product&m=handleNew" method="POST" enctype="multipart/form-data">
						<div class="form-group">
							<input type="file" name="imageBan" class="form-control">
						</div>
						<button type="submit" class="btn btn-primary" name="btnSubmit">Upload</button>
						<input type="reset" name="reset" class="btn btn-info" value="Reset">
					</form>
				</div>
		</div>
	</div>
</div>