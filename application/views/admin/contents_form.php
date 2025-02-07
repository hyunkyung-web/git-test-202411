<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta http-equiv="Cache-Control" content="no-cache" />
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no, maximum-scale=1, width=device-width" />
	<title>Contents Information</title>
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


    <script src="/public/common/script/fontawesome.all.min.js"></script>
    <script type="text/javascript" src="/public/common/smarteditor/js/HuskyEZCreator.js" charset="utf-8"></script>


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
                    <form name="frm1" id="frm1">
                        <table class="form-table">
                            <colgroup>
                                <col style="width: 20%;">
                                <col style="width: 80%;">
                            </colgroup>
                            <tbody>
                                <tr>
                                    <th><label for="title">제목</label></th>
                                    <td><input type="text" id="title" name="title" value="<?php echo $info["title"];?>"/></td>
                                </tr>
                                <tr>
                                    <th><label for="contents_type">컨텐츠타입</label></th>
                                    <td>
                                        <select class="category-select form-select" id="contents_type" name="contents_type">
                                            <option value="">선택</option>
                                            <option value="article" <?php echo $info["contents_type"]=="article" ? 'selected' : '';?>>article</option>
                                            <option value="notice" <?php echo $info["contents_type"]=="notice" ? 'selected' : '';?>>notice</option>
                                        </select>
                                        <input type="hidden" name="idx" id="idx" value="<?php echo $info["idx"];?>" placeholder="회원번호" readonly/>
                                    </td>
                                </tr>
                                <tr>
                                    <th><label for="description">컨텐츠설명</label></th>
                                    <td><textarea name="description" id="description" cols="20" rows="2" style="width: 100%;"><?php echo $info["description"];?></textarea></td>
                                </tr>
                                <tr>
                                    <th><label>첨부파일<?php echo !empty($info["attach_file"]) ? '&nbsp;<a href="'.$info["attach_file"].'" target="_blank">💾</a>': '';?></label></th>
                                    <!-- <td class="add-file">
                                        <label for="attach_file"> <i class="fa-solid fa-circle-check"></i> 파일추가</label>
                                        <input type="file" name="attach_file" id="attach_file" class="display-none" onchange="updateFileName()" />
                                        <input class="upload-name" value="" placeholder="" readonly />
                                    </td> -->
                                    <td class="add-file">
                                        <input type="file" name="attach_file" id="attach_file" />
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2">
                                        <div id="smarteditor">
                                            <textarea name="body_text" id="body_text" cols="20" rows="30" style="width: 100%;"><?php echo $info["body_text"];?></textarea>
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                        <input type="hidden" name="editMode" id="editMode" value="<?php echo $editMode;?>"/>
                    </form>

                    <div class="btn-wrap">
                        <button type="button" class="save-user form-btn" onclick="javasctipt: contentsSave('<?php echo $editMode;?>');"><i class="fa-solid fa-circle-plus"></i> save</button>
                        <a href="<?php echo get_cookie("return_url");?>"><button type="button" class="cancel-user form-btn"><i class="fa-solid fa-circle-minus"></i> cancel</button></a>
                    </div>
                </div>



            </main>

        </div>
        <!-- //main-content-wrap -->
    </div>
    <!-- <?php include_once APPPATH.'views/admin/inc_footer.php'; ?> -->



</body>
</html>