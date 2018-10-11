<div class="content-wrapper">
	<div class="container-fluid">
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="#">Customer</a>
			</li>
			<li class="breadcrumb-item active"> My Customer</li>
		</ol>
		<div class="row">
			<div class="col-md-12">
				<h2 class="text-center">List Infomation Customer</h2>
            	<div  class="form-inline my-2 my-lg-0 mr-lg-2">
	              	<input style=" width: 250px; " class="form-control" type="text"  placeholder="search for name customer" id="txtSearch" value="<?php echo htmlentities($data['key']); ?>">
	              	<span class="input-group-append">
	                	<button class="btn btn-primary" type="button" onclick="searchCustomer();" >
	                  		<i class="fa fa-search"></i>
	                	</button>
	              	</span>
            	</div>
          <table class="table">
			</div>
			<div class="col-md-12">
				<table class="table">
					<thead>
						<tr>
							<th>#</th>
							<th>Email</th>
							<th>Name</th>
							<th>Address</th>
							<th>Phone</th>
							<th>Coin</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($data['infoCus'] as $key => $item): ?>
							<tr>
								<td><?= $key+1; ?></td>
								<td><?= $item['email_cus'];?></td>
								<td><?= $item['name_cus']; ?></td>
								<td><?= $item['address_cus']; ?></td>
								<td><?= $item['phone_cus']; ?></td>
								<td><?= $item['coin']; ?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-6 offset-3">
				<?php echo $data['pageHtml'] ?>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	function searchCustomer(){
    	let key = $('#txtSearch').val().trim();
    	window.location.href = "?c=customer&m=infoCus&key="+key+"&page=1";
 	}	
</script>