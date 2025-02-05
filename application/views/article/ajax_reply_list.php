<div class="comments_area padd10"><?php 
foreach($data as $row){?>
    <div class="comment_box">
        <span class="c_name"><?php echo $row["member_nm"];?></span>        
        <span class="delete"><i class="fa-solid fa-minus"></i></span>
        <span class="c_text"><?php echo $row["reply_text"];?></span>
        <span class="c_date"><?php echo date('y-m-d H:i', strtotime($row["wdate"]));?></span>        
    </div><?php 
}?>
</div>


