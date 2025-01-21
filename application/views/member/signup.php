<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta http-equiv="Cache-Control" content="no-cache" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Sign up</title>
	<meta property="og:author" content="d'wave">
	<meta property="og:type" content="website">
	<meta property="og:title" content="닥터웨이브" />
	<meta property="og:description" content="닥터웨이브" />
	<meta property="og:image" content="https://dr-wave.co.kr/public/images/logo.png"/>
	<meta property="og:url" content="" />
	<link rel="icon" type="image/png" href="/public/common/css/logo_ics.png" />
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous" />
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR&family=Roboto&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="/public/common/css/user/main.css" />    
    <link rel="stylesheet" href="/public/common/css/fontawesome.all.min.css" />
    <script type="text/javascript" src="/public/common/js/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="/public/common/js/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="/public/common/js/jquery.touchSwipe.min.js"></script>
    <script type="text/javascript" src="/public/common/js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="/public/common/js/jquery.ui.touch-punch.min.js"></script>    
    <script src="/public/common/script/fontawesome.all.min.js"></script>
    <script type="text/javascript" src="/public/common/script/main.js"></script>
    <script type="text/javascript" src="/public/common/script/common.js"></script>
                 
	<!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-5Z935QD');</script>
    <!-- End Google Tag Manager -->
</head>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-NMXDBRXH4Y"></script>
<script>
	window.dataLayer = window.dataLayer || [];
  	function gtag(){dataLayer.push(arguments);}
  	gtag('js', new Date());	
  	gtag('config', 'G-NMXDBRXH4Y');
  
	gtag('event', 'screen_view', {
		'app_name': 'dr-wave.co.kr',
		'screen_name': 'Home'
	});
	
	
// 	$(function(){
// 		$("#btnGtag").click(function(){
// 			gtag('event', 'click_GTAG_BTN');
// 		});
// 	});
	
  
</script>

<body>    
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5Z935QD"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <?php include_once APPPATH.'views/header.php'; ?>

    <div class="member-wrap">
        <div class="container">
            <div class="member_logo">
                <h1>회원가입</h1>
            </div>
            
            <div class="member-container">                
                <form class="signup-form" id="frm1" name="frm1">
                    <div class="form_item user">
                        <input type="text" name="member_nm" id="member_nm" placeholder="이름(*필수입력)" required value="<?php echo $name;?>"/>
                    </div>

                    <div class="form_item phone">
                        <input type="tel"  name="cellphone" id="cellphone" placeholder="휴대전화번호(*필수입력)" maxlength="16" onkeyup="javascript: cmmOnNumber(this);" required  value="<?php echo $cellphone;?>"/>
                    </div>

                    <div class="form_item email">
                        <input type="email" name="member_email" id="member_email" placeholder="Email(*필수입력)" onblur="javsascript: cmmOnEmail(this);" required  value="<?php echo $email;?>"/>
                        <input type="hidden" name="uuid" id="uuid" value="<?php echo $uuid;?>"/>
                    </div>

                    <div class="form_item Hosp">
                        <input type="text"  name="biz_nm" id="biz_nm" placeholder="병원명(*필수입력)" required />
                    </div>

                    <div class="form_item Dept">
                        <input type="text"  name="specialty" id="specialty" placeholder="진료과목(*필수입력)" required />
                    </div>

                    <button type="button">가입하기</button>
                </form>
            </div>
        </div>
    </div>
    
    <?php include_once APPPATH.'views/footer.php'; ?>

</body>   
</html>