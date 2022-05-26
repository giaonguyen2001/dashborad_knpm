<?php
	require('top.inc.php');
	$categories = '';
	$msg = '';
	if(isset($_GET['id']) && $_GET['id'] != ''){
		$id = get_safe_value($con, $_GET['id']);
		$res = mysqli_query($con, "select * from DanhMuc where maDanhMuc='$id'");
		$check = mysqli_num_rows($res);
		if($check > 0){
			$row = mysqli_fetch_assoc($res);
			$categories = $row['maDanhMuc'];
		}else{
			header('location:categories.php');
			die();
		}
	}

	if(isset($_POST['submit'])){
		$categories = get_safe_value($con,$_POST['categories']);
		$res = mysqli_query($con,"select * from DanhMuc where maDanhMuc='$categories'");
		$check= mysqli_num_rows($res);
		if($check>0){
			if(isset($_GET['id']) && $_GET['id']!=''){
				$getData=mysqli_fetch_assoc($res);
				if($id==$getData['id']){
				
				}else{
					$msg="Da ton tai";
				}
			}else{
				$msg="Da ton tai";
			}
		}
		
		if($msg == ''){
			if(isset($_GET['id']) && $_GET['id']!=''){
				mysqli_query($con,"update DanhMuc set tenDanhMuc='$categories' where maDanhMuc='$id'");
			}else{
				mysqli_query($con,"insert into DanhMuc(tenDanhMuc) values('$categories')");
			}
			header('location:categories.php');
			die();
		}
	}
?>
<div class="content pb-0">
            <div class="animated fadeIn">
               <div class="row">
                  <div class="col-lg-12">
                     <div class="card">
                        <div class="card-header"><strong>Danh Mục</strong></div>
                        <form method="post">
							<div class="card-body card-block">
							   <div class="form-group">
									<label for="categories" class=" form-control-label"></label>
									<input type="text" name="categories" placeholder="Nhập tên danh mục" class="form-control" required value="<?php echo $categories?>">
								</div>
							   <button id="payment-button" name="submit" type="submit" class="btn btn-lg btn-info btn-block">
							   <span id="payment-button-amount">Xác nhận</span>
							   </button>
							   <div class="field_error"><?php echo $msg?></div>
							</div>
						</form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         
<?php
require('footer.inc.php');
?>