<!DOCTYPE html>
<html lang="en">
<head>
	<title>Trang chu</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<link rel="stylesheet" type="text/css" href="public/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="public/css/bootstrap-theme.min.css">
	<!-- <link rel="stylesheet" type="text/css" href="public/css/slider.css"> -->
<!-- 	<link rel="stylesheet" type="text/css" href="public/js/bootsrap.min.js"> -->
	
	<script type="text/javascript" src="public/js/jquery-3.3.1.js"></script>
	<script type="text/javascript" src="public/js/bootstrap.min.js"></script>
	<!-- <script language="javascript" src="public/js/popper.min.js"></script> -->
<!-- 	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script> -->
<!-- 	<script language="javascript" src="public/js/slider.js"></script> -->
	<style type="text/css">
		a:hover{
			text-decoration: none;
			/*color:#4A708B;*/
			color: orange;
		}
		ul li#contact ul li{
			/*display: none;*/
			list-style: none;
			/*border: 1px solid black;*/
		}
/*.multi-item-carousel{
  .carousel-inner{
    > .item{
      transition: 500ms ease-in-out left;
    }
    .active{
      &.left{
        left:-33%;
      }
      &.right{
        left:33%;
      }
    }
    .next{
      left: 33%;

    }
    .prev{
      left: -33%;
    }
    @media all and (transform-3d), (-webkit-transform-3d) {
      > .item{
        // use your favourite prefixer here
        transition: 500ms ease-in-out left;
        transition: 500ms ease-in-out all;
        backface-visibility: visible;
        transform: none!important;
      }
    }
  }
}*/
	</style>

</head>
<body>
	<div class="wrapper-fluid">
		<div class="container">
			<header>
				<div class="row" style="background-color: #D9EDF7; color: orange;">
					<div class="col-md-12">
						<div class="col-xs-6 col-sm-4">Call: 0169460313*</div>
						<div class="col-xs-6 col-sm-4">Free shipping on orders over 500.000</div>
					</div>
				</div>
			</header>
			<nav class="navbar navbar-preview fixed-top" style="margin: 0px;">
				<div class="row" role="navigation" style="background-color: #FFE4B5;">
			      <div class="container">
			        <div class="navbar-header">
<!-- 			          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
			            <span class="sr-only">Toggle navigation</span>
			            <span class="icon-bar"></span>
			            <span class="icon-bar"></span>
			            <span class="icon-bar"></span>
			          </button> -->
			          <a class="navbar-brand" href="?c=home">Pbook store</a>
			        </div>
			        <div class="collapse navbar-collapse">
			          <ul class="nav navbar-nav">
			            <li class="active"><a href="?c=home">Home</a></li>
			            <li class="dropdown">
			              <a href="?c=home" class="dropdown-toggle" data-toggle="dropdown">Danh mục sách <span class="caret"></span></a>
			              <ul class="dropdown-menu">
			              	<li><a href="?c=product&m=literary" style="color:#2A64A2;">Văn Học</a></li>
			              	<li><a href="?c=product&m=science" style="color:#2A64A2;">Khoa học tự nhiên và nhân văn</a></li>
			              	<li><a href="?c=product&m=skill" style="color:#2A64A2;">Kỹ năng sống đẹp</a></li>
			              	<li><a href="?c=product&m=children" style="color:#2A64A2;">Thiếu Nhi</a></li>
			              	<li><a href="?c=product&m=technology" style="color:#2A64A2;">Công nghệ thông tin</a></li>
			              </ul>
			            </li>            
			            <?php if(!isset($_SESSION['id_cus'])): ?>
			            	<li class="dropdown" id="contact">
			            		<a href="#" class="dropdown-toggle" data-toggle="dropdown">Contact <span class="caret"></span></a>
			            		<ul class="dropdown-menu" id="login" style="background-color: #EEEEEE;">
			            			<li>
			            				<form style="width: 200px; padding: 5px;" action="?c=login&m=handleOnMenu" method="POST">
				            				<input type="text" name="txtEmail" placeholder="Nhập tài khoản email" class="form-control">
				            				<br>
				            				<input type="password" name="txtPass" placeholder="Nhập  password" class="form-control">
				            				<br>
				            				<button type="submit" class="btn btn-primary"
				            				name="btnSubmit">Đăng nhập</button>
				            				<a href="?c=customer&m=addCustomer" class="btn btn-info">Đăng ký</a>
			            				</form>
			            			</li>
			            		</ul>
			            	</li>
			            	<?php else: ?>
			            		<li class="dropdown">
			            			<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $_SESSION['name_cus']; ?><span class="caret"></span></a>
			            			<ul class="dropdown-menu" >
			            				<li>
			            					<a href="?c=customer&m=infoCus" style="color:#2A64A2;">Thông tin cá nhân</a>
			            				</li>
			            				<li><a href="?c=login&m=logout" style="color:#2A64A2;">Đăng Xuất</a></li>
			            			</ul>
			            		</li>
			            <?php endif; ?>
			            <li class="active"><a href="#" >Call: 01694603139</a></li>
			            <li class="active"><a href="#" >Email: pbookstore229@gmail.com</a></li>
			            <!-- search -->
			            <li>
				            <div class="input-group">
				              <input class="form-control" id="searchProducts" type="text" placeholder="Search for name book.." style="margin-top: 10px;">
				              <div id="resultSearch" style="position: absolute; min-width: 220px; max-height: 300px;display: none; top: 45px;background-color: white; z-index: 1;left: 0;"></div>
				            </div>
			            </li>
			            <!-- cart -->
			            <li style="width: 50px;">
			            	<a  href="?c=cart&m=index" style="margin: 0px;padding: 15px 5px;">
			            	 <span class="glyphicon glyphicon-shopping-cart"></span>
			            	 <?php if(isset($_SESSION['cartPd'])): ?>
			            	 	<span class="badge badge-danger" style="top: 0px; left: -10px;"><?= count($_SESSION['cartPd']) ?></span>
			            	 <?php endif; ?>	
			            	</a>
			            </li>
			          </ul>
			        </div><!--/.nav-collapse -->
			      </div>
			    </div>
			</nav>

			<main>

<script type="text/javascript">
	$(function(){
		$('#searchProducts').keyup(function(){
			let keyword = $(this).val().trim();
			// alert(keyword);
			if (keyword.length >2) {
				$.ajax({
					url: "?c=product&m=search",
					type: "POST",
					data: {key: keyword},
					success:function(res){
						$('#resultSearch').html(res).show();
						// alert(res);
					}
				})
			}
			else{
				$('#resultSearch').hide();
			}
		})
	})



</script>
