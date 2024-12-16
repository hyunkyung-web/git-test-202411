<?php

//페이징 파트에 시작할 페이지번호와 블럭사이즈 만큼 더한 마지막 페이지 번호
$pagingStart = floor(($page-1) / $blockSize) * $blockSize + 1;
$pagingEnd = floor(( ($page-1)+$blockSize ) / $blockSize) * $blockSize;
$prevPage = $pagingStart-1;
$nextPage = $pagingEnd+1;

//총 페이지 수가 블럭사이즈보다 작은 경우 마지막 페이지 번호는 총 페이지 수로 설정
if ($pagingEnd >= $totalPage) { $pagingEnd = $totalPage; }

?>

<div id="pagination">
    <ul class="pagination">
    	<li class="page-item first"><a href="javascript:<?php echo $listFnc.'(1)';;?>" class="page-link">First</a></li><?php 
        if($prevPage>0){?>    
    		<li class="page-item prev"><a href="javascript:<?php echo $listFnc.'('.$prevPage.')';;?>" class="page-link">Prev</a></li><?php
        }?><?php 
        for ($i=$pagingStart; $i<=$pagingEnd; $i++) {?>
    		<li class="page-item <?php echo $page==$i ? 'active' : '';?>"><a href="javascript:<?php echo $listFnc.'('.$i.')';?>" class="page-link"><?php echo $i;?></a></li><?php 
        }?><?php 
        if($totalPage > $pagingEnd){?>    	
    	<li class="page-item next"><a href="javascript:<?php echo $listFnc.'('.$nextPage.')';;?>" class="page-link">next</a></li><?php 
        }?>
    	<li class="page-item last"><a href="javascript:<?php echo $listFnc.'('.$totalPage.')';;?>" class="page-link">End</a></li>
    </ul>
</div>