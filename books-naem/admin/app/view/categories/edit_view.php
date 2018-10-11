<div class="content-wrapper">
	<div class="container-fuild">
		<div class="col-lg-12">
			<h3 class="text-center">Edit Categories</h3>
			<a class="btn btn-info" href="?c=categories" title="list categories">List Categories</a>
			<hr>
		</div>
		<?php if(!empty($data['errEdit'])): ?>
			<div class="col-lg-12">
				<ul>
					<?php foreach ($data['errEdit'] as $key => $err): ?>
						<?php if (!empty($err)): ?>
							<li style="color: red;" ><?= $err; ?></li>
						<?php endif; ?>
					<?php endforeach; ?>
				</ul>
			</div>
		<?php endif; ?>
		<?php if(!empty($data['errName']) && !empty($data['state'])): ?>
			<div class="col-lg-12">
					<h5 style="color: red;">Categories <b style="color: black;"><?= $data['errName']; ?></b> already exist!</h5>
			</div>
		<?php endif; ?>
		<div class="col-lg-12">
			<form action="?c=categories&m=handleEdit&id=<?= $data['info']['id']; ?>" method="POST" enctype="multipart/form-data">
				<div class="row">
					<div class="col-md-6 .col-md-offset-3">
						<div class="form-group">
							<label for="nameCat">Name Categories</label>
							<input type="text" name="nameCat" class="form-control" value="<?= $data['info']['name_cat']; ?>">			
						</div>
						<div class="radio" style="margin-top: 10px;">
							<label for="rShow">show</label>
							<input type="radio" name="rStatus" value="1" <?php if($data['info']['status']==1):?>checked <?php endif;?> >
							<label for="rHidden">Hidden</label>
							<input type="radio" name="rStatus" value="0" <?php if($data['info']['status']==0):?>checked <?php endif;?> >
						</div>
						<button type="submit" name="btnEdit" class="btn btn-default" style="margin: 10px 0px;" >Upload</button>		
					</div>
				</div>
			</form>
		</div>		
	</div>
</div>