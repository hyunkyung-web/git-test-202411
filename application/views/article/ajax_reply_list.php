<div class="react_area">
    <img src="<?php echo $my_like_cnt>0 ? '/public/images/icon/icon_heart_full.png' : '/public/images/icon/icon_heart.png';?>" alt="icon_heart" class="icon_heart">
    <span>좋아요 <span class="coountLike"><?php echo $like_cnt;?></span>개</span>
    <img src="/public/images/icon/icon_comment.png" alt="icon_comment" class="icon_comment">
    <span>댓글 <span class="countComment"><?php echo $reply_cnt;?></span>개</span>
</div>   

<div class="comments_area padd10"><?php 
foreach($reply_list as $row){?>
    <div class="comment_box">
        <span class="c_name"><?php echo $row["member_nm"];?></span>        
        <span class="delete"><i class="fa-solid fa-minus"></i></span>
        <span class="c_text"><?php echo $row["reply_text"];?></span>
        <span class="c_date"><?php echo date('y-m-d H:i', strtotime($row["wdate"]));?></span>        
    </div><?php
}?>
	
</div>
<!-- 
<button type="button" class="btn_more">더보기 +</button>
<button type="button" class="btn_fold">댓글 접기 ↑</button>
 -->

<script>

// 댓글 버튼 눌렀을때 입력창 활성화
    $(".icon_comment").click(function () {
        $("#reply_text").focus();
    });

    $(".icon_heart").click(function(){
    	nodeSaveLike();
    });
     
</script>

