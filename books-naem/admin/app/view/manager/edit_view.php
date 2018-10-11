<div class="content-wrapper">
	<div class="container-fuild">
		<div class="col-lg-12">
			<h3 class="text-center">Edit Manager</h3>
			<a class="btn btn-info" href="?c=manager" title="list manager">List Manager</a>
			<hr>
		</div>
		<?php if(!empty($data['errEdit'])): ?>
			<div class="col-lg-12">
				<ul>
					<?php foreach ($data['errEdit'] as $key => $err): ?>
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
			<form action="?c=manager&m=handleEdit&id=<?= $data['infMan']['id']?>" method="POST" enctype="multipart/form-data">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="nameMan">User Name</label>
							<input type="text" name="nameMan" class="form-control" value="<?= $data['infMan']['username'];?>" >
						</div>						
						<div class="form-group">
							<label for="emailMan">Email</label>
							<input type="email" name="emailMan" class="form-control" value="<?= $data['infMan']['email']; ?>" >
						</div>
						<div class="form-group">
							<button type="submit" name="btnEditMan" class="btn btn-danger" style="margin: 10px 0px;">Update</button>				
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Status</label>
							<select class="form-control" name="statusMan" >
								<option value="0" <?php echo ($data['infMan']['status'] == 0)? "selected= 'selected' ":"" ?> >Deactive</option>
								<option value="1" <?php echo ($data['infMan']['status'] == 1)? "selected= 'selected' ":"" ?> >Active</option></select>
						</div>
						<div class="form-group">
							<label for="roleMan">Role</label>
							<select class="form-control" name="roleMan">
								<option value="-1" <?php echo ($data['infMan']['role']== -1)? "selected= 'selected' ": "" ?> >Administrator</option>
								<option value="0" <?php echo ($data['infMan']['role']== 0)? "selected= 'selected' ": "" ?> >Staff</option>
							</select>
						</div>
					</div>
						
				</div>

			</form>
		</div>
	</div>
</div>