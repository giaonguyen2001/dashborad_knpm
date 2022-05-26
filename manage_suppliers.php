<?php
	require('top.inc.php');
	$suppliers = '';
	$sdt = '';
	$address = '';
	$msg = '';
	if(isset($_GET['id']) && $_GET['id'] != ''){
		$id = get_safe_value($con, $_GET['id']);
		$res = mysqli_query($con, "select * from nhaCungCap where maNhaCungCap='$id'");
		$check = mysqli_num_rows($res);
		if($check > 0){
			$row = mysqli_fetch_assoc($res);
			$suppliers = $row['maNhaCungCap'];
		}else{
			header('location:supplier.php');
			die();
		}
	}

	if(isset($_POST['submit'])){
		$id = get_safe_value($con, $_GET['id']);
		$suppliers = get_safe_value($con,$_POST['suppliers']);
		$sdt = get_safe_value($con,$_POST['sdt']);
		$address = get_safe_value($con,$_POST['address']);
		$res = mysqli_query($con,"select * from nhaCungCap where maNhaCungCap='$id'");
		$check= mysqli_num_rows($res);
		if($check>0){
			if(isset($_GET['id']) && $_GET['id']!=''){
				$getData=mysqli_fetch_assoc($res);
				print_r($getData);
				if($id==$getData['maNhaCungCap']){
				}else{
					$msg="Da ton tai";
				}
			}else{
				$msg="Da ton tai";
			}
		}
		
		if($msg==''){
			if(isset($_GET['id']) && $_GET['id']!=''){
				mysqli_query($con,"update nhaCungCap set tenNhaCungCap='$suppliers',soDienThoai='$sdt', diaChi='$address' where maNhaCungCap='$id'");
			}else{
				mysqli_query($con,"insert into NhaCungCap(tenNhaCungCap,soDienThoai,diaChi) values('$suppliers','$sdt','$address')");
			}
			header('location:supplier.php');
			die();
		}
	}
?>
<div class="content pb-0">
     <div class="animated fadeIn">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header"><strong>Nhà cung cấp</strong></div>
                        <form method="post">
							<div class="card-body card-block">
							   <div class="form-group">
									<label for="categories" class=" form-control-label"></label>
									<input type="text" name="suppliers" placeholder="Nhập tên nhà cung cấp" class="form-control" required value="<?php echo $suppliers?>">
									<label for="categories" class=" form-control-label"></label>
									<input type="text" name="sdt" placeholder="Nhập số điện thoại" class="form-control" required value="<?php echo $sdt?>">
									<label for="categories" class=" form-control-label"></label>
									<input type="text" name="address" placeholder="Nhập địa chỉ" class="form-control" required value="<?php echo $address?>">
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