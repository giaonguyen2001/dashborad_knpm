<?php
require('top.inc.php');
$categories_id='';
$name='';
$price='';
$qty='';
$config ='';
$description	='';
$supplier	='';

$msg='';
$image_required='required';
if(isset($_GET['id']) && $_GET['id']!=''){
	$image_required='';
	$id=get_safe_value($con,$_GET['id']);
	$res=mysqli_query($con,"select * from sanpham where maSanPham='$id'");
	$check=mysqli_num_rows($res);
	if($check>0){
		$row=mysqli_fetch_assoc($res);
		$categories_id=$row['maDanhMuc'];
		$name=$row['tenSanPham'];
		$price=$row['gia'];
		$qty=$row['soLuong'];
		$config ='cauHinh';
		$supplier	='maNhaCungCap';
		$description=$row['thongTinSanPham'];
	}else{
		header('location:product.php');
		die();
	}
}

if(isset($_POST['submit'])){
	$categories_id=get_safe_value($con,$_POST['categories_id']);
	$name=get_safe_value($con,$_POST['name']);
	$price=get_safe_value($con,$_POST['price']);
	$qty=get_safe_value($con,$_POST['qty']);
	$config =get_safe_value($con,$_POST['config']);
	$supplier =get_safe_value($con,$_POST['supplier']);
	$description=get_safe_value($con,$_POST['description']);
	$res=mysqli_query($con,"select * from sanPham where tenSanPham='$name'");
	$check=mysqli_num_rows($res);
	if($check>0){
		if(isset($_GET['id']) && $_GET['id']!=''){
			$getData=mysqli_fetch_assoc($res);
			if($id==$getData['maSanPham']){
			
			}else{
				$msg="Product already exist";
			}
		}else{
			$msg="Product already exist";
		}
	}

	
	if($msg==''){
		if(isset($_GET['id']) && $_GET['id']!=''){
			if($_FILES['image']['name']!=''){
				$image=$_FILES['image']['name'];
				move_uploaded_file($_FILES['image']['tmp_name'],PRODUCT_IMAGE_SERVER_PATH.$image);
				$update_sql="update sanPham set maDanhMuc='$categories_id',tenSanPham='$name',gia='$price',soLuong='$qty',thongTinSanPham='$description',anh='./images/products/$image' where maSanPham='$id'";
			}else{
				$update_sql="update sanPham set maDanhMuc='$categories_id',tenSanPham='$name',gia='$price',soLuong='$qty',thongTinSanPham='$description',anh='./images/products/$image' where maSanPham='$id'";
			}
			mysqli_query($con,$update_sql);
		}else{
			$image=$_FILES['image']['name'];
			move_uploaded_file($_FILES['image']['tmp_name'],PRODUCT_IMAGE_SERVER_PATH.$image);
			mysqli_query($con,"insert into sanPham(maDanhMuc,tenSanPham,gia,soLuong,cauHinh,maNhaCungCap,thongTinSanPham,anh) values('$categories_id','$name','$price','$qty','$config','$supplier','$description','./images/products/$image')");
		}
		header('location:product.php');
		die();
	}
}
?>
<div class="content pb-0">
            <div class="animated fadeIn">
               <div class="row">
                  <div class="col-lg-12">
                     <div class="card">
                        <div class="card-header"><strong>Sản Phẩm</div>
                        <form method="post" enctype="multipart/form-data">
							<div class="card-body card-block">
							   <div class="form-group">
									<label for="categories" class=" form-control-label">Danh mục</label>
									<select class="form-control" name="categories_id">
										<?php
										$res=mysqli_query($con,"select * from DanhMuc order by maDanhMuc asc");
										while($row=mysqli_fetch_assoc($res)){
											if($row['maDanhMuc']==$categories_id){
												echo "<option selected value=".$row['maDanhMuc'].">".$row['tenDanhMuc']."</option>";
											}else{
												echo "<option value=".$row['maDanhMuc'].">".$row['tenDanhMuc']."</option>";
											}
											
										}
										?>
									</select>
								</div>
								<div class="form-group">
									<label for="categories" class=" form-control-label">Nhà cung cấp</label>
									<select class="form-control" name="supplier">
										<?php
										$res=mysqli_query($con,"select * from NhaCungCap order by maNhaCungCap asc");
										while($row=mysqli_fetch_assoc($res)){
											if($row['maNhaCungCap']==$categories_id){
												echo "<option selected value=".$row['maNhaCungCap'].">".$row['tenNhaCungCap']."</option>";
											}else{
												echo "<option value=".$row['maNhaCungCap'].">".$row['tenNhaCungCap']."</option>";
											}
											
										}
										?>
									</select>
								</div>
								<div class="form-group">
									<label for="categories" class=" form-control-label">Tên sản phẩm</label>
									<input type="text" name="name" placeholder="Nhập tên sản phẩm" class="form-control" required value="<?php echo $name?>">
								</div>
								
								<div class="form-group">
									<label for="categories" class=" form-control-label">giá</label>
									<input type="text" name="price" placeholder="Nhập giá" class="form-control" required value="<?php echo $price?>">
								</div>
								
								<div class="form-group">
									<label for="categories" class=" form-control-label">Số lượng</label>
									<input type="text" name="qty" placeholder="Nhập số lượng" class="form-control" required value="<?php echo $qty?>">
								</div>
								
								<div class="form-group">
									<label for="categories" class=" form-control-label">Ảnh</label>
									<input type="file" name="image" class="form-control" required value="<?php echo $image_required?>">
								</div>
								<div class="form-group">
									<label for="categories" class=" form-control-label">Cấu hình</label>
									<textarea name="config" placeholder="Nhập cấu hình sản phẩm" class="form-control" required><?php echo $config?></textarea>
								</div>
								
								<div class="form-group">
									<label for="categories" class=" form-control-label">Thông tin sản phẩm</label>
									<textarea name="description" placeholder="Nhập thông tin sản phẩm" class="form-control" required><?php echo $description?></textarea>
								</div>
								
							   <button id="payment-button" name="submit" type="submit" class="btn btn-lg btn-info btn-block">
							   <span id="payment-button-amount">Submit</span>
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