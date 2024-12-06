<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta http-equiv="Cache-Control" content="no-cache" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>KAKAO 컨텐트 상세보기</title>
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
    <script type="text/javascript" src="/public/common/script/main.js"></script>                 
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
    
    <section id="article-node">
        <div class="cont_left padd20">
            <img src="/public/images/cont.png" alt="cont" />
        </div>
        <!-- cont_left END -->

        <div class="cont_right padd20">
            <h1>CONTENT NAME</h1>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing</p>
            <div class="cont_description">
                <p>CONTENT DESCRIPTION</p>
                <span>
                    *24시간 지속되는 피부 보습은 물론 존슨즈 만의 고유한 베이비 파우더 향으로 사랑스러움을 더해 보세요.<br />

                    *24시간 지속되는 보습으로 건강하고 촉촉한 피부<br />

                    *쉽게 건조해지는 연약한 아기 피부에 수분 보호막 형성<br />

                    *저자극 포뮬러<br />
                    *아기 피부를 부드럽게 마사지하며 교감의 순간을 만들어 보세요.<br />

                    *피부과 테스트 완료<br />

                    *32명 여성을 대상으로 24시간 실험한 결과, 2013, AP Skin Test Center                 
                </span>
                
            </div>
        </div>
        <!-- cont_right END -->
    </section>
    <!-- contentBox END -->
    
    <?php include_once APPPATH.'views/footer.php'; ?>
    
</body>   
</html>