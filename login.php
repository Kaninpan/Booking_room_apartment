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
    <title>B.S. Apartment | เข้าสู่ระบบ </title>
</head>
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
<?php
    include 'config.php';
    session_start();

    if(isset($_POST['submit'])){
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $pass = mysqli_real_escape_string($conn, md5($_POST['password']));

        $select = mysqli_query($conn, "SELECT * FROM `user_info` WHERE email = '$email' AND password = '$pass'") or die('query failed');

        if(mysqli_num_rows($select) > 0){
            $row = mysqli_fetch_array($select);
               $_SESSION["id"] = $row["id"];
               $_SESSION["Class"] = $row["Class"];
            if($_SESSION["Class"]=="Admin"){ 
                Header("Location: Admin_info.php");                     
             }
            if ($_SESSION["Class"]=="User"){  
                 Header("Location: user_info.php");                                      
            }
            }else{
                $message[] = 'โปรดกรอกรหัสผ่านหรืออีเมลให้ถูกต้อง';
            }
        }

        if(isset($message)){
             foreach($message as $message){
              echo '<div class="message" onclick="this.remove();">'.$message.'</div>';
    }
        }


        mysqli_close($conn);
?>
<body>
    <div class="form-containerLG">
        <form action="" method="post">
            <h1>โปรดเข้าสู่ระบบของคุณ</h1><br>
                <div style="display:flex; align-items: left;"><b><p>อีเมล</p></b></div>
                <input type="email" name="email" class="box" required="required" placeholder="กรอกอีเมลของคุณ">
                <div style="display:flex; align-items: left;"><b><p>รหัสผ่าน</p></b></div>
                <input type="password" name="password" class="box" required="required" placeholder="โปรดกรอกรหัสผ่านของคุณ">
                <button type="submit" name="submit" class="btn">เข้าสู่ระบบ</button><br><br><br><br>
                <p> โปรดทำการจองห้องพักก่อนเข้าสู่ระบบ</p><br>
                <a href = "contract.php" class="btn">คลิกที่นี่เพื่อเปิดบัญชีจองห้องพัก</a><br>
                </form>
            </div>
        </div>
    </div>
</body>
</html>