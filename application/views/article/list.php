<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta http-equiv="Cache-Control" content="no-cache" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>KAKAO 컨텐트 리스트</title>
	<meta property="og:author" content="d'wave">
	<meta property="og:type" content="website">
	<meta property="og:title" content="닥터웨이브" />
	<meta property="og:description" content="닥터웨이브" />
	<meta property="og:image" content="https://dr-wave.co.kr/public/images/logo.png"/>
	<meta property="og:url" content="" />
	<link rel="icon" type="image/png" href="/public/common/css/logo_ics.png" />
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous" />
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR&family=Roboto&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="/public/common/css/reset.css?ver=2205031100" />
    <link rel="stylesheet" href="/public/common/css/main.css" />    
    <script type="text/javascript" src="/public/common/js/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="/public/common/js/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="/public/common/js/jquery.touchSwipe.min.js"></script>
    <script type="text/javascript" src="/public/common/js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="/public/common/js/jquery.ui.touch-punch.min.js"></script>    
    <script type="text/javascript" src="/public/common/common.js?ver=2205031000"></script>
    <script type="text/javascript" src="/public/common/local.js"></script>                 
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
    
    <section id="article" class="flex_SB_center">
        <h2>Contents Lists</h2>
        <p>Sed ut perspiciatis unde omnis iste<br />natus error sit voluptatem</p>
        <div id="article-each" class="flex_SB_center">
            <div class="contents-list article-each">
                <a href="/member/verify">
                    <img src="/public/images/work_sign_thumb.png" alt="article 1" class="cont-thumb article-thumb" />
                    <p class="name">Login</p>
                </a>
            </div>

            <div class="contents-list article-each">
                <a href="/member/sign_up">
                    <img src="/public/images/work_account.png" alt="article 2" class="cont-thumb article-thumb" />
                    <p class="name">Create Account</p>
                </a>
            </div>

            <div class="contents-list article-each">
                <a href="node">
                    <img src="/public/images/work3.png" alt="article 3" class="cont-thumb article-thumb" />
                    <p class="name">voluptatem</p>
                </a>
            </div>

            <div class="contents-list article-each">
                <a href="#">
                    <img src="/public/images/work_contact.png" alt="article 4" class="cont-thumb article-thumb" />
                    <p class="name">Contact</p>
                </a>
            </div>
            
            <div class="contents-list article-each">
                <img src="/public/images/work1.png" alt="article 4" class="cont-thumb article-thumb" />
                <p class="name">voluptatem</p>
            </div>
            <div class="contents-list article-each">
                <img src="/public/images/work2.png" alt="article 4" class="cont-thumb article-thumb" />
                <p class="name">voluptatem</p>
            </div>
        </div>
    </section>
    
    <?php include_once APPPATH.'views/footer.php'; ?>
</body>   
</html>