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

     $query = "select * from user_info where Class = 'User'";  
     $run = mysqli_query($conn,$query); 
          if (isset($_GET['id'])) {  
                $id = $_GET['id']; 
                $query = "update `user_info` set Class ='Out' WHERE id = '$id'";  
                $run = mysqli_query($conn,$query);  
          if ($run) {  
                header('location: Admin_info.php');  
          }else{  
               echo "Error: ".mysqli_error($conn);  
     }  
}  

if(isset($_GET['type'])){
     $type = $_GET['type'];
          mysqli_query($conn,"update `user_info` set Class = 'Out' , email = ' ' , password = ' ', IDcard = ' ' WHERE type = '$type'");
          mysqli_query($conn,"DELETE FROM `paylist` WHERE type = '$type'");
          mysqli_query($conn,"update `room` set name ='none', Status = 'none' WHERE type = '$type'");
          header('location: Admin_info.php');
}


$query = "SELECT * FROM user_info ORDER BY type ASC" or die("Error:" . mysqli_error());
$result = mysqli_query($conn ,$query); 


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
     <h1>รายการผู้จองห้องพัก</h1>
     <?php
          require 'config.php';
          $query = "SELECT type FROM user_info where Class = 'User' ";
          $query_run = mysqli_query($conn, $query);

          $row = mysqli_num_rows($query_run);
          echo '<h1> จำนวนห้องพักที่ถูกเลือกไป : <font color=#1D9030>  '.$row.' </font>/ 54 ห้อง</h1>'
     ?>
   <?php
			echo "<table  align='center' width='100%' border ='0'>";
			echo "<tr align='center' bgcolor='#00ad45'><td><h1>ชื่อผู้จอง</h1></td><td><h1>เบอร์โทรศัพท์</h1></td><td><h1> ชั้น / หมายเลขห้อง </h1></td><td><h1>วันที่จะเข้าพัก</h1></td><td><h1>ต้องการย้ายออกวันที่</h1></td><td><h1>ตัวเลือก</h1></td>";
         $i=1;  
         if ($num = mysqli_num_rows($run)) {  
              while ($result = mysqli_fetch_assoc($run)) {  
                   echo "  
                        <tr bgcolor='#5ecc62'>   
                             <td style='font-size: 20px;'width='30%'><p>".$result['name']."</p></td>
                             <td style='font-size: 20px;' width='10%'><p>".$result['TEL']."</p></td> 
                             <td style='font-size: 20px;'><p>".$result['type']."</p></td>  
                             <td style='font-size: 20px;'width='7%'><p>".$result['mdy']."</p></td>
                             <td style='font-size: 20px;'width='7%'><p><b>".$result['mdy_out']."</b></p></td>
                             <td>
                                   <a href='Admin_info.php?type=".$result['type']."' class='btndelete'>ย้ายออก</a>
                                   <a href='Edit_info_userbyadmin.php?id=".$result['id']."' class='btnedit'>แก้ไข</a>
                             </td>
                        </tr>
                   ";  
              }  
         } 
	?> 
     </div>
</body>
</html>