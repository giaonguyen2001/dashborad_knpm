<?php
	require('top.inc.php');
	$user ='';
	$name = '';
	$sdt = '';
	$password = '';
	$address = '';
	$date = '';
	$msg = '';
	if(isset($_GET['id']) && $_GET['id'] != ''){
		$id = get_safe_value($con, $_GET['id']);
		$res = mysqli_query($con, "select * from khachhang where maKhachHang='$id'");
		$check = mysqli_num_rows($res);
		if($check > 0){
			$row = mysqli_fetch_assoc($res);
			$user = $row['maKhachHang'];
		}else{
			header('location:users.php');
			die();
		}
	}

	if(isset($_POST['submit'])){
		$id = get_safe_value($con, $_GET['id']);
		$name = get_safe_value($con,$_POST['name']);
		$sdt = get_safe_value($con,$_POST['sdt']);
		$address = get_safe_value($con,$_POST['address']);
		$password = get_safe_value($con,$_POST['password']);
		$date = get_safe_value($con,$_POST['date']);
		$res = mysqli_query($con,"select * from khachhang where maKhachHang='$id'");
		$check= mysqli_num_rows($res);
		if($check>0){
			if(isset($_GET['id']) && $_GET['id']!=''){
				$getData=mysqli_fetch_assoc($res);
				if($id==$getData['maKhachHang']){
				}else{
					$msg="Da ton tai";
				}
			}else{
				$msg="Da ton tai";
			}
		}
		
		if($msg==''){
			if(isset($_GET['id']) && $_GET['id']!=''){
				mysqli_query($con,"update khachhang set hoTen='$name',soDienThoai='$sdt',matkhau='$password', diaChi='$address' where maKhachHang='$id'");
			}else{
				mysqli_query($con,"insert into khachhang(hoTen,soDienThoai,matKhau,diaChi,ngayDangKy) values('$name','$sdt','$password','$address','$date')");
			}
			header('location:users.php');
			die();
		}
	}
?>
<div class="content pb-0">
            <div class="animated fadeIn">
               <div class="row">
                  <div class="col-lg-12">
                     <div class="card">
                        <div class="card-header"><strong>Người dùng</strong></div>
                        <form method="post">
							<div class="card-body card-block">
							   <div class="form-group">
									<label for="categories" class=" form-control-label"></label>
									<input type="text" name="name" placeholder="Nhập họ tên" class="form-control" required value="<?php echo $name?>">

									<label for="categories" class=" form-control-label"></label>
									<input type="text" name="sdt" placeholder="Nhập số điện thoại" class="form-control" required value="<?php echo $sdt?>">

									<label for="categories" class=" form-control-label"></label>
									<input type="text" name="password" placeholder="Nhập mật khẩu" class="form-control" required value="<?php echo $password?>">

									<label for="categories" class=" form-control-label"></label>
									<input type="text" name="address" placeholder="Nhập địa chỉ" class="form-control" required value="<?php echo $address?>">

									<label for="categories" class=" form-control-label"></label>
									<input type="date" name="date"  class="form-control" required value="<?php echo $date?>">
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