<div class="content-wrapper">
	<div class="container-fuild">
		<div class="col-lg-12">
			<h3 class="text-center">Add Categories</h3>
			<a class="btn btn-info" href="?c=categories" title="list categories">List Categories</a>
			<hr>
		</div>
		<?php if(!empty($data['errAdd'])): ?>
			<div class="col-lg-12">
				<ul>
					<?php foreach ($data['errAdd'] as $key => $err): ?>
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
			<form action="?c=categories&m=handleAdd" method="POST" enctype="multipart/form-data">
				<div class="row">
					<div class="col-md-6 .col-md-offset-3">
						<div class="form-group">
							<label for="nameCat">Name Categories</label>
							<input type="text" name="nameCat" class="form-control">			
						</div>
						<button type="submit" name="btnAdd" class="btn btn-default" style="margin: 10px 0px;" >Add</button>		
					</div>
				</div>
			</form>
		</div>		
	</div>
</div>