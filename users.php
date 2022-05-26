<?php
require('top.inc.php');

if(isset($_GET['type']) && $_GET['type']!=''){
	$type = get_safe_value($con,$_GET['type']);
	if($type == 'delete'){
		$id = get_safe_value($con,$_GET['id']);
		echo $type;
		echo $id;
		$delete_sql = "delete from khachhang where maKhachHang='$id'";
		mysqli_query($con,$delete_sql);
	}
}

$sql = "select * from khachhang order by maKhachHang desc";
$res = mysqli_query($con,$sql);
?>
<div class="content pb-0">
	<div class="orders">
	   <div class="row">
		  <div class="col-xl-12">
			 <div class="card">
				<div class="card-body">
				   <h4 class="box-title">Users </h4>
				   <h4 class="box-link"><a href="manage_users.php">thêm</a> </h4>

				</div>
				<div class="card-body--">
				   <div class="table-stats order-table ov-h">
					  <table class="table ">
						 <thead>
							<tr>
							   <th class="serial">#</th>
							   <th>Mã khách hàng</th>
							   <th>Số điẹn thoại</th>
							   <th>Họ tên</th>
							   <th>Mật khẩu</th>
							   <th>Địa chỉ</th>
							   <th>Ngày đăng ký</th>
							   <th> </th>
							</tr>
						 </thead>
						 <tbody>
							<?php 
							$i=1;
							while($row=mysqli_fetch_assoc($res)){?>
							<tr>
							   <td class="serial"><?php echo $i++?></td>
							   <td><?php echo $row['maKhachHang']?></td>
							   <td><?php echo $row['soDienThoai']?></td>
							   <td><?php echo $row['hoTen']?></td>
							   <td><?php echo $row['matKhau']?></td>
							   <td><?php echo $row['diaChi']?></td>
							   <td><?php echo $row['ngayDangKy']?></td>
							   <td>
								<?php
								echo "<span class='badge badge-edit'><a href='manage_users.php?id=".$row['maKhachHang']."'>Chỉnh sửa</a></span>&nbsp;";

								echo "<span class='badge badge-delete'><a href='?type=delete&id=".$row['maKhachHang']."'>Delete</a></span>";
								?>
							   </td>
							</tr>
							<?php } ?>
						 </tbody>
					  </table>
				   </div>
				</div>
			 </div>
		  </div>
	   </div>
	</div>
</div>
<?php
require('footer.inc.php');
?>