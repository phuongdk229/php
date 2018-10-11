  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Manager</a>
        </li>
        <li class="breadcrumb-item active">My Manager</li>
      </ol>
      <div class="row">
        <div class="col-md-12">
          <h2 class="text-center">This is list Manager</h2>
          <a href="?c=manager&m=add" title="Add manager" class="btn btn-primary pull-right" style="margin-bottom: 5px;">Add + </a>
            <div  class="form-inline my-2 my-lg-0 mr-lg-2">
              <input style=" width: 250px; " class="form-control" type="text"  placeholder="search for name manager" id="txtSearch" value="<?php echo htmlentities($data['key']); ?>">
              <span class="input-group-append">
                <button class="btn btn-primary" type="button" onclick="searchProcduct();" >
                  <i class="fa fa-search"></i>
                </button>
              </span>
            </div>          
          <table class="table">
            <thead>
              <tr>
                <th>#</th>
                <th>User Name</th>
                <th>Email</th>
                <th>Status</th>
                <th>Role</th>
                <th colspan="2" class="text-center" width="3%">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($data['lsMan'] as $key => $val): ?>
                <tr>
                  <td><?php echo $key +1; ?></td>
                  <td><?php echo $val['username']; ?></td>
                  <td><?php echo $val['email']; ?></td>                  
                  <td><?php echo ($val['status']==1) ?'Active' : 'Disactive'; ?></td>
                  <td><?php echo ($val['role']==-1)?'Administrator':'staff'; ?></td>
                  <td><a href="?c=manager&m=edit&id=<?= $val['id']; ?>" title="Edit" class="btn btn-primary">Edit</a></td>
                  <td>
                    <button onclick="deleteManager(<?php echo $val['id']; ?>);" type="button" class="btn btn-danger">Delete</button>
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
  function searchManager(){
    let key = $('#txtSearch').val().trim();
    window.location.href = "?c=manager&m=index&key="+key+"&page=1";
  }
  function deleteManager(id){
    // alert(idPd);
    if (idPd !=='') {
      $.ajax({
        url: "?c=manager&m=delete",
        type: "POST",
        data: {id:id},
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