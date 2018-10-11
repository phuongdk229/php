<section>
	<div class="row">
		<div class="col-lg-12">
			<h2 class="text-center" style="text-transform: uppercase;">Thông tin khách hàng</h2>
			<hr>
		</div>
		<div class="col-lg-12">
			<div class="col-md-4" style="padding: 5px;">
				<h3>Thông tin khách hàng</h3>
				<hr>
				<div class="info">
				 	<h4 class="bg-danger" style="padding: 10px 5px; text-transform: capitalize; "><b>Tên khách hàng: </b><?= $_SESSION['name_cus']; ?></h4>
					<h4 class="bg-warning" style="padding: 10px 5px; "><b>Email:</b> <?= $_SESSION['email_cus']; ?></h4>
					<h4 class="bg-danger" style="padding: 10px 5px; text-transform: capitalize; "><b>Địa chỉ:</b> <?= $_SESSION['address_cus']; ?></h4>
					<h4 class="bg-warning" style="padding: 10px 5px; "><b>Số điện thoại:</b> <?= $_SESSION['phone_cus']; ?></h4>
					<h4 class="bg-danger" style="padding: 10px 5px; "><b>Xu:</b> <?= $_SESSION['coin']; ?></h4>
					<!-- <button type="submit" class="btn btn-info" id="btnEdit" name="btnEdit">Edit</button> -->
					<a href="?c=customer&m=editCus" class="btn btn-info">Edit</a>
					<a href="?c=customer&m=deleteCus" class="btn btn-primary">Remove</a>
					<a href="?c=home" class="btn btn-success">Quay lại trang chủ</a>	
				</div>
			</div>
			<div class="col-md-4" style="padding: 5px;">
				<h3>Sách đã mua</h3>
				<hr>
				<div class="perfect">
					<?php if(!empty($data['delivered'])): ?>
						<table class="table table-striped">
							<thead>
								<tr>
									<th>Mã sản phẩm</th>
									<th>Tên Sản phẩm</th>
									<th>Số lượng</th>
									<th>Giá sản phẩm</th>
									<th>Tổng tiền</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($data['delivered'] as $key => $item): ?>
									<tr>
										<td><?= $item['idPd']; ?></td>
										<td><?= $item['namePd']; ?></td>
										<td><?= $item['qtyPd']; ?></td>
										<td><?= number_format($item['pricePd']); ?></td>
										<td><?= number_format($item['totalMoney']); ?></td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
						<?php else: ?>
							<p class="text-center">Không có sản phẩm nào</p>
					<?php endif; ?>
				</div>
			</div>
			<div class="col-md-4" style="padding: 5px;">
				<h3>Sách đang chờ xác nhận</h3>
				<hr>
				<div class="order">
					<?php $temp = 0; ?>
					<?php if(!empty($data['order'])): ?>
						<table class="table table-striped">
							<thead>
								<tr>
									<!-- <th>Mã sản phẩm</th> -->
									<th>Tên Sản phẩm</th>
									<th>Số lượng</th>
									<th>Giá sản phẩm</th>
									<th>Tổng tiền</th>
									<th>Active</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($data['order'] as $key => $item): ?>
									<tr>
										
									<!-- 	<td><?= $item['idPd']; ?></td> -->
										<td><?= $item['namePd']; ?></td>
										<td><?= $item['qtyPd']; ?></td>
										<td><?= number_format($item['pricePd']); ?></td>
										<td><?= number_format($item['totalMoney']); ?></td>

										<?php if ($item['idbill'] != $temp): ?>
											<td><a href="?c=customer&m=cancelOder&id=<?= $item['idbill'] ?>" class="btn btn-info">Hủy đơn</a></td>
										<?php endif ?>
										<?php $temp = $item['idbill']; ?>										
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
						<?php else: ?>
							<p class="text-center">Không có sản phẩm nào</p>
					<?php endif; ?>					
				</div>
			</div>
		</div>
	</div>
</section>
