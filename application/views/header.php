<header>
    <div class="header-container flex_SB_center padd0-20">
        <div class="logo" onclick="callData(1)">
            <img src="/public/images/main/logo01.png" alt="logo_main">
        </div>

        <div class="header-nav"><?php
        if(!empty($this->session->userdata["member_id"])){?>
            <div class="user-info logged-in">
                <img src="/public/images/icon/icon-user.png" alt="icon-user">
                <span class="greeting"><?php echo $this->session->userdata["member_nm"];?>님 안녕하세요.</span>
                <a class="logout-btn" href="/member/logount">로그아웃</a>
            </div><?php 
        }else {?>
            <div class="user-info logged-out">
                <img src="/public/images/icon/icon-user.png" alt="icon-user">
                <span class="greeting">회원 인증을 진행해 주세요.</span>
                <a class="logout-btn" onclick="callData(12)">회원인증</a>
            </div><?php 
        }?>

            <ul class="nav-links">
                <li onclick="callData(99)">채널바로가기</li>
                <li onclick="callData(12)" class="signup">회원가입</li>
                <li onclick="callData(4)">공지사항</li>
                <li onclick="callData(2)">학술정보</li>
                <li onclick="callData(3)">고객지원</li>
            </ul>
        </div>



        <!-- mobile -->

        <div class="menu-toggle">
            <!-- <input type="checkbox" /> -->
            <span></span>
            <span></span>
            <span></span>
        </div>

        <div class="hamburger-menu"><?php 
        if(!empty($this->session->userdata["member_id"])){?>
            <div class="user-info logged-in">
                <img src="/public/images/icon/icon-user.png" alt="icon-user">
                <span class="greeting"><?php echo $this->sesssion->userdata["member_nm"];?>님 안녕하세요.</span>
                <a class="logout-btn" href="/member/logout">로그아웃</a>
            </div><?php
        }else {?>
            <div class="user-info logged-out">
                <img src="/public/images/icon/icon-user.png" alt="icon-user">
                <span class="greeting">회원 인증을 해주세요.</span>
                <a class="logout-btn" onclick="callData(12)">회원인증</a>
            </div><?php 
        }?>

            <ul>
                <li onclick="callData(99)">채널바로가기</li>
                <li onclick="callData(12)" class="signup">회원가입</li>
                <li onclick="callData(4)">공지사항</li>
                <li onclick="callData(2)">학술정보</li>
                <li onclick="callData(3)">고객지원</li>
            </ul>
        </div>
    </div>
</header>