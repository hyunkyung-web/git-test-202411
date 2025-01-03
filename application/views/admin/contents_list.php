<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta http-equiv="Cache-Control" content="no-cache" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Contents List</title>
	<meta property="og:author" content="d'wave">
	<meta property="og:type" content="website">
	<meta property="og:title" content="Dr-Round" />
	<meta property="og:description" content="Dr-Round" />
	<meta property="og:image" content="https://dr-wave.co.kr/public/images/logo.png"/>
	<meta property="og:url" content="" />
	<link rel="icon" type="image/png" href="/public/common/css/logo_ics.png" />
    <link rel="stylesheet" href="/public/common/css/fontawesome.all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR&family=Roboto&Manjari:wght@100;400;700&display=swapp" rel="stylesheet" />
    <link rel="stylesheet" href="/public/common/css/admin.css" />

	<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  	<script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>

    <script src="/public/common/script/fontawesome.all.min.js"></script>
    <script defer type="text/javascript" src="/public/common/script/common.js"></script>
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
                                <button type="button" class="add-user btn1" onclick="javascript: openMenu(110);"><i class="fa-solid fa-circle-plus"></i> New</button>
                                <button type="button" class="delete-user btn2" onclick="#"><i class="fa-solid fa-circle-minus"></i> Del</button>
                            </div>
                        </div>
                        
						<form name="frmSearch" id="frmSearch" style="width: 100%;">
                        <div class="search-bar">
                            <select class="category-select list-select" name="sch_1">
                                <option value="">성명</option>
                                <option value="000">연락처</option>
                                <option value="010">이메일</option>
                            </select>
                            <input type="text" name="sch_2" placeholder="Search..." class="search-input" autocomplet="off" value="<?php echo $schData["sch_2"];?>" />
                            <button type="button" class="search-button" onclick="javascript: contentsList(1);">Search</button>
                        </div>
                        </form>
                        
                    </header>
                    
                    <table class="list-table">
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
                        <tbody id="item-list"><?php 
                        if(count($data)>0){
                            foreach($data as $row){?>
                            <tr>
                                <td align="center">
                                    <label>
                                        <input type="checkbox">
                                        <span class="custom-checkbox"></span>
                                    </label>
                                </td>
                                <td><?php echo $row["idx"];?></td>
                                <td><?php echo $row["contents_type"];?></td>
                                <td class="align_left"><?php echo $row["title"];?></td>
                                <td><?php echo $row["wuser"];?></td>
                                <td><?php echo date('Y-m-d', strtotime($row["wdate"]));?></td>
                            </tr><?php 
                            }
                        } else {
                            echo '<tr><td align="center" style="height: 5em; border: none;" colspan="20">검색결과가 없습니다.</td></tr>';
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