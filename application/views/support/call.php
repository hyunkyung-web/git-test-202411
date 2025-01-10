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

    <div class="member-wrap support-wrap">
        <div class="container">
            <div class="member_logo support">
                <h1>고객 지원</h1>
            </div>
            
            <div class="member-container call-container">
                <p class="btn_request">* 방문 요청, 자료 요청 등을 할 수 있습니다.</p>           
                <form class="signup-form call-form" id="frm1" name="frm1">
                    <div class="form_item call_item">
                        <div class="chatBot">
                            <img src="/public/images/icon/icon_face.png" alt="icon_bot" class="icon_bot">
                            <input type="text"  name="partner" id="partner" placeholder="담당자를 선택해주세요." required readonly="readonly" value="dwave"/>
                        </div>
                        <div class="select_contact">담당자 검색</div>
                        <div class="partner_list">
                            <table>
                                
                            </table>
                        </div>
                    </div>

                    <div class="form_item call_item">
                        <div class="chatBot">
                            <img src="/public/images/icon/icon_face.png" alt="icon_bot" class="icon_bot">
                            <span id="type">요청 사항을 선택해주세요.</span>
                        </div>
                        <div class="call_box">
                            <label for="call_visit">
                                <input type="radio" name="type" id="call_visit" value="" class="chk_type">
                                <span class="chk_img"></span>
                                <span class="type_val">방문요청</span>
                            </label>
                            
                            <label for="call_doc">
                                <input type="radio" name="type" id="call_doc" value="" class="chk_type">
                                <span class="chk_img"></span>
                                <span class="type_val">자료요청</span>
                            </label>
                            
                            <label for="call_etc">
                                <input type="radio" name="type" id="call_etc" value="" class="chk_type">
                                <span class="chk_img"></span>
                                <span class="type_val">기타</span>
                            </label>
                        </div>
                    </div>

                    <div class="form_item call_item inform_box visit_box">
                        <div class="chatBot">
                            <img src="/public/images/icon/icon_face.png" alt="icon_bot" class="icon_bot">
                            <span>아래 정보를 입력해주세요.</span>
                        </div>
                        <div class="informs visit">
                            <!-- 날짜 시간 요청내용 -->
                            <div class="inform date">
                                <span>날짜</span>
                                <input type="date" id="date" name="date" placeholder="날짜 선택" />
                            </div>

                            <div class="inform time">
                                <span>시간</span>
                                <input type="time" id="time" name="time" />
                            </div>
                            
                            <div class="inform text">
                                <span>요청 내용</span>
                                <textarea name="detail" id="call_detail" rows="4" placeholder="요청 내용을 입력하세요." ></textarea>
                            </div>
                            
                        </div>
                    </div>
                    <div class="form_item call_item inform_box doc_box">
                        <div class="chatBot">
                            <img src="/public/images/icon/icon_face.png" alt="icon_bot" class="icon_bot">
                            <span>아래 정보를 입력해주세요.</span>
                        </div>
                        <div class="informs doc">
                            <!-- 요청내용 -->
                            <div class="inform text">
                                <span>요청 내용</span>
                                <textarea name="detail" id="doc_detail" rows="4" placeholder="요청 내용을 입력하세요." ></textarea>
                            </div>
                            
                        </div>
                    </div>

                    <button type="button" class="btn_request">요청하기</button>
                </form>
            </div>
        </div>
    </div>
    
    <?php include_once APPPATH.'views/footer.php'; ?>

</body>   
</html>