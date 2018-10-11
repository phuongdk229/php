<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<title>Out File</title>
	<style type="text/css">
		*{
			padding: 0px;
			margin: 0px;
		}
		.container{
			width: 980px;
			margin: 0px auto;
			padding: 5px 0px;
		}
		.head{
			width: 50%;
			/*margin: 0px auto;*/
			float: right;
		}
		.clear{
			clear: both;
		}
		.title{
			width: 50%;
			margin: 0px auto;
			text-align: center;
			
		}
		.title h2{
			text-transform: uppercase;
		}
		.tableData{
			width: 80%;
			margin: 0px auto;
		}
		.tableData table{
			width: 100%;
			border:1px solid #CFCFCF;
		}
	</style>
</head>
<body>
	<!-- onload="window.print();" -->
	<div class="container">
		<div class="head">
			<div class="name-shop">
				<h4>Pbook store</h4>
				<p>Address: 31, Phan Đình Giót, Thanh Xuân, Hà Nội</p>
			</div>
		</div>
		<div class="clear"></div>
		<br>
		<?php if (isset($_SESSION['profit'])&& !empty($_SESSION['profit'])): ?>
		<div class="title">
			<h2>Báo cáo Doanh thu lợi nhuận</h2>
			<p>-----------o0o-----------</p>
		</div>
		<br>
		<div class="tableData">
			<table border="1" cellpadding="0" cellspacing="0">
		        <?php $revenue = 0; ?>
		        <?php $profit = 0; ?>
		        <?php $sumPriceInput = 0; ?>
				<thead>
					<tr>
						<th>STT</th>
						<th>Tên sản phẩm</th>
						<th>Số lượng</th>
						<th>Giá nhập</th>
						<th>Giá bán</th>
						<th>Tổng tiền</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($_SESSION['profit'] as $key => $pd):?>
						<tr>
							<td><?= $key +1 ?></td>
							<td><?= $pd['name_pd'] ?></td>
							<td><?= $pd['quanity_pd'] ?></td>
							<td><?= number_format($pd['price_input']) ?></td>
							<td><?= number_format($pd['price_pd']) ?></td>
							<td><?= number_format($pd['totalMoney']) ?></td>
						</tr>
		              <?php $revenue += $pd['totalMoney'] ?>
		              <?php $sumPriceInput += ($pd['quanity_pd']*$pd['price_input']) ?>		
					<?php endforeach; ?>
					<?php $profit = $revenue - $sumPriceInput ?>
				</tbody>
				<tfoot>
					<tr>
			            <td colspan="3"><b>Lợi nhuận</b></td>
			            <td><?= number_format($profit); ?></td>
			            <td><b>Doanh thu</b></td>
			            <td><?= number_format($revenue); ?></td>
	            	</tr>					
				</tfoot>
			</table>
		</div>
		<?php endif; ?>
		<?php if (isset($_SESSION['inventory'])&& !empty($_SESSION['inventory'])): ?>
		<div class="title">
			<h2>Báo cáo số lượng tồn</h2>
			<p>-----------o0o-----------</p>
		</div>
		<br>
		<div class="tableData">
			<table border="1" cellpadding="0" cellspacing="0">
			<thead>
	            <tr>
	              <th>#</th>
	              <th>Tên Sách</th>
	              <th>Số lượng nhập</th>
	              <th>Số lượng bán</th>
	              <th>Giá nhập</th>
	              <th>Giá bán</th>
	            </tr>
          	</thead>
          	<tbody>
	            <?php foreach ($_SESSION['inventory'] as $key => $item): ?>
	              <tr>
	                <td><?= $key+1 ?></td>
	                <td><?= $item['name_pd']; ?></td>
	                <td><?= $item['quanity_pd']; ?></td>
	                <td><?= $item['quanity_sell']; ?></td>
	                <td><?= number_format($item['price_input']); ?></td>
	                <td><?= number_format($item['price_pd']); ?></td>
	              </tr>
	            <?php endforeach ?>
          	</tbody>
			</table>
		</div>
		<?php endif; ?>
		<?php if (isset($_SESSION['customer'])&& !empty($_SESSION['customer'])): ?>
		<div class="title">
			<h2>Báo cáo Khách hàng</h2>
			<p>-----------o0o-----------</p>
		</div>
		<br>
		<div class="tableData">
			<table border="1" cellpadding="0" cellspacing="0">
				<thead>
		            <tr>
		              <th>#</th>
		              <th>Tên khách hàng</th>
		              <th>Email</th>
		              <th>Địa chỉ</th>
		              <th>Số điện thoại</th>
		              <th>Số Xu</th>
		            </tr>
          		</thead>
          		<tbody>
		            <?php foreach ($_SESSION['customer'] as $key => $item): ?>
		              <tr>
		                <td><?= $key+1 ?></td>
		                <td><?= $item['name_cus']; ?></td>
		                <td><?= $item['email_cus']; ?></td>
		                <td><?= $item['address_cus']; ?></td>
		                <td><?= $item['phone_cus']; ?></td>
		                <td><?= $item['coin']; ?></td>
		              </tr>
		            <?php endforeach ?>
          		</tbody>
          		<tfoot>
          			<tr>
          				<td colspan="5"><b>Tổng số khách hàng</b></td>
          				<td ><?= count($_SESSION['customer']) ?></td>
          			</tr>
          		</tfoot>
			</table>
		</div>
		<?php endif; ?>				
	</div>
</body>
</html>