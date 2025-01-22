<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta http-equiv="Cache-Control" content="no-cache" />
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no, maximum-scale=1, width=device-width" />
	<title>Message List</title>
	<meta property="og:author" content="d'wave">
	<meta property="og:type" content="website">
	<meta property="og:title" content="닥터웨이브" />
	<meta property="og:description" content="닥터웨이브" />
	<meta property="og:image" content="https://dr-wave.co.kr/public/images/logo.png"/>
	<meta property="og:url" content="" />
	<link rel="icon" type="image/png" href="/public/common/css/logo_ics.png" />
    <link rel="stylesheet" href="/public/common/css/fontawesome.all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR&family=Roboto&Manjari:wght@100;400;700&display=swapp" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/public/common/css/reset.css" />
    <link rel="stylesheet" href="/public/common/css/admin.css" />
    <script type="text/javascript" src="/public/common/js/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="/public/common/js/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="/public/common/js/jquery.touchSwipe.min.js"></script>
    <script type="text/javascript" src="/public/common/js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="/public/common/js/jquery.ui.touch-punch.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twbs-pagination/1.4.1/jquery.twbsPagination.min.js"></script>

    <script src="/public/common/script/fontawesome.all.min.js"></script>
    <script type="text/javascript" src="/public/common/script/common.js?ver=2205031000"></script>
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
                    <header class="main-header">
                        <div class="main-header-firstLine">
                            <!-- button 추가 -->
                            <div>
                            <!--
                                <button type="button" class="add-user btn1" onclick="javascript: openMenu(201);"><i class="fa-solid fa-circle-plus"></i> New</button>
                                <button type="button" class="delete-user btn2" onclick="#"><i class="fa-solid fa-circle-minus"></i> Del</button>
                             -->
                            </div>
                        </div>

						<form name="frmSearch" id="frmSearch" style="width: 100%;">
                        <div class="search-bar">
                            <input type="hidden" name="sch_1">
                            <input type="text" name="sch_2" placeholder="Search..." class="search-input" autocomplet="off" value="<?php echo $schData["sch_2"];?>" />
                            <button type="button" class="search-button" onclick="javascript: messageList(1);">Search</button>
                        </div>
                        </form>

                    </header>

                    <table class="list-table">
                    	<colgroup>
                    		<col width="25%"/>
                    		<col width="50%"/>
                    		<col width="10%"/>
                    		<col width="10%"/>
                    		<col width="5%"/>
                    	</colgroup>
                        <thead>
                            <tr>
                                <th>템플릿코드</th>
                                <th>제목/메세지</th>
                                <th>등록일자</th>
                                <th>작성자</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="item-list"><?php
                        foreach($data as $row){?>
                            <tr>
                                <td class="txt_left"><a href="/admin/message_form/<?php echo $row["idx"];?>"><?php echo $row["template_nm"].'('.$row["template_cd"].')';?></a></td>
                                <td><div class="txt_left no_overflow"><?php echo '<strong>'.$row["title"].'</strong><br/>'.$row["template_msg"];?></div></td>
                                <td><?php echo date('Y-m-d', strtotime($row["wdate"]));?></td>
                                <td><?php echo getExist($row["wuser"], 'noname');?>
                                <td><?php echo $row["use_yn"];?></td>
                            </tr><?php
                        }?>
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