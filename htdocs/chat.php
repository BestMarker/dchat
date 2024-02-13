<style type="text/css">
@import url('https://fonts.googleapis.com/css2?family=Ubuntu:wght@300&display=swap');
.name {
font-size: 30px;
font-family: 'Ubuntu', sans-serif;
color: #F2F3F5;
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
body {
    margin-bottom: 60px;
}
</style>
<?php
                require 'db.php';
                
                    $query = "SELECT * FROM chat_info ORDER BY id DESC";
                    $query_run   = mysqli_query($con,$query);
//                    $query_run =$con -> query($query);
                
//                    $query_array = mysql_fetch_assoc($query_run)
                    
                    while($query_row = mysqli_fetch_assoc($query_run)):?>
                
                <div id ="chat_data">
                </div>
                <span class="name"><?php echo htmlentities($query_row['name']).'<br>'; ?></span>
                <span class="message"><?php echo "<div>". htmlentities($query_row['msg']) ."</div>"; ?></span>
                <span class="date"><?php echo formatDate($query_row['date']); ?></span>
<!--
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                <span></span>
-->
                
                <?php endwhile; ?>