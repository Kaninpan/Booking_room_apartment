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

     $id = $_GET['id'];

     $query=mysqli_query($conn,"select * from `paylist` where id='$id'");
     $row=mysqli_fetch_array($query);


     if(isset($_POST['submit'])){
        $id = $_GET['id'];
        
           // $name = $_POST['name'];
           // $type = $_POST['type'];

        $name = $row['name'];
        $type = $row['type'];

        $Deposit = $_POST['Deposit'];
        $pay_room = $_POST['pay_room'];
     
        $pay_water = $_POST['pay_water'];
        $pay_waters = $pay_water*30;
        $pay_electric = $_POST['pay_electric'];
        $pay_electrics = $pay_electric*8;

        $pay_other = $_POST['pay_other'];
        $pay_total = $_POST['pay_total'] + $pay_electric + $pay_water + $pay_room + $pay_room + $Deposit + $pay_other;
        $mdy_round = $_POST['mdy_round'];
        $status_pay = $_POST['status_pay'];

             mysqli_query($conn, "INSERT INTO `report_paylist`(id, name, type,Deposit, pay_room, pay_water, pay_electric, pay_other, pay_total, mdy_round) VALUES('$id','$name','$type','$Deposit', '$pay_room', '$pay_waters', '$pay_electrics', '$pay_other', '$pay_total', '$mdy_round')") or die('query failed');
             mysqli_query($conn,"update `paylist` set Deposit ='$Deposit', pay_room = '$pay_room', pay_water = '$pay_waters', pay_electric = '$pay_electrics', pay_other ='$pay_other', pay_total = '$pay_total', mdy_round = '$mdy_round', status_pay = '$status_pay'  WHERE id = '$id'");
             header('location: cost_byadmin.php');
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
    <form method="POST" action="">
     <p><b>อัพเดทค่าใช้จ่ายแต่ละห้อง</b></p>
     <input type="text" name="id" class="box" placeholder="ลำดับ" required value="<?php echo $row['id']; ?>"disabled>
     <input type="text" name="name" class="box" placeholder="ชื่อผู้เข้าพัก" required value="<?php echo $row['name']; ?>" disabled>
     <input type="text" name="type" class="box" placeholder="หมายเลขห้อง" required value="<?php echo $row['type']; ?>" disabled>
                    <div class="box">
                         <p><b>ระบุค่าใช้จ่ายของห้องพัก</b></p><br><br>
                         <div style="display:flex; align-items: left;"><p><b>ค่ามัดจำ</b></p></div>
                         <input type="text" name="Deposit" class="box"  placeholder="ค่ามัดจำ" required value="<?php echo $row['Deposit']; ?>">
                         <div style="display:flex; align-items: left;"><p><b>ค่าห้อง</b></p></div>
                         <input type="text" name="pay_room" class="box" placeholder="ค่าห้อง"  required value="<?php echo $row['pay_room']; ?>">
                         <div style="display:flex; align-items: left;"><p><b>ค่าน้ำ / ใส่หน่วยของค่าน้ำ</b></p></div>
                         <input type="text" name="pay_water" class="box" placeholder="ค่าน้ำ" required value="<?php echo $row['pay_water']; ?>">
                         <div style="display:flex; align-items: left;"><p><b>ค่าไฟ / ใส่หน่วยของค่าไฟ</b></p></div>
                         <input type="text" name="pay_electric" class="box" placeholder="ค่าไฟ"  required value="<?php echo $row['pay_electric']; ?>">
                         <div style="display:flex; align-items: left;"><p><b>ค่าอื่นๆ</b></p></div>
                         <input type="text" name="pay_other" class="box" placeholder="ค่าอื่นๆ"  required value="<?php echo $row['pay_other']; ?>">
                         <p style="font-size: 90%;"><b>ถ้าไม่มีค่าใช้จ่ายให้ใส่ 0 ที่ช่องนั้น<br>และกรอกค่าใช้จ่ายใหม่ทุกครั้งที่จะทำการกดส่ง</b></p>
                    </div>
                    <p><b>รอบบิลของ</b></p>
                    <input type="date" name="mdy_round" class="box" value="<?php echo $row['mdy_round']; ?>">
                    <select name="status_pay" class="box" >
                         <option value=""hidden>สถานะการจ่ายเงิน</option>
                         <option value="1.รอชำระเงิน">1.รอชำระเงิน</option>
                         <option value="2.รอตรวจสอบการชำระเงิน">2.รอตรวจสอบการชำระเงิน</option>
                         <option value="3.ชำระแล้วเรียบร้อย">3.ชำระแล้วเรียบร้อย</option>
                    </select>
                    <h2><b>สถานะการจ่ายเงิน : <?php echo $row['status_pay']; ?></b></h2><br>
	            <input type="submit" name="submit" class="btn">
</form>
</div>
</body>
</html>
