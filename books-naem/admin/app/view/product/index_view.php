  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Product</a>
        </li>
        <li class="breadcrumb-item active">My Product</li>
      </ol>
      <div class="row">
        <div class="col-md-12">
          <h2 class="text-center">This is list product</h2>
          <a href="?c=product&m=add" title="Add product" class="btn btn-primary pull-right" style="margin-bottom: 5px;">Add + </a>
          <a href="?c=product&m=addNew" class="btn btn-info">
            Change Banner
          </a>
          <div  class="form-inline my-2 my-lg-0 mr-lg-2">
            <input style=" width: 250px; " class="form-control" type="text"  placeholder="search for name product" id="txtSearch" value="<?php echo htmlentities($data['key']); ?>">
              <span class="input-group-append">
                <button class="btn btn-primary" type="button" onclick="searchProduct();" >
                  <i class="fa fa-search"></i>
                </button>
              </span>
          </div>
          <table class="table">
            <thead>
              <tr>
                <th>#</th>
                <th>Name</th>
                <th>Image</th>
                <th>Output Price</th>
                <th>Sale Off</th>
                <th>Quanity</th>
                <th>Status</th>
                <th colspan="2" class="text-center" width="3%">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($data['lsPd'] as $key => $val): ?>
                <tr>
                  <td><?php echo $key +1; ?></td>
                  <td><?php echo $val['name_pd']; ?></td>
                  <td><img width="120" height="120" src="<?php echo PATH_IMAGE.$val['image_pd']; ?>"></td>
                  <td><?php echo number_format($val['price_pd']); ?></td>
                  <td><?php echo number_format($val['sale_off']); ?></td>
                  <td><?php echo $val['quanity_pd']; ?></td>
                  <td><?php echo ($val['status_pd']==1)? 'còn hàng' : 'hết hàng' ; ?></td>
                  <td><a href="?c=product&m=edit&id=<?= $val['id']; ?>" title="Edit" class="btn btn-primary">Edit</a></td>
                  <td>
                    <button onclick="deleteProduct(<?php echo $val['id']; ?>);" type="button" class="btn btn-danger">Delete</button>
                  </td>
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
  function searchProduct(){
    let key = $('#txtSearch').val().trim();
    window.location.href = "?c=product&m=index&key="+key+"&page=1";
  }
  function deleteProduct(idPd){
    // alert(idPd);
    if (idPd !=='') {
      $.ajax({
        url: "?c=product&m=delete",
        type: "POST",
        data: {id:idPd},
        success:function(res){
          res = $.trim(res);
          if (res==='ERR') {
            alert('co loi xay ra');
          }else{
            alert('xoa thanh cong');
            window.location.reload(true);
          }
        }
      });
    }
  }
</script>