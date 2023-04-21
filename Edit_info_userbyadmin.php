<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Thai&family=Prompt&display=swap" rel="stylesheet">
	<link rel="icon" sizes="16x16" href="http://localhost/phpbasic/Project_tanes/images/iconB.S..png"/>
    <title>B.S. Apartment | ระบบสำหรับผู้ดูแลห้องพัก</title>
</head>
<?php
     include 'config.php';
     session_start();
     $id = $_SESSION['id'];

     if(!isset($id)){
           header('location:login.php');
     };

     if(isset($_GET['logout'])){
          unset($id);
          session_destroy();
     header('location:login.php');
     };

     $id=$_GET['id'];
     $query=mysqli_query($conn,"select * from `user_info` where id='$id'");
     $row=mysqli_fetch_array($query);

	 if(isset($_POST['submit'])){
		$id = $_GET['id'];
		$name = $_POST['name'];
		$IDcard = $_POST['IDcard'];
		$email = $_POST['email'];
		$TEL = $_POST['TEL'];
		$address = $_POST['address'];
        $mdy = $_POST['mdy'];
			mysqli_query($conn,"update `user_info` set name = '$name', IDcard ='$IDcard', email = '$email', TEL = '$TEL', address = '$address', mdy = '$mdy'  WHERE id = '$id'");
			header('location: infouser_admin.php');

	}

	mysqli_close($conn);
?>
<body>
<div class="topnav">
  <a href="Admin_info.php">หน้าแรก</a>
  <a href="infouser_admin.php">ข้อมูลส่วนตัว</a>
  <a href="room_type.php">การจองห้อง</a>
  <a href="cost_byadmin.php">ค่าไฟ-ค่าน้ำ</a>
  <a href="info_user_outbydamin.php">ย้ายออก</a>
  <a style="float:right" href="login.php?logout=<?php echo $id; ?>" onclick="return confirm('คุณต้องการออกจากระบบหรือไม่ ?');" class="btnbackid">ออกจากระบบ</a>
</div>
<div class='form-containerLG1'>
    <form action="" method="post">
    <h3>แก้ไขข้อมูลผู้จองห้องพัก</h3>
            <input type="text" name="id" placeholder="ลำดับ" class="box" value="<?php echo $row['id']; ?>" disabled>
		  	<input type="text" name="name"  placeholder="กรอกชื่อผู้เข้าพัก" class="box" value="<?php echo $row['name']; ?>">
			<input type="text" name="IDcard"  placeholder="กรอกเลขบัตรประชาชน" class="box" value="<?php echo $row['IDcard']; ?> " maxLength="13">
			<input type="email" name="email"  placeholder="กรอกอีเมลของผู้จอง" class="box" value="<?php echo $row['email']; ?>">
			<input type="text" name="TEL"  id="tbNum" placeholder="กรอกเบอรโทรศัพท์" class="box" pattern="[0-9]{2}-[0-9]{4}-[0-9]{4}" title="โปรดกรอกเบอร์โทรศัพท์ของคุณให้ถูกต้อง เช่น 01-2345-6789"  maxLength="10" value="<?php echo $row['TEL']; ?>" onkeyup="addHyphen(this)" >
			<script>
					function addHyphen (element) {
    				let ele = document.getElementById(element.id);
       				ele = ele.value.split('-').join('');  

        			let finalVal = ele.replace(/(\d)(\d)(\d)(\d)(\d)(\d)(\d)(\d)(\d)(\d)/, '$1$2-$3$4$5$6-$7$8$9$10')
        			document.getElementById(element.id).value = finalVal;
    				}
				</script>
			<input type="text" name="address"  placeholder="กรอกที่อยู่ของผู้จอง" class="box" value="<?php echo $row['address']; ?>">
			<input type="date" name="mdy"  placeholder="วันที่จะเข้าพัก" class="box" value="<?php echo $row['mdy']; ?>">
        <input type="submit" name="submit" class="btn" value="แก้ไข"><br>
    </form>
</div>
</body>
</html>
