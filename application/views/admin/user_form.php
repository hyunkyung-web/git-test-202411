<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta http-equiv="Cache-Control" content="no-cache" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>사용자 추가</title>
	<meta property="og:author" content="d'wave">
	<meta property="og:type" content="website">
	<meta property="og:title" content="닥터웨이브" />
	<meta property="og:description" content="닥터웨이브" />
	<meta property="og:image" content="https://dr-wave.co.kr/public/images/logo.png"/>
	<meta property="og:url" content="" />
	<link rel="icon" type="image/png" href="/public/common/css/logo_ics.png" />
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous" />
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR&family=Roboto&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/4.0.11/css/froala_editor.pkgd.min.css">
    <link rel="stylesheet" href="/public/common/css/reset.css?ver=2205031100" />
    <link rel="stylesheet" href="/public/common/css/local_new.css" />
    <link rel="stylesheet" href="/public/common/css/admin/form.css" />

    <script type="text/javascript" src="/public/common/js/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="/public/common/js/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="/public/common/js/jquery.touchSwipe.min.js"></script>
    <script type="text/javascript" src="/public/common/js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="/public/common/js/jquery.ui.touch-punch.min.js"></script>
    <!-- Froala Editor JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/4.0.11/js/froala_editor.pkgd.min.js"></script>
    <script type="text/javascript" src="/public/common/common.js?ver=2205031000"></script>
    <script defer type="text/javascript" src="/public/common/local.js"></script>
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

    <header class="header">
        <!-- <h1></h1> -->
        <div class="logo"><img src="/public/common/images/dwave_pro_logo.png" alt=""></div>

    </header>
    <div class="container">
        <aside class="sidebar">
            <ul>
                <li>콘텐츠 관리</li>
                <li>사용자 관리</li>
                <li>설정</li>
                <li>로그아웃</li>
            </ul>
        </aside>

        <main class="main-content">
            <form>
                <table>
                    <colgroup>
                        <col style="width: 30%;">
                        <col style="width: 70%;">
                    </colgroup>

                    <tbody>
                        <tr>
                            <th>아이디</th>
                            <td>
                                <input type="text" name="userId" id="userId" style="max-width: 25%;" value="">
                                <button>중복확인</button>

                            </td>
                        </tr>


                        <tr>
                            <th>비밀번호</th>
                            <td><input type="password" /></td>
                        </tr>
                        <tr>
                            <th>비밀번호 확인</th>
                            <td><input type="password" /></td>
                        </tr>
                        <tr>
                            <th>성명</th>
                            <td><input type="text" /></td>
                        </tr>
                        <tr>
                            <th>이메일</th>
                            <td><input type="email" /></td>
                        </tr>
                        <tr>
                            <th>성명</th>
                            <td><input type="text" /></td>
                        </tr>
                        <tr>
                            <th>부서</th>
                            <td><input type="text" /></td>
                        </tr>

                        <tr>
                            <th>권한분류</th>

                            <td>
                                <input type="radio" id="userType_1" name="userType" value="userType" checked>
                                <label for="userType_1">일반</label>

                                <input type="radio" id="userType_2" name="userType" value="userType" checked>
                                <label for="userType_2">관리자</label>
                            </td>

                        </tr>
                        <tr>
                            <th>정보수신</th>
                            <td>
                                <input type="radio" name="optin" id="optin_2" value="N" checked>
                                <label for="optin_2">동의안함</label>
                                <input type="radio" name="optin" id="optin_1" value="Y">
                                <label for="optin_1">동의함</label>
				            </td>

                        </tr>
                        <tr>
                            <th>사용여부</th>
                            <td>
                                <input type="radio" name="useYn" id="useYn_1" value="Y" checked>
                                <label for="useYn_1">사용</label>
                                <input type="radio" name="useYn" id="useYn_2" value="N">
                                <label for="useYn_2">사용안함</label>
				            </td>
                        </tr>
                    </tbody>

                </table>
            </form>
            <div class="btn-wrap">
                <button class="save-content">저장</button>
                <button class="cancel">취소</button>
            </div>
        </main>


    </div>
    <footer class="footer">
        <p>© 2025 관리자</p>
    </footer>



</body>
</html>