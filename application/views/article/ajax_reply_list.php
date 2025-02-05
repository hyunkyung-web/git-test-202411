<div class="react_area">
    <img src="/public/images/icon/icon_heart.png" alt="icon_heart" class="icon_heart">
    <span>좋아요 <span class="coountLike">4</span>개</span>
    <img src="/public/images/icon/icon_comment.png" alt="icon_comment" class="icon_comment">
    <span>댓글 <span class="countComment">3</span>개</span>
</div>   

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


