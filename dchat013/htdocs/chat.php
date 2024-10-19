
<?php
                require 'db.php';
                session_start();
                $userquery = "SELECT * FROM `kullaniciip`";
                $user_run = mysqli_query($con, $userquery);
                
                    $query = "SELECT * FROM chat_info ORDER BY id DESC";
                    $query_run   = mysqli_query($con,$query);                
                    while($query_row = mysqli_fetch_assoc($query_run)):
                    $sender = $query_row['senderid'];
                    $adminsorgu = "SELECT * FROM kullaniciip WHERE `id` = '$sender'";
                    $adminsorgu_run   = mysqli_query($con,$adminsorgu);
                    $admin_row = mysqli_fetch_assoc($adminsorgu_run);
                    //Kimin gönderdiğini kontrol ediyoruz id ile bu sayede gönderen kişi kendisi ise sağda gözüküecek
                    if ($query_row['senderid'] == $_SESSION['uid']) {
                        $rl = "sagmsg";
                    } else{
                        $rl = "solmsg";
                    }
                    //Üsttekinin aynısı sadece admin ise kırmızı oluyo
                    if ($adminsorgu_run->num_rows >= 1 and $admin_row['admin'] == TRUE) {
                        $adminmi = "admintrue";
                    } else{
                        $adminmi = "adminfalse";
                    }
                    
                    ?>     
                
                <div id ="chat_data">
                    <h1 class="sayici">Kayıtlı Kullanıcı Sayısı: <?php echo($user_run->num_rows); ?></h1>
                </div>
                <div class=<?php echo($rl)?> >
                    <span class=<?php echo($adminmi)?>><?php echo htmlentities($query_row['name']).'<br>'; ?></span>
                    <span class="message"><?php echo "<div>". htmlentities($query_row['msg']) ."</div>"; ?></span>
                    <span class="date"><?php echo formatDate($query_row['date']); ?></span>
                </div>
<!--
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                <span></span>
-->
                
                <?php endwhile; ?>

                <style type="text/css">
@import url('https://fonts.googleapis.com/css2?family=Ubuntu:wght@300&display=swap');
.adminfalse {
font-size: 30px;
font-family: 'Ubuntu', sans-serif;
color: #F2F3F5;
}
.admintrue {
font-size: 40px;
font-family: 'Ubuntu', sans-serif;
color: #F5004F;
}
.sayici {
font-size: 20px;
font-family: 'Ubuntu', sans-serif;
color: #F2F3F5;
position: fixed;
top: 0;
right: 10%;
}  
.message {
font-size: 20px;
font-family: 'Ubuntu', sans-serif;
color: #DBDEE1;
}
.date{
font-size: 15px;
font-family: 'Ubuntu', sans-serif;
color: #9197A0;
} 
.sagmsg{
    text-align: right;
}
body {
    margin-bottom: 60px;
}
</style>