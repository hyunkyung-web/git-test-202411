<?php 
    $menuList = [
        "100"=>"Contents-List",
        "110"=>"Contents-Informaton", 
        "200"=>"Template-List", 
        "210"=>"Template-Information", 
        "800"=>"HCP-List",
        "810"=>"HCP-Information", 
        "900"=>"User-List",
        "910"=>"User-Information", 
    ];
?>


<div class="main-content-top">
        <h3><?php echo $menuList[$menuNum];?></h3>
        <nav>
            <ul class="nav-links">
                <!-- 검색, 로그아웃, user -->
                <li><i class="fa-solid fa-magnifying-glass"></i></li>
                <li><i class="fa-solid fa-power-off"></i></li>
                <li><span style="color: #c6c5cd ">Hi</span>, <span>디웨이브</span></li>
            </ul>
        </nav>
</div>