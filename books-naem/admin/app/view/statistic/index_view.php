  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Statistic</a>
        </li>
        <li class="breadcrumb-item active">My Statistic</li>
      </ol>
      <div class="row">
        <div class="col-md-12">
          <h2 class="text-center">STATISTIC</h2>
        </div>
        <div class="col-md-12">
          <?php foreach ($data['err'] as $key => $err): ?>
              <ul>
                <?php if (!empty($err)): ?>
                  <li style="color: red;"><?= $err; ?></li>
                <?php endif ?>
              </ul>
          <?php endforeach; ?>          
        </div>

      </div>
      <hr>
      <div class="row">
        <div class="col-md-12">
          <form action="?c=statistic&m=handle" method="POST" enctype="multipart/ form-data">
          <div class="row">
            <div class="col-md-3">
              <select id="item" class="form-control" name="item" style="margin-top: 32px;">
                  <option>Chọn loại báo cáo</option>
                  <option value="1" id="profit">Báo cáo doanh thu, lợi nhuận</option>
                  <option value="2">Báo cáo số lượng tồn</option>
                  <option value="3">Báo cáo sách khách hàng</option>
                </select>
            </div>
            <div class="col-md-3">
              <label for="txtfrom"><b>Từ ngày</b></label>
              <input type="date" name="txtfrom" class="form-control" id="txtfrom">
            </div>
            <div class="col-md-3">
              <label for="txtTo"><b>Đến ngày</b></label>
                <input type="date" name="txtTo" class="form-control" id="txtTo">
            </div>
            <div class="col-md-3">
              <button type="submit" class="btn btn-primary" name="btnSubmit" id="btnSubmit" style="margin-top: 32px;">Thống kê</button>
            </div> 
          </div>    
          </form>          
        </div>

      </div>
      <hr>
      <!-- thong ke doanh thu loi nhuan -->
      <?php if (isset($data['profit']) && !empty($data['profit'])): ?>
      <div class="row">
        <div class="col-md-6 offset-3">
          <h3 class="text-justify">Báo cáo doanh thu, lợi nhuận</h3>
        </div>        
        <table class="table table-hover">
          <?php $revenue = 0; ?>
          <?php $profit = 0; ?>
          <?php $sumPriceInput = 0; ?>
          <thead>
            <tr>
              <th>#</th>
              <th>Name product</th>
              <th>Quanity Sell</th>
              <th>Price input</th>
              <th>Price output</th>
              <th>TotalMoney</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($data['profit'] as $key => $item): ?>
              <tr>
                <td><?= $key+1 ?></td>
                <td><?= $item['name_pd']; ?></td>
                <td><?= $item['quanity_pd']; ?></td>
                <td><?= number_format($item['price_input']); ?></td>
                <td><?= number_format($item['price_pd']); ?></td>
                <td><?= number_format($item['totalMoney']); ?></td>
              </tr>
              <?php $revenue += $item['totalMoney'] ?>
              <?php $sumPriceInput += ($item['quanity_pd']*$item['price_input']) ?>
            <?php endforeach ?>
            <?php $profit = $revenue - $sumPriceInput ?>
          </tbody>
          <tfoot>
            <tr>
              <td colspan="3"><b>Lợi nhuận</b></td>
              <td><?= number_format($profit); ?></td>
              <td><b>Doanh thu</b></td>
              <td><?= number_format($revenue); ?></td>
            </tr>
            <tr>
              <td colspan="6"><a href="app/view/statistic/outFile_view.php" class="btn btn-info">Xuất BC</a></td>
            </tr>            
          </tfoot>
        </table>       
      </div>
      <?php endif; ?>
      <!-- thong ke hang ton -->
      <?php if (isset($data['inventory']) && !empty($data['inventory'])): ?>     
      <div class="row">
        <div class="col-md-6 offset-3">
          <h3 class="text-justify">Báo cáo hàng tồn</h3>
        </div>        
        <table class="table table-hover">
          <thead>
            <tr>
              <th>#</th>
              <th>Name product</th>
              <th>Quanity input</th>
              <th>Quanity output</th>
              <th>Price input</th>
              <th>Price output</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($data['inventory'] as $key => $item): ?>
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
          <tfoot>
            <tr>
              <td colspan="6"><a href="app/view/statistic/outFile_view.php" class="btn btn-info">Xuất BC</a></td>
            </tr>            
          </tfoot>
        </table>
      </div>
      <?php endif; ?>
      <!-- thong ke khach hang -->
      <?php if (isset($data['customer']) && !empty($data['customer'])): ?>     
      <div class="row">
        <div class="col-md-6 offset-3">
          <h3 class="text-justify">Báo cáo khách hàng</h3>
        </div>        
        <table class="table table-hover">
          <thead>
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Email</th>
              <th>Address</th>
              <th>Phone</th>
              <th>Coin</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($data['customer'] as $key => $item): ?>
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
              <td colspan="6"><a href="app/view/statistic/outFile_view.php" class="btn btn-info">Xuất BC</a></td>
            </tr>
          </tfoot>
        </table>
      </div>
      <?php endif; ?>            
    </div>
  </div>
<!--   <script type="text/javascript">
    var statistic = $('#item').val();
    var datefrom = $('#txtfrom').val();
    var dateto = $('#txtTo').val();
    $('#btnSubmit').click(function(){
      alert(datefrom);
    });
  </script> -->
