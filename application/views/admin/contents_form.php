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
    <link rel="stylesheet" href="/public/common/css/fontawesome.all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR&family=Roboto&Manjari:wght@100;400;700&display=swapp" rel="stylesheet" />
    <link rel="stylesheet" href="/public/common/css/reset.css" />
    <link rel="stylesheet" href="/public/common/css/admin.css" />
    <script type="text/javascript" src="/public/common/js/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="/public/common/js/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="/public/common/js/jquery.touchSwipe.min.js"></script>
    <script type="text/javascript" src="/public/common/js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="/public/common/js/jquery.ui.touch-punch.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twbs-pagination/1.4.1/jquery.twbsPagination.min.js"></script>

    <script src="/public/common/script/fontawesome.all.min.js"></script>
    <script type="text/javascript" src="/public/common/common.js?ver=2205031000"></script>
    <script type="text/javascript" src="/public/common/smarteditor/js/HuskyEZCreator.js" charset="utf-8"></script>
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
            <?php include_once APPPATH.'views/admin/inc_header.php'; ?>
            <!-- flex 2 -->
            <main class="main-content">
                <div>
                    <!-- <header class="main-header">
                        <div class="main-header-firstLine">
                            <h3>Members <br />
                                <span>Message Target</span>
                            </h3>
                            <div>
                                <button type="button" class="add-user" onclick="javascript: openMenu(910);"><i class="fa-solid fa-circle-plus"></i> Add</button>
                                <button type="button" class="delete-user" onclick="javascript: openMenu(110);"><i class="fa-solid fa-circle-minus"></i> Del</button>
                                <button type="button" class="download-user" onclick="javascript: openMenu(110);"><i class="fa-solid fa-download"></i> Excel</button>
                            </div>
                        </div>

                        <div class="search-bar">
                            <select class="category-select">
                                <option value="">DEPT/BU</option>
                                <option value="category1">CMR</option>
                                <option value="category2">F&O</option>
                                <option value="category2">CE</option>
                            </select>
                            <input type="text" placeholder="Search..." class="search-input">
                            <button class="search-button">Search</button>
                        </div>
                    </header> -->
                    <form>
                        <table>
                            <colgroup>
                                <col style="width: 20%;">
                                <col style="width: 80%;">
                            </colgroup>
                            <!-- <thead>
                                <tr>
                                    <th>항목</th>
                                    <th>내용</th>
                                </tr>
                            </thead> -->
                            <tbody>
                                <tr>
                                    <th><label for="title">제목</label></th>
                                    <td><input type="text" id="title" name="title" /></td>
                                </tr>
                                <tr>
                                    <th><label for="category">게시 구분</label></th>
                                    <td>
                                        <select class="category-select form-select" id="category" name="category">
                                            <option value="">게시 구분</option>
                                            <option value="type1">일반</option>
                                            <option value="type2">공지</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>첨부 파일</th>
                                    <td class="add-file">
                                        <!-- <input type="file" /> -->
                                        <!-- <input class="upload-name" value="Add file..." placeholder="Add file..." readonly>
                                    <label for="file"> <i class="fa-solid fa-circle-check"></i> add file</label>
                                    <input type="file" id="file" style="display: none;"> -->

                                        <label for="file"> <i class="fa-solid fa-circle-check"></i> add file</label>
                                        <input type="file" id="file" name="file" style="display: none" onchange="updateFileName()" />
                                        <input class="upload-name" value="file.." placeholder="file.." readonly />
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2">
                                        <!-- froala 에디터 -->
                                        <!-- <div id="editor"> </div> -->
                                        <div id="smarteditor">
                                            <textarea name="editorTxt" id="editorTxt" cols="30" rows="10" style="width: 100%; height: 300px"></textarea>
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </form>

                    <div class="btn-wrap">
                        <button type="button" class="save-user form-btn"><i class="fa-solid fa-circle-plus"></i> save</button>
                        <button type="button" class="cancel-user form-btn" onclick="javascript: openMenu(100);"><i class="fa-solid fa-circle-minus"></i> cancel</button>
                    </div>
                </div>



            </main>

        </div>
        <!-- //main-content-wrap -->
    </div>
    <!-- <?php include_once APPPATH.'views/admin/inc_footer.php'; ?> -->



</body>
</html>