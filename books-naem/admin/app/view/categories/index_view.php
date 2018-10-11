  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Categories</a>
        </li>
        <li class="breadcrumb-item active">My Categories</li>
      </ol>
      <div class="row">
        <div class="col-md-12">
          <h2 class="text-center">This is Categories</h2>
          <a href="?c=categories&m=add" title="Add product" class="btn btn-primary pull-right" style="margin-bottom: 5px;">Add + </a>
          <div class="form-inline my-2 my-lg-0 mr-lg-2">
            <input style=" width: 250px; " class="form-control" type="text"  placeholder="search for name categories" id="txtSearch" value="<?php echo htmlentities($data['key']); ?>">
            <span class="input-group-append">
              <button class="btn btn-primary" type="button" onclick="searchCategories();" >
                <i class="fa fa-search"></i>
              </button>
            </span>
          </div>
          <table class="table">
            <thead>
              <tr>
                <th>#</th>
                <th>Name</th>
                <th colspan="2" class="text-center" width="3%">Action</th>             
              </tr>
            </thead>
            <tbody>
              <?php foreach ($data['lsCat'] as $key => $val): ?>
                <tr>
                  <td><?php echo $key +1; ?></td>
                  <td><?php echo $val['name_cat']; ?></td>
                  <td><a href="?c=categories&m=edit&id=<?= $val['id']; ?>" title="Edit" class="btn btn-primary">Edit</a></td>
                  <td>
                    <button onclick="deleteCategories(<?php echo $val['id']; ?>);" type="button" class="btn btn-danger">Delete</button>
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
  function searchCategories(){
    let key = $('#txtSearch').val().trim();
    window.location.href = "?c=categories&m=index&key="+key+"&page=1";
  }
  function deleteCategories(idCat){
    // alert(idCat);
    if (idCat !=='') {
      $.ajax({
        url: "?c=categories&m=delete",
        type: "POST",
        data: {id:idCat},
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