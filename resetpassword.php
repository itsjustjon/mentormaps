<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    require "./config.php";
    require "./db.php";
    require "./mailsender.php";
    $result=$db->query("SELECT * FROM `logins` WHERE `EMAIL` = '".$_POST['email']."';");
    while($r=mysqli_fetch_assoc($result)){
        $key = $r['KEY'];
    }
    if(isset($key)){
        sendEmail($sendgrid_api_key, $_POST['email'], 'MentorMaps: Reset Password', file_get_contents("./pages/reset_password_email.php"));
        die("sent reset email");
    }else{
        die("so such email in db");
    }
}else{
    require "./pages/default_header.html";
    ?>
            <article id="main">
                        <header>
                            <h2>
                        <a href="index.php">Reset Password</a>
                    </h2>
                        </header>
                <section class="wrapper style5">
                    <div class="inner">
    
    <form method="post">
        Email: <input type="text" name="email" /><br/>
        <input type="submit" value="reset" />
    </form>

    <?php
    require "./pages/default_footer.html";
}
?>