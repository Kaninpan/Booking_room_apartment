<!DOCTYPE html>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<html lang="en">
<title>B.S. Apartment | จองห้องพัก</title>
<head>
	<link href="style.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="booking.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Thai&family=Prompt&display=swap" rel="stylesheet">
	<link rel="icon" sizes="16x16" href="http://localhost/phpbasic/Project_tanes/images/iconB.S..png"/>
<input type="checkbox" id="ham-menu">
	<label for="ham-menu">
  		<div class="hide-des">
   			<span class="menu-line"></span>
    		<span class="menu-line"></span>
    		<span class="menu-line"></span>
    		<span class="menu-line"></span>
			<span class="menu-line"></span>
			<span class="menu-line"></span>
  		</div>
	</label>

<div class="full-page-green"></div>
	<div class="ham-menu">
	<ul class="centre-text bold-text">
		<li><p><a href="index.php">หน้าแรก</a></p></li>
		<li><p><a href="login.php">จองห้องพัก</a></p></li>
    	<li><p><a href="#Contact">ติดต่อ</a></p></li>
  </ul>
</div>
</head>
<?php
include 'config.php';
if(isset($_POST['submit'])){
	$name = mysqli_real_escape_string($conn, $_POST['name']);
	$IDcard = mysqli_real_escape_string($conn, $_POST['IDcard']);

	$details = $_POST['details'];
	$soi = $_POST['soi'];
	$tambon = $_POST['tambon'];
	$district = $_POST['district'];
	$country = $_POST['country'];
	$postcode = $_POST['postcode'];
	$address = $details." ".$soi." ".$tambon." ".$district." ".$country." ".$postcode;

	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$TEL = mysqli_real_escape_string($conn, $_POST['TEL']);
	$type = mysqli_real_escape_string($conn, $_POST['type']);
	$mdy = mysqli_real_escape_string($conn, $_POST['mdy']);
	$reserve = mysqli_real_escape_string($conn, $_POST['reserve']);
	$pass = mysqli_real_escape_string($conn, md5($_POST['password']));
	$cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));

	$type = $_POST['type'];
	$name = $_POST['name'];

		$select1 = mysqli_query($conn, "SELECT * FROM `user_info` WHERE IDcard = '$IDcard'") or die('query failed');
		$select2 = mysqli_query($conn, "SELECT * FROM `user_info` WHERE email = '$email'") or die('query failed');
   		if(mysqli_num_rows($select1)> 0){
			$message[] = 'เลขบัตรประชาชนถูกใช้งานไปแล้ว';
		 }
		else if   (mysqli_num_rows($select2)> 0){
			$message[] = 'อีเมลนี้ไม่สามารถใช้งานได้โปรดใช้อีเมลอื่น';
		 }
   		else{
			mysqli_query($conn, "INSERT INTO `paylist`(name, type, Deposit, pay_room, pay_water, pay_electric, pay_other, pay_total, mdy_round, file_slip, status_pay, Class) VALUES('$name','$type','5000','0','0','0','200','5200','','BS0000','1.รอชำระเงิน','User')") or die('query failed');
			mysqli_query($conn,"update `room` set name = '$name', Status = 'wait' WHERE type = '$type'");
      		mysqli_query($conn, "INSERT INTO `user_info`(name, IDcard, address, TEL, email, password, Class, type, mdy, reserve) VALUES('$name','$IDcard','$address','$TEL','$email','$pass','User','$type','$mdy','$reserve')") or die('query failed');
      		$message[] = 'จองห้องพักสำเร็จ !';
	}	
}

if(isset($message)){
   foreach($message as $message){
      echo '<div class="message" onclick="this.remove();">'.$message.'</div>';
   }
}

$query = "SELECT * FROM user_info ORDER BY type DESC" or die("Error:" . mysqli_error());  
$result = mysqli_query($conn ,$query); 
mysqli_close($conn);

date_default_timezone_set("Asia/Bangkok");
?>
<body>

	<div class="form-containerbookingform">
  	 <form action="" method="post" enctype='multipart/form-data'>
    	  <h3>จองห้องพัก</h3>
		  <div class="row1bkf">
  			<div class="column1bkf">
			  <div class="box">
			  <p><b>โปรดกรอกข้อมูลของผู้จอง<b></p>
		  		<input type="text" name="name" required placeholder="กรอกชื่อผู้เข้าพัก" class="box">
			  	<input type="email" name="email" required placeholder="กรอกอีเมลของคุณ" class="box">
				<input type="password" name="password" required placeholder="กรอกรหัสผ่านของท่าน" class="box" maxLength="15">
      			<input type="password" name="cpassword" required placeholder="กรอกรหัสผ่านอิกครั้ง" class="box">
				<input type="text" name="TEL"  id="tbNum" placeholder="กรอกเบอรโทรศัพท์" class="box" pattern="[0-9]{2}-[0-9]{4}-[0-9]{4}" title="โปรดกรอกเบอร์โทรศัพท์ของคุณให้ถูกต้อง เช่น 01-2345-6789"  maxLength="10" onkeyup="addHyphen(this)" required>
				<script>
					function addHyphen (element) {
    				let ele = document.getElementById(element.id);
       				ele = ele.value.split('-').join('');  

        			let finalVal = ele.replace(/(\d)(\d)(\d)(\d)(\d)(\d)(\d)(\d)(\d)(\d)/, '$1$2-$3$4$5$6-$7$8$9$10')
        			document.getElementById(element.id).value = finalVal;
    				}
				</script>
				<input type="text" name="IDcard" required placeholder="โปรดกรอกรหัสบัตรประชาชน 13 หลักของคุณ" class="box" pattern="[0-9]{13}" maxLength="13" title="โปรดกรอกเลขบัตรประชาชนให้ครบ 13 หลัก">
				<br>
			</div>
		</div>
		<div class="column1bkf">
		<div class="box">
				<?php
					include 'config.php' 
				?>
                        <p><b>ระบุที่อยู่ของผู้จอง<b></p>
						<input type="text" name="details" required placeholder="รายละเอียดที่อยู่บ้านเลขที่ / ถนน" class="box"> 
						<input type="text" name="soi" required placeholder="ซอย" class="box"> 
                        <select name="country" id="" class="box country" required>
                            <option value="" hidden>โปรดเลือกจังหวัด</option>
                            <?php
                                $sql10 = "SELECT Distinct ProvinceThai FROM province";
                                $query10 = mysqli_query($conn,$sql10);
                                $num10 = mysqli_num_rows($query10);
                                for($i10=0;$i10<$num10;$i10++){
                                    $row10 = mysqli_fetch_row($query10);
                            ?>
                            <option value="<?php echo $row10[0] ?>" id="<?php echo $row10[1] ?>" ><?php echo $row10[0] ?></option>
                            <?php } ?>
                        </select>
                        <select name="district" id="" class="box district" required>
                            <option value="" hidden>โปรดเลือกอำเภอ</option>
                            <?php
                                $sql11 = "SELECT Distinct DistrictThaiShort,ProvinceThai FROM province";
                                $query11 = mysqli_query($conn,$sql11);
                                $num11 = mysqli_num_rows($query11);
                                for($i11=0;$i11<$num11;$i11++){
                                    $row11 = mysqli_fetch_row($query11);
                            ?>
                            <option value="<?php echo $row11[0] ?>" id="<?php echo $row11[1] ?>" class="districts"><?php echo $row11[0] ?></option>
                            <?php } ?>
                        </select>
                        <select name="tambon" id=""  class="box tambon" required>
                            <option value="" hidden>โปรดเลือกตำบล</option>
                            <?php
                                $sql12 = "SELECT Distinct TambonThaiShort,DistrictThaiShort FROM province";
                                $query12 = mysqli_query($conn,$sql12);
                                $num12 = mysqli_num_rows($query12);
                                for($i12=0;$i12<$num12;$i12++){
                                    $row12 = mysqli_fetch_row($query12);
                            ?>
                            <option value="<?php echo $row12[0] ?>" id="<?php echo $row12[1] ?>" class="tambons"><?php echo $row12[0] ?></option>
                            <?php } ?>
                        </select>
                        <select name="postcode" id="" class="box postcode" required>
                            <option value="" hidden>โปรดเลือกรหัสไปรษณีย์ </option>
                            <?php
                                $sql12 = "SELECT Distinct PostCode,TambonThaiShort FROM province";
                                $query12 = mysqli_query($conn,$sql12);
                                $num12 = mysqli_num_rows($query12);
                                for($i12=0;$i12<$num12;$i12++){
                                    $row12 = mysqli_fetch_row($query12);
                            ?>
                            <option value="<?php echo $row12[0] ?>" id="<?php echo $row12[1] ?>" class="postcodes"><?php echo $row12[0] ?></option>
                            <?php } ?>
                        </select>
                    </div>
			</div>
		</div>
	<div class="box" >
	<div class="apartment">
	<p><b>โปรดเลือกห้องพักที่คุณต้องการ</b></p>
	<h4>มีให้เลือกทั้งหมด 3 ชั้นแต่ละชั้นจะแตกต่างออกไป<br>
	ชั้น 2 จะได้รับเป็นห้องแอร์ ส่วน ชั้น 3 และ 4 จะได้รับเป็นห้องปกติ <br> ราคาห้องชั้น 2 อยู่ที่ 4,000 บาท <br>ส่วนห้องชั้น 3 ราคา 3,200 บาท <br>และห้องชั้น 4 ราคา 3,000 บาท</h4><br>
	<?php
    	for($i=2;$i<=4;$i++){
    	?>  
    	<p style="text-align:left;">ชั้นที่ <?php echo $i ?></p>
        <div class="floor">
            <div class="row">

                <div class="rooms <?php echo $i,0 ?>1">
					<p style="font-size:15px; color:white; font-size:10px;"><?php echo "BS", $i,0?>1</p>
                    <p style="font-size:10px; display:none;" ><?php echo "BS", $i,0 ?>1</p>
                </div>
                <?php
                $s = 9;
                	for($is=2;$is<=$s;$is++){
                ?>
                <div class="rooms <?php echo $i,0,$is ?>">
				<p style="font-size:15px; color:white; font-size:10px;"><?php echo "BS", $i,0,$is?></p>
                	<p style="font-size:10px; display:none;"><?php echo "BS", $i,0,$is ?></p>
                </div>
                <?php } ?>
            </div>
            <div class="row">
                <div class="rooms <?php echo $i,0,9 ?>">
				<p style="font-size:15px; color:white; font-size:10px;"><?php echo "BS", $i,10?></p>
                    <p style="font-size:10px; display:none;"><?php echo "BS", $i,10 ?></p>
                </div>
                <div class="rooms <?php echo $i,0,11 ?>">
				<p style="font-size:15px; color:white; font-size:10px;"><?php echo "BS", $i,11?></p>
                    <p style="font-size:10px; display:none;"><?php echo "BS", $i,11?></p>
                </div>
                <?php 
                	for($ss=2;$ss<9;$ss++){
                ?>
                <div class="rooms <?php echo $i,2,$ss ?>">
					<p style="font-size:15px; color:white; font-size:10px;"><?php echo "BS", $i,1,$ss?></p>
                	<p style="font-size:10px; display:none;"><?php echo "BS", $i,1,$ss ?></p>
                </div>
                <?php } ?>
            </div>
        </div>
        <?php } ?>
        <div style="display:flex; align-items: center; height:50px; justify-content: center;"><div class="squre white"></div> <p>ห้องว่าง</p> <div class="squre orange"></div><p>มีผู้จองแล้ว</p><div class="squre red"></div><p>มีผู้เช่าแล้ว</p></div> 
    	</div>
            <input type="text" name="type" class="box" style="background-color:#FFFF;" placeholder="โปรดเลือกห้องที่คุณต้องการ" id="selecroom">
			<div class="box">
			<p><b>โปรดเลือกวันที่จะเข้าพัก : <b></p>
        	<input type="date" name="mdy" class="box1" required="required" min="<?php echo date('Y-m-d');?>">
			</div>
            </div>
		<ul style="display:none;">
        <?php
            $sql = "SELECT type FROM room WHERE Status = 'wait'";
            $query = mysqli_query($conn,$sql);
            $num = mysqli_num_rows($query);
            for($i=0;$i<$num;$i++){
                $row = mysqli_fetch_row($query);
        ?>
		    <li class="roomid"><?php echo $row[0] ?></li>
        <?php } ?>
    </ul>
	<ul style="display:none;">
        <?php
            $sql222 = "SELECT type FROM room WHERE Status = 'active'";
            $query222 = mysqli_query($conn,$sql222);
            $num222 = mysqli_num_rows($query222);
            for($i222=0;$i222<$num222;$i222++){
                $row222 = mysqli_fetch_row($query222);
        ?>
        <li class="roomide"><?php echo $row222[0] ?></li>
        <?php } ?>
    </ul>
	<br>
	<h2>โปรดจำอีเมลและรหัสผ่านของคุณเพื่อใช้ในการล็อคอินเข้าสู่ระบบ</h2>
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
		<input type="text" name="reserve" value="<?php echo DateThai("$strDate");?>" hidden>
		<br><hr>
      	<input type="submit" name="submit" class="btn" value="จองห้องพัก"><br>
   </form>
   </div></div></div>
	</body>
	<div class="footer" id="Contact">
		<div class="row">
  			<div class="column1">
    			<h2>สนใจสอบถามรายละเอียดเพิ่มเติม</h2>
				<h2>เบอร์โทรติดต่อ</h2>
    			<p><a class="atel" href="tel:0909780047">090 - 978 - 0047</a></p>
  			</div>
  			<div class="column1"><br><br>
			  <p><div class="fb-page" data-href="https://www.facebook.com/%E0%B8%9A%E0%B8%B5%E0%B9%80%E0%B8%AD%E0%B8%AA%E0%B8%AD%E0%B8%9E%E0%B8%B2%E0%B8%A3%E0%B8%95%E0%B9%8C%E0%B9%80%E0%B8%A1%E0%B8%99%E0%B8%97%E0%B9%8C-108827614691245/" data-tabs="" data-width="310" data-height="" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="false"><blockquote cite="https://www.facebook.com/%E0%B8%9A%E0%B8%B5%E0%B9%80%E0%B8%AD%E0%B8%AA%E0%B8%AD%E0%B8%9E%E0%B8%B2%E0%B8%A3%E0%B8%95%E0%B9%8C%E0%B9%80%E0%B8%A1%E0%B8%99%E0%B8%97%E0%B9%8C-108827614691245/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/%E0%B8%9A%E0%B8%B5%E0%B9%80%E0%B8%AD%E0%B8%AA%E0%B8%AD%E0%B8%9E%E0%B8%B2%E0%B8%A3%E0%B8%95%E0%B9%8C%E0%B9%80%E0%B8%A1%E0%B8%99%E0%B8%97%E0%B9%8C-108827614691245/">บี.เอส.อพารต์เมนท์</a></blockquote></div>
			  <script async defer crossorigin="anonymous" src="https://connect.facebook.net/th_TH/sdk.js#xfbml=1&version=v14.0" nonce="QKCty8H1"></script>
  			</div>
			  <div class="column1">
    			<h2>ช่องทางออนไลน์ </h2>
				<h2>Line : b.s.apart หรือกดที่ปุ่มเพิ่มเพื่อนได้เลย</h2>
				<br><br><br><div id="fb-root"></div> <p><a class="aline" href= "https://line.me/ti/p/~b.s.apart" target="_blank"><img src= "https://scdn.line-apps.com/n/line_add_friends/btn/th.png" alt= "Add Friend" width= "90px"></a></p>
				</div>	
			</div>
	</div>
	</div>
	</div>
</html>
<script src="Js/script01.js"></script>
<script src="Js/booking.js"></script>