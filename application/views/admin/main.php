<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta http-equiv="Cache-Control" content="no-cache" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>DrRound Home</title>
	<meta property="og:author" content="d'wave">
	<meta property="og:type" content="website">
	<meta property="og:title" content="닥터웨이브" />
	<meta property="og:description" content="닥터웨이브" />
	<meta property="og:image" content="https://dr-wave.co.kr/public/images/logo.png"/>
	<meta property="og:url" content="" />
	<link rel="icon" type="image/png" href="/public/common/css/logo_ics.png" />
    <link rel="stylesheet" href="/public/common/css/fontawesome.all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR&family=Roboto&Manjari:wght@100;400;700&display=swapp" rel="stylesheet" />
    <link rel="stylesheet" href="/public/common/css/admin.css" />
    <script type="text/javascript" src="/public/common/js/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="/public/common/js/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="/public/common/js/jquery.touchSwipe.min.js"></script>
    <script type="text/javascript" src="/public/common/js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="/public/common/js/jquery.ui.touch-punch.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twbs-pagination/1.4.1/jquery.twbsPagination.min.js"></script>

    <script src="/public/common/script/fontawesome.all.min.js"></script>
    <script type="text/javascript" src="/public/common/common.js?ver=2205031000"></script>
    <script defer type="text/javascript" src="/public/common/script/admin.js"></script>
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



    <!-- aside, button -->
    <div class="container">
        <?php include_once APPPATH.'views/admin/inc_aside.php'; ?>
        <div class="main-content-wrap">

            <!-- flex 1 -->
            <div class="main-content-top">
                <h3>Contents</h3>
                <nav>
                    <ul class="nav-links">
                        <!-- 검색, 로그아웃, user -->
                            <li><i class="fa-solid fa-magnifying-glass"></i>
                            </i>
                            </li>
                            <li><i class="fa-solid fa-power-off"></i></li>
                            <li><span style="color: #c6c5cd ">Hi</span>, <span>디웨이브</span></li>

                    </ul>
                </nav>
            </div>
            <!-- flex 2 -->
            <main class="main-content">
                <div>
                    <header class="main-header">
                        <div class="main-header-firstLine">
                            <h3>Contents <br />
                                <span>Message Target</span>
                            </h3>
                            <!-- button 추가 -->
                            <div>
                                <button type="button" class="add-user btn1" onclick="javascript: openMenu(110);"><i class="fa-solid fa-circle-plus"></i> Add</button>
                                <button type="button" class="delete-user btn2" onclick="javascript: openMenu(110);"><i class="fa-solid fa-circle-minus"></i> Del</button>
                            </div>
                        </div>

                        <div class="search-bar">
                            <select class="category-select list-select">
                                <option value="">구분</option>
                                <option value="category1">공지</option>
                                <option value="category2">뉴스</option>

                            </select>
                            <input type="text" placeholder="Search..." class="search-input">
                            <button type="button" class="search-button">Search</button>
                        </div>
                    </header>
                    <table class="content-table">
                        <thead>
                            <tr>
                                <th align="center">
                                    <label>
                                        <input type="checkbox">
                                        <span class="custom-checkbox"></span>
                                    </label>
                                </th>
                                <th>No</th>
                                <th>구분</th>
                                <th>제목</th>
                                <th>작성자</th>
                                <th>작성일</th>
                            </tr>
                        </thead>
                        <tbody id="item-list">
                            <tr>
                                <td align="center">
                                    <label>
                                        <input type="checkbox">
                                        <span class="custom-checkbox"></span>
                                    </label>
                                </td>
                                <td>1</td>
                                <td>공지</td>
                                <td>첫 번째 콘텐츠</td>
                                <td>홍길동</td>
                                <td>2024-12-01</td>
                            </tr>
                            <tr>
                                <td align="center">
                                    <label>
                                        <input type="checkbox">
                                        <span class="custom-checkbox"></span>
                                    </label>
                                </td>
                                <td>2</td>
                                <td>뉴스</td>
                                <td>두 번째 콘텐츠</td>
                                <td>김철수</td>
                                <td>2024-12-02</td>
                            </tr>
                            <tr>
                                <td align="center">
                                    <label>
                                        <input type="checkbox">
                                        <span class="custom-checkbox"></span>
                                    </label>
                                </td>
                                <td>1</td>
                                <td>공지</td>
                                <td>첫 번째 콘텐츠</td>
                                <td>홍길동</td>
                                <td>2024-12-01</td>
                            </tr>
                            <tr>
                                <td align="center">
                                    <label>
                                        <input type="checkbox">
                                        <span class="custom-checkbox"></span>
                                    </label>
                                </td>
                                <td>2</td>
                                <td>뉴스</td>
                                <td>두 번째 콘텐츠</td>
                                <td>김철수</td>
                                <td>2024-12-02</td>
                            </tr>
                            <tr>
                                <td align="center">
                                    <label>
                                        <input type="checkbox">
                                        <span class="custom-checkbox"></span>
                                    </label>
                                </td>
                                <td>1</td>
                                <td>공지</td>
                                <td>첫 번째 콘텐츠</td>
                                <td>홍길동</td>
                                <td>2024-12-01</td>
                            </tr>
                            <tr>
                                <td align="center">
                                    <label>
                                        <input type="checkbox">
                                        <span class="custom-checkbox"></span>
                                    </label>
                                </td>
                                <td>2</td>
                                <td>뉴스</td>
                                <td>두 번째 콘텐츠</td>
                                <td>김철수</td>
                                <td>2024-12-02</td>
                            </tr>
                            <tr>
                                <td align="center">
                                    <label>
                                        <input type="checkbox">
                                        <span class="custom-checkbox"></span>
                                    </label>
                                </td>
                                <td>1</td>
                                <td>공지</td>
                                <td>첫 번째 콘텐츠</td>
                                <td>홍길동</td>
                                <td>2024-12-01</td>
                            </tr>
                            <tr>
                                <td align="center">
                                    <label>
                                        <input type="checkbox">
                                        <span class="custom-checkbox"></span>
                                    </label>
                                </td>
                                <td>2</td>
                                <td>뉴스</td>
                                <td>두 번째 콘텐츠</td>
                                <td>김철수</td>
                                <td>2024-12-02</td>
                            </tr>
                            <tr>
                                <td align="center">
                                    <label>
                                        <input type="checkbox">
                                        <span class="custom-checkbox"></span>
                                    </label>
                                </td>
                                <td>1</td>
                                <td>공지</td>
                                <td>첫 번째 콘텐츠</td>
                                <td>홍길동</td>
                                <td>2024-12-01</td>
                            </tr>
                            <tr>
                                <td align="center">
                                    <label>
                                        <input type="checkbox">
                                        <span class="custom-checkbox"></span>
                                    </label>
                                </td>
                                <td>2</td>
                                <td>뉴스</td>
                                <td>두 번째 콘텐츠</td>
                                <td>김철수</td>
                                <td>2024-12-02</td>
                            </tr>
                            <tr>
                                <td align="center">
                                    <label>
                                        <input type="checkbox">
                                        <span class="custom-checkbox"></span>
                                    </label>
                                </td>
                                <td>1</td>
                                <td>공지</td>
                                <td>첫 번째 콘텐츠</td>
                                <td>홍길동</td>
                                <td>2024-12-01</td>
                            </tr>
                            <tr>
                                <td align="center">
                                    <label>
                                        <input type="checkbox">
                                        <span class="custom-checkbox"></span>
                                    </label>
                                </td>
                                <td>2</td>
                                <td>뉴스</td>
                                <td>두 번째 콘텐츠</td>
                                <td>김철수</td>
                                <td>2024-12-02</td>
                            </tr>
                            <!-- 추가 콘텐츠 -->
                        </tbody>
                    </table>

                    <?php include_once APPPATH.'views/admin/inc_paging.php'; ?>
                </div>



            </main>

        </div>
        <!-- //main-content-wrap -->
    </div>
    <!-- <?php include_once APPPATH.'views/admin/inc_footer.php'; ?> -->

</body>
</html>