  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Customer</a>
        </li>
        <li class="breadcrumb-item">Order by customer</li>
        <li class="breadcrumb-item active">Detail product order</li>
      </ol>
      <div class="row">
        <div class="col-md-12">
          <h2 class="text-center">List product customer order</h2>
          <?php $sumMoney = 0; ?>
          <table class="table table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>Name</th>
                <th>Quanity</th>
                <th>Price</th>
                <th>Money</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($data['pdOder'] as $key => $val): ?>
                <tr>
                  <td><?php echo $key +1; ?></td>
                  <td><?php echo $val['name_pd']; ?></td>
                  <td><?php echo $val['quanity_pd']; ?></td>
                  <td><?php echo number_format($val['price_pd']); ?></td>
                  <td><?php echo number_format($val['totalMoney']); ?></td>
                </tr>
                <?php $sumMoney += $val['totalMoney'] ?>
              <?php endforeach; ?>
            </tbody>
            <tfoot>
              <tr>
                <td colspan="4"><b>Sum money:</b></td>
                <td ><?= number_format($sumMoney); ?></td>
              </tr>
              <tr>
                  <td colspan="4"><b>Paymet (include:transport): </b></td>
                  <td><?= number_format($data['lstBill']['Payment']); ?></td>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6 col-md-offset-3">
          <a href="?c=customer&m=pdOrder" class="btn btn-primary">Back</a>
        </div>
      </div>
<!--       <div class="row">
        <div class="col-lg-6 offset-3">
          <?php echo $data['pageHtml']; ?>
        </div>
      </div> -->
    </div>
  </div>