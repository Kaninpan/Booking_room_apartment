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
    <title>B.S. Apartment | ข้อมูลส่วนตัว </title>
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

    $query=mysqli_query($conn,"select * from `user_info` where id='$id'");
    $row=mysqli_fetch_array($query);


    $query=mysqli_query($conn,"select * from `paylist` where id='$id'");
    $roww=mysqli_fetch_array($query);

    $query = "select * from report_paylist where id ='$id'";  
    $run = mysqli_query($conn,$query); 


if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $TEL = $_POST['TEL'];
    $address = $_POST['address'];
    $IDcard = $_POST['IDcard'];
    mysqli_query($conn,"update `user_info` set  name = '$name', TEL = '$TEL', address = '$address', IDcard = '$IDcard' WHERE id = '$id'");
        header('location: user_info.php');    
}

if(isset($_POST['submit1'])){
    $img_name= "BS".rand(1000,10000)." - ".$_FILES['submit1']['name'];
    $tmp_img_name=$_FILES['submit1']['tmp_name'];
    $folder='Slip_payment_user/';
    move_uploaded_file($tmp_img_name,$folder.$img_name);
    mysqli_query($conn, "UPDATE `paylist` SET file_slip ='$img_name', status_pay = '2.รอตรวจสอบการชำระเงิน'  WHERE id = '$id'") or die('query failed');
    $message[] = 'ชำระเงินสำเร็จ !';
    header('location: user_info.php'); 
 }

 if(isset($_POST['submit2'])){
    $mdy_out = $_POST['mdy_out'];
    $notify_out = $_POST['notify_out'];
    mysqli_query($conn, "UPDATE `user_info` SET mdy_out = '$mdy_out',  notify_out = '$notify_out'  WHERE id = '$id'") or die('query failed');
    $message[] = 'แจ้งขอย้ายออกสำเร็จ! ขอบคุณสำหรับการใช้บริการห้องพักของเรา :( ';
    header('location: user_info.php'); 
 }


 if(isset($message)){
    foreach($message as $message){
       echo '<div class="message" onclick="this.remove();">'.$message.'</div>';
    }
 }
 

$query = "SELECT * FROM paylist ORDER BY mdy_round ASC" or die("Error:" . mysqli_error());  
$result = mysqli_query($conn ,$query); 


mysqli_close($conn);
?>


<body>
    <form action="contractuser.php?id=<?php echo $id; ?>" method="post">
            <button type="submit" name="contrack" class="btn"><p><b>ใบสัญญา / รายงาน</b></p></button>
    </form>
	<div class="form-container">
  	 <form action="" method="post" enctype='multipart/form-data'>
       <div class="row1bkf">
  		<div class="column1bkf">
          <div class="user_room_status_select">
          <h3>ข้อมูลผู้จอง</h3>
            <div style="display:flex; align-items: left; margin-left: 5%;"><font color='red'><h2><p>ชื่อ : </p></font>  <?php echo $row['name']?></h2></div>
            <div style="display:flex; align-items: left; margin-left: 5%;"><font color='red'><h2><p>เบอร์โทรศัพท์  : </p></font>  <?php echo $row['TEL']?></h2></div>
            <div style="display:flex; align-items: left; margin-left: 5%;"><font color='red'><h2><p>อีเมล์  : </p></font>  <?php echo $row['email']?></h2></div>
            <div style="display:flex; align-items: left; margin-left: 5%;"><font color='red'><h2><p>ที่อยู่ : </p></font>  <?php echo $row['address']?></h2></div>
            <div style="display:flex; align-items: left; margin-left: 5%;"><font color='red'><h2><p>ห้อง : </p></font>  <?php echo $row['type']?></h2></div>
            <div style="display:flex; align-items: left; margin-left: 5%;"><font color='red'><h2><p>วันที่เข้าพัก  : </p></font>  <?php echo $row['mdy']?></h2></div>
            <a href="login.php?logout=<?php echo $id; ?>" onclick="return confirm('คุณต้องการออกจากระบบหรือไม่ ?');" class="btn1">ออกจากระบบ</a><br>
		</div>
    </div>
		<div class="column1bkf">
        <h3>แก้ไขข้อมูล</h3>
            <input type="text" name="id" required placeholder="ลำดับ" class="box" value="<?php echo $row['id']; ?>" disabled hidden>
		  	<input type="text" name="name" required placeholder="กรอกชื่อผู้เข้าพัก" class="box" value="<?php echo $row['name']; ?>">
            <input type="text" name="TEL"  id="tbNum" placeholder="กรอกเบอรโทรศัพท์" class="box" pattern="[0-9]{2}-[0-9]{4}-[0-9]{4}" title="โปรดกรอกเบอร์โทรศัพท์ของคุณให้ถูกต้อง เช่น 01-2345-6789"  maxLength="10" value="<?php echo $row['TEL']; ?>" onkeyup="addHyphen(this)" required>
            <script>
				function addHyphen (element) {
    			let ele = document.getElementById(element.id);
       			ele = ele.value.split('-').join('');  

        		let finalVal = ele.replace(/(\d)(\d)(\d)(\d)(\d)(\d)(\d)(\d)(\d)(\d)/, '$1$2-$3$4$5$6-$7$8$9$10')
        		document.getElementById(element.id).value = finalVal;
    			}
			</script>
        <input type="text" name="address" required placeholder="กรอกที่อยู่ของคุณ" class="box" value="<?php echo $row['address']; ?>">
        <input type="text" name="IDcard" required placeholder="กรอกเลขบัตรประชาชน" class="box" value="<?php echo $row['IDcard']; ?>" disabled>
        <br><br><h2><font color='Red'>หมายเหตุ : </font> หากต้องการแก้ไขเพิ่มเติมโปรดติดต่อเจ้าหน้าที่</h2>
        <br>
        <input type="submit" name="submit" class="btn" value="แก้ไข"><br><br><br>
        </div>
        <HR noshade size="5"  align="center">
	<div class="row1bkf">
  		<div class="column1bkf">
            <h3>ชำระเงิน</h3>
            <img src="images/pay.jpg"  width="200" height="240">
			<h2>เลขที่บัญชีพร้อมเพย์ : 082-249-2944 <br>ชื่อบัญชี : นายคณิน  อมรสวัสดิ์ชัย </h2><br><br><br>
                <div class="user_room_status_select">
                            <div class="cost_roomm">
                                <h2><div style="display:gird; grid-template-columns: 50% 50%; text-align: left; margin-left: 20%;">ค่ามัดจำ : </div><div style="display:gird; grid-template-columns: 50% 50%; text-align: right; margin-right: 20%; margin-top: -3%;"><?php echo number_format ($roww['Deposit'],2)?> บาท</div></h2>
                            </div>
                            <div class="cost_roomm">
                                <h2><div style="display:gird; grid-template-columns: 50% 50%; text-align: left; margin-left: 20%;">ค่าห้อง : </div><div style="display:gird; grid-template-columns: 50% 50%; text-align: right; margin-right: 20%; margin-top: -3%;"><?php echo number_format($roww['pay_room'],2) ?> บาท</div></h2>
                            </div>
                            <div class="cost_water">
                                <h2><div style="display:gird; grid-template-columns: 50% 50%; text-align: left; margin-left: 20%;">ค่าน้ำ : </div><div style="display:gird; grid-template-columns: 50% 50%; text-align: right; margin-right: 20%; margin-top: -3%;"><?php echo number_format($roww['pay_water'],2) ?> บาท</div></h2>
                            </div>
                            <div class="cost_electric">
                                <h2><div style="display:gird; grid-template-columns: 50% 50%; text-align: left; margin-left: 20%;">ค่าไฟฟ้า  : </div><div style="display:gird; grid-template-columns: 50% 50%; text-align: right; margin-right: 20%; margin-top: -3%;"><?php echo number_format($roww['pay_electric'],2) ?> บาท </div></h2>
                            </div>
                            <div class="cost_electric">
                                <h2><div style="display:gird; grid-template-columns: 50% 50%; text-align: left; margin-left: 20%;">ค่าอื่น ๆ  : </div><div style="display:gird; grid-template-columns: 50% 50%; text-align: right; margin-right: 20%; margin-top: -3%;"><?php echo number_format($roww['pay_other'],2) ?> บาท </div></h2>
                            </div>
                            <div class="cost_total">
                                <h2><div style="display:gird; grid-template-columns: 50% 50%; text-align: left; margin-left: 26%;">รวมทั้งสิ้น  : </div><div style="display:gird; grid-template-columns: 50% 50%; text-align: right; margin-right: 26.0222%; margin-buttom: 10%; margin-top: -2.75%;"><?php echo number_format($roww['pay_total'],2) ?> บาท </div></h2>
                                <?php
                                    if($roww['pay_total'] > 0.01 ){
	                                        echo "<h2> สถานะ : <font color='red'> มียอดค้างชำระ </font></h2>";
                                    }
                                        else{
                                            echo "<h2> สถานะ : <font color='Green'> ไม่มียอดค้างชำระ </font></h2>";
                                    }
                                ?>
                            </div>
                        </div>
                        <h2><font color='Red'>ประกาศ : </font> ค่าน้ำลบม. 30 บาท และ ค่าไฟยูนิตละ 8 บาท </h2>
                        <h2><font color='Red'> ค่าอื่นๆ </font>คือ ค่าที่จอดรถ ค่าคีย์การ์ด เป็นต้น</h2>
			</div>
            <div class="column1bkf">   
            <h3>รายละเอียดการชำระ</h3>
            <p><b>รอบบิลของ : <?php echo $roww['mdy_round'] ?> </b></p>
            <br><?php
                            if($roww['status_pay'] == '1.รอชำระเงิน'){
                                echo "<br><h2>สถานะการชำระ :<font color='red'> รอชำระเงิน </font></h2>";
                            }
                            elseif ($roww['status_pay']== '2.รอตรวจสอบการชำระเงิน') {
                                echo "<br><h2>สถานะการชำระ : <font color='orange'> รอตรวจสอบการชำระเงิน </font></h2>";
                            }
                            elseif ($roww['status_pay']== '3.ชำระแล้วเรียบร้อย') {
                                echo "<br><h2>สถานะการชำระ : <font color='Green'> ชำระแล้วเรียบร้อย </font></h2>";
                            }
                            else{
                                echo "<br><h2>สถานะการชำระ : <font color='red'> ยังไม่ได้มีการชำระ </h2></font>";
                            }
                    ?>    
            <h2>แนบไฟล์ชำระเงิน</h2>

            <input type="file" name="submit1" class="box">
            <h2><font color='Red'>หมายเหตุ :  </font> หากต้องการชำระแยกแต่ละรายการโปรดติดต่อชำระกับผู้ดูแล </h2>
            <input type="submit" name="submit1" class="btn" value="ชำระ">
            <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><hr>
            <h3>แจ้งขอย้ายออกจากห้องพัก</h3>
            <input type="date" name="mdy_out" class="box" min="<?php echo date('Y-m-d');?>">
            <?php
			    function DateThai($strDate)
			    {
				    $strYear = date("Y",strtotime($strDate))+543;
				    $strMonth= date("n",strtotime($strDate));
				    $strDay= date("j",strtotime($strDate));
				    $strMonthCut = Array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
				    $strMonthThai=$strMonthCut[$strMonth];
				    return "$strDay $strMonthThai $strYear";
			    }		
				$strDate = date("d-m-Y");
	        ?>
		    <input type="text" name="notify_out" value="<?php echo DateThai("$strDate");?>" hidden><br>
            <input type="submit" name="submit2" class="btn" value="แจ้งขอย้ายออก">
                    <?php
                            if($row['mdy_out'] > '0000-00-00')
                                echo "<br><h2>สถานะ :<font color='red'> แจ้งขอย้ายออกสำเร็จ! </font></h2>";
                            else{
                                echo "<br><h2>สถานะ : <font color='red'> ขอบคุณสำหรับการใช้บริการห้องพักของเรา :(  </h2></font>";
                            }
                    ?>    
            <h2>ขอย้ายออกโปรดแจ้งล่วงหน้าก่อนย้ายออก 1 เดือน</h2>
            </div>
		</div>
        </div>
        <br><br><hr><br>
        <h3>รายการค่าใช้จ่ายย้อนหลังแต่ละเดือน</h3>
             <?php
			echo "<table  align='center' width='100%' border ='0' hight>";
			echo "<tr align='center' bgcolor='#00ad45'><td><h1>ชื่อ-นามสกุล</h1></td><td><h1>หมายเลขห้อง</h1></td><td><h1> ค่ามัดจำ </h1></td><td><h1> ค่าห้องพัก </h1></td><td><h1>ค่าน้ำ</h1></td><td><h1>ค่าไฟ</h1></td><td><h1> ค่าอื่นๆ  </h1></td><td><h1>รวมทั้งหมด</h1></td><td><h1>รอบบิลของ</h1></td>";
         $i=1;  
         if ($num = mysqli_num_rows($run)) {  
              while ($result = mysqli_fetch_assoc($run)) {  
                   echo "  
                        <tr bgcolor='#5ecc62'>   
                             <td style='font-size: 20px;'width='10%'><p>".$result['name']."</p></td>
                             <td style='font-size: 20px;'width='10%'><p>".$result['type']."</p></td>
                             <td class='alnright' style='font-size: 20px;'width='6%'><p><b>".number_format($result['Deposit'],2)."</b></p></td>  
                             <td class='alnright' style='font-size: 20px;'width='8%'><p><b>".number_format($result['pay_room'],2)."</b></p></td>
                             <td class='alnright' style='font-size: 20px;'width='8%'><p><b>".number_format($result['pay_water'],2)."</b></p></td>
                             <td class='alnright' style='font-size: 20px;'width='8%'><p><b>".number_format($result['pay_electric'],2)."</b></p></td>
                             <td class='alnright' style='font-size: 20px;'width='8%'><p><b>".number_format($result['pay_other'],2)."</b></p></td>
                             <td class='alnright' style='font-size: 20px;'width='8%'><p><b>".number_format($result['pay_total'],2)."</b></p></td>
                             <td style='font-size: 20px;'width='7%'><p>".$result['mdy_round']."</p></td>   
                        </tr>
                   ";  
              }  
         } 
	?>                        
   </form>
</div>
</div>
</body>
</html>
           