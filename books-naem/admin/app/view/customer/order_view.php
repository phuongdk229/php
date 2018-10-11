<div class="content-wrapper">
	<div class="container-fluid">
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="#">Customer</a>
			</li>
			<li class="breadcrumb-item active">
				Order by customer
			</li>
		</ol>
		<div class="row">
			<div class="col-md-12">
				<h2 class="text-center">List customer order</h2>
			</div>
			<div class="col-lg-12">
				<table class="table">
					<thead>
						<tr>
							<th>#</th>
							<th>Name</th>
							<th>Address</th>
							<th>City</th>
							<th>District</th>
							<th>Payment</th>
							<th>Date order</th>
							<th>endow</th>
							<th colspan="3">Active</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($data['infoCus'] as $key => $cus): ?>
						<tr>
							<td style=""><?= $key + 1; ?></td>
							<td><?= $cus['name_cus']; ?></td>
							<td><?= $cus['address_cus']; ?></td>
							<?php foreach ($data['lstCity'] as $key => $item): ?>
								<?php if ($cus['id_city'] == $item['id']): ?>
									<td><?= $item['name_city']; ?></td>
								<?php endif; ?>
							<?php endforeach; ?>
							<?php foreach ($data['lstDis'] as $key => $item): ?>
								<?php if ($cus['id_district'] == $item['id']): ?>
									<td><?= $item['name_dis']; ?></td>
								<?php endif; ?>
							<?php endforeach; ?>
							<td><?= $cus['Payment']; ?></td>
							<td><?= $cus['date_order']; ?></td> 
							<td><?=$cus['note'] ?></td>
							<td><a href="?c=customer&m=detailBill&id=<?= $cus['id']; ?>" class="btn btn-info">Detail</a></td>
							<td><a href="?c=customer&m=perfectOrder&id=<?= $cus['id']; ?>" class="btn btn-primary">Perfect</a></td>
							<td><a href="?c=customer&m=failOrder&id=<?= $cus['id']; ?>" class="btn btn-info">Fail</a></td>						
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>				
			</div>
		</div>	
		<div class="row">
			<div class="col-lg-6 offset-3">
				<?php echo $data['pageHtml']; ?>
			</div>
		</div>	
	</div>
</div>
<script type="text/javascript">
	let url = $(location).attr('search');
	// alert(url);
	let state1 = 'success';
	let state2 = 'err';
	let result1 = url.indexOf(state1);
	let result2 = url.indexOf(state2);
	if (result2 !== -1) {
		alert('Xảy ra lỗi. Vui lòng kiểm tra lại thông tin');
		window.location.href = '?c=customer&m=pdOrder';
	}
	if (result1 !== -1) {
		alert('Xac nhận đơn hàng ');
		window.location.href = '?c=customer&m=pdOrder';
	}	

</script>