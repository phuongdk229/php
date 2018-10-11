<div class="content-wrapper">
	<div class="container-fluid">
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="#">Customer</a>
			</li>
			<li class="breadcrumb-iyem active">My Customer</li>
		</ol>
      <div class="row">
        <div class="col-md-6 offset-3">
          <h2 class="text-center">MY CUSTOMER</h2>
        </div>
      </div>
      <hr>
      <div class="row">
      	<table class="table table-bordered">
      		<thead>
      			<tr>
      				<th>#</th>
      				<th>Name Product</th>
      				<th>Name Customer</th>
      				<th>Content comment</th>
      				<th>Active</th>
      			</tr>
      		</thead>
      		<tbody>
      			<?php foreach ($data['comment'] as $key => $item): ?>
      				<tr>
      					<?php foreach ($data['namePro'] as $key => $pd): ?>
      						<?php if ($pd['id'] == $item['product_id']): ?>
      							<td><?= $pd['name_pd']?></td>
      						<?php endif; ?>
      					<?php endforeach; ?>
      					<td><?= $item['name_cus']; ?></td>
      					<td><?= $item['content']; ?></td>
      					<td><a href="#" class="btn btn-primary">Ẩn</a></td>
      				</tr>
      			<?php endforeach; ?>
      			<tr></tr>
      		</tbody>
      	</table>
      </div>		
	</div>
</div>