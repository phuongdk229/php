
<section>
		<div class="row" style="background-color:#D9EDF7;color: orange; ">
			<div class="col-md-4">
				<h3>Giỏ hàng (có <b><?php echo (isset($_SESSION['cartPd']))? count($_SESSION['cartPd']) : 0; ?></b> sản phẩm)</h3>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<form action="?c=cart&m=update" method="POST">
					<table class="table">
						<thead>
							<tr>
								<th>#</th>
								<th>Name</th>
								<th>Image</th>
								<th>Quanity</th>
								<th>Price</th>
								<th>Money</th>
								<th width="5%">Delete</th>
							</tr>
						</thead>
						<tbody>
							<?php $totalMoney =0; ?>
							<?php foreach ($data['cart'] as $key => $item): ?>
								<tr>
									<td><?= $key; ?></td>
									<td><?php echo $item['namePd']; ?></td>
									<td>
										<img src="<?php echo PATH_IMAGE.$item['imagePd']; ?>" width="100" height="100">
									</td>
									<td><input onchange="updateCart('<?= $item['id'] ?>',this);"type="number" name="qty[<?= $item['id']; ?>]" value="<?= $item['qtyPd']; ?>"></td>
									<td><?= number_format($item['price']); ?></td>
									<td>
										<?= number_format($item['qtyPd']*$item['price']); ?>
									</td>
									<td>
										<a href="?c=cart&m=delete&id=<?= $item['id']; ?>" class="btn btn-danger">remove</a>
									</td>
								</tr>
								<?php  $totalMoney +=($item['qtyPd']*$item['price']); ?>
							<?php endforeach; ?>
						</tbody>
						<tfoot>
							<tr>
								<td>Total Money: </td>
								<td colspan="4"></td>
								<td colspan="2" id="totalMoney"><?= number_format($totalMoney); ?></td>
							</tr>
							<tr>
<!-- 								<td>
									<button type="submit" name="btnSubmit" class="btn btn-primary">Update Cart</button>
								</td> -->
								<td>
									<a href="?c=cart&m=remove" class="btn btn-danger">Remove All</a>
								</td>
								<td>
									<a href="?c=home" class="btn btn-primary">Shopping</a>
								</td>
								<td>
									<a href="?c=customer&m=register" class="btn btn-danger">Pay</a>
								</td>
							</tr>
						</tfoot>
					</table>
				</form>
			</div>
		</div>		
</section>
<script type="text/javascript">
	function updateCart(id,obj) {
		let qty = $(obj).val().trim();
		// alert(qty);
		if (qty > 0 && qty < 10) {
			$.ajax({
				url: "?c=cart&m=ajax_cart",
				type: "POST",
				data: {id:id,qty:qty},
				success:function(res){
					let dbObj = $.parseJSON(res);
					$(obj).parent().next().next().html(dbObj.money);
					$('#totalMoney').html(dbObj.totalMoney);
				}
			});
		}else{
			alert('Số lượng sản phẩm không được quá 10 và nhỏ hơn 1');
		}
	}
</script>