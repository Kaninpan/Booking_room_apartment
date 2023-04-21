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
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
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

    $query = "select * from paylist WHERE Class = 'User'";  
    $run = mysqli_query($conn,$query); 
         if (isset($_GET['id'])) {  
               $id = $_GET['id'];  
               $query = "DELETE FROM `paylist` WHERE id = '$id'";  
               $run = mysqli_query($conn,$query);  
         if ($run) {  
               header('location: cost_byadmin.php');  
         }else{  
              echo "Error: ".mysqli_error($conn);  
    }  
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

<div class="contentEditbyadmin">
     <h1>รายการเจ้าของห้องแต่ละห้อง</h1>
     <a href="Report_cost_byadmin.php" class="btn">รายการค่าใช้จ่ายย้อนหลังแต่ละเดือน</a>
   <?php
			echo "<table  align='center' width='100%' border ='0' hight>";
			echo "<tr align='center' bgcolor='#00ad45'><td><h1>ชื่อ - นามสกุลของผู้พัก</h1></td><td><h1>ชั้น / หมายเลขห้อง</h1></td><td><h1> ค่ามัดจำ </h1></td><td><h1> ค่าห้องพัก </h1></td><td><h1>ค่าน้ำ</h1></td><td><h1>ค่าไฟ</h1></td><td><h1> ค่าอื่นๆ  </h1></td><td><h1>รวมทั้งหมด</h1></td><td><h1>รอบบิลของ</h1></td><td><h1>สลิปการชำระเงิน</h1></td><td><h1>View</h1></td><td><h1>สถานะการชำระ</h1></td><td><h1>ตัวเลือก</h1></td>";
         $i=1;  
         if ($num = mysqli_num_rows($run)) {  
              while ($result = mysqli_fetch_assoc($run)) {  
                   echo "  
                        <tr bgcolor='#5ecc62'>   
                             <td style='font-size: 20px;'width='10%'><p>".$result['name']."</p></td>
                             <td style='font-size: 20px;' width='10%'><p>".$result['type']."</p></td> 
                             <td class='alnright' style='font-size: 20px;'width='6%'><p><b>".number_format($result['Deposit'],2)."</b></p></td>  
                             <td class='alnright' style='font-size: 20px;'width='8%'><p><b>".number_format($result['pay_room'],2)."</b></p></td>
                             <td class='alnright' style='font-size: 20px;'width='8%'><p><b>".number_format($result['pay_water'],2)."</b></p></td>
                             <td class='alnright' style='font-size: 20px;'width='8%'><p><b>".number_format($result['pay_electric'],2)."</b></p></td>
                             <td class='alnright' style='font-size: 20px;'width='8%'><p><b>".number_format($result['pay_other'],2)."</b></p></td>
                             <td class='alnright' style='font-size: 20px;'width='8%'><p><b>".number_format($result['pay_total'],2)."</b></p></td>
                             <td style='font-size: 20px;'width='7%'><p>".$result['mdy_round']."</p></td>
                             <td style='font-size: 20px;'><p>".$result['file_slip']."</p></td>
                             <td><a href='Slip_payment_user/".$result['file_slip']."'class='btn'><b><p>ดูสลิป</b></p></a></td>
                             <td style='font-size: 20px;' width='7%'><p><b>".$result['status_pay']."</b></p></td>
                             <td>
                                   <a href='cost_byadmin.php?id=".$result['id']."' class='btndelete'>ลบ</a><br>
                                   <a href='Edit_cost_byadmin.php?id=".$result['id']."' class='btn'>อัพเดท</a>
                              <td>           
                        </tr>
                   ";  
              }  
         } 
	?> 
     </div>
</body>
</html>
