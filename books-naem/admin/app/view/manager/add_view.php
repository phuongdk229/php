<div class="content-wrapper">
	<div class="container-fuild">
		<div class="col-lg-12">
			<h3 class="text-center">Add Manager</h3>
			<a class="btn btn-info" href="?c=manager" title="list manager">List Manager</a>
			<hr>
		</div>
		<?php if(!empty($data['errAdd'])): ?>
			<div class="col-lg-12">
				<ul>
					<?php foreach ($data['errAdd'] as $key => $err): ?>
						<?php if($err!=''): ?>
						<li style="color: red;">
							<?php echo $err; ?>
						</li>
					<?php endif; ?>
					<?php endforeach; ?>
				</ul>
			</div>
		<?php endif; ?>
		<?php if(!empty($data['state']) && $data['errName'] !==''): ?>
			<div class="col-lg-12">
				<h5 style="color: red;">User name : <b style="color: black;"><?= $data['errName']; ?></b> already exist</h5>
			</div>
		<?php endif; ?>
		<div class="col-lg-12">
			<form action="?c=manager&m=handleAdd" method="POST" enctype="multipart/form-data">
				<div class="row">
					<div class="col-md-6 col-md-offset-3">
						<div class="form-group">
							<label for="nameMan">User Name</label>
							<input type="text" name="nameMan" class="form-control">
						</div>
						<div class="form-group">
							<label for="passMan">Password</label>
							<input type="password" name="passMan" class="form-control">
						</div>						
						<div class="form-group">
							<label for="emailMan">Email</label>
							<input type="email" name="emailMan" class="form-control">
						</div>
						<div class="form-group">
							<button type="submit" name="btnAddMan" class="btn btn-danger" style="margin: 10px 0px;">Add</button>				
						</div>
					</div>
						
				</div>

			</form>
		</div>
	</div>
</div>