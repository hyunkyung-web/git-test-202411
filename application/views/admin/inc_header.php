<div class="main-content-top">
    <h3><?php echo $menu_title;?></h3>
    <nav>
        <ul class="nav-links">
            <!-- 검색, 로그아웃, user -->
            <li><i class="fa-solid fa-magnifying-glass"></i></li>
            <li><a href="/admin/logout"><i class="fa-solid fa-power-off"></i></a></li>
            <li><span style="color: #c6c5cd ">Hi</span>, <span><?php echo $this->session->userdata("user_nm");?></span></li>
        </ul>
    </nav>
</div>
<div class="system_msg"><span>dwdwdwd</span></div>
<!-- <div class="blind"></div> -->