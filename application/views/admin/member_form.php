<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta http-equiv="Cache-Control" content="no-cache" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>HCP-Information</title>
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
                    <form name="frm1" id="frm1" method="post">
            		<table class="form-table">
            			<colgroup>
            				<col width="25%" />
            				<col width="75%" />				
            			</colgroup>
            			<tbody>
            			<tr>
            				<th class="full_line">회원번호</th>
            				<td class="full_line">
            					<input type="text" name="idx" id="idx" style="max-width: 25%;" value="<?php echo $info["idx"];?>" placeholder="회원번호" readonly/>
            				</td>
            			</tr>
            			<tr>
            				<th class="full_line">성명</th>
            				<td class="full_line"><input type="text" name="member_nm" id="member_nm" value="<?php echo $info["member_nm"];?>" placeholder="성명" /></td>
            			</tr>
            			<tr>
            				<th class="full_line">휴대전화번호</th>
            				<td class="full_line"><input type="text" name="cellphone" id="cellphone" value="<?php echo $info["cellphone"];?>" placeholder="휴대전화번호(숫자만 입력하세요)" onkeyup="javascript: cmmOnNumber(this);"/></td>
            			</tr>
            			<tr>
            				<th class="full_line">이메일</th>
            				<td class="full_line"><input type="text" name="member_email" id="member_email" value="<?php echo $info["member_email"];?>" placeholder="이메일" onblur="javsascript: cmmOnEmail(this);"/></td>
            			</tr>
            			
            			<tr>
            				<th class="full_line">회원구분</th>
            				<td class="full_line">
            					<label><input type="radio" name="member_type" id="member_type_1" value="hcp" <?php echo $info["member_type"]=="hcp" ? "checked" : '';?>/>HCP</label>
            					<label><input type="radio" name="member_type" id="member_type_2" value="pharm" <?php echo $info["member_type"]=="pharm" ? "checked" : '';?>/>Pharm</label>
            					<label><input type="radio" name="member_type" id="member_type_3" value="etc" <?php echo $info["member_type"]=="etc" ? "checked" : '';?>/>Etc</label>            					
            				</td>
            			</tr>
            			<tr>
            				<th class="full_line">근무처</th>
            				<td class="full_line">
            					<input type="text" name="biz_nm" id="biz_nm" value="<?php echo $info["biz_nm"];?>" placeholder="근무처"/>
            				</td>
            			</tr>
            			<tr>
            				<th class="full_line">부서/전공</th>
            				<td class="full_line">
            					<input type="text" name="specialty" id="specialty" value="<?php echo $info["specialty"];?>" placeholder="부서/전공"/>
            				</td>
            			</tr>	            			
            			<tr>
            				<th class="full_line">계정상태</th>
            				<td class="full_line">
            					<label><input type="radio" name="member_status" id="member_status_1" value="hold" <?php echo $info["member_status"]=="hold" ? "checked" : '';?>/>보류</label>
            					<label><input type="radio" name="member_status" id="member_status_2" value="active" <?php echo $info["member_status"]=="active" ? "checked" : '';?>/>활동</label>
            					<label><input type="radio" name="member_status" id="member_status_3" value="expire" <?php echo $info["member_status"]=="expire" ? "checked" : '';?>/>만료</label>
            					<input type="hidden" name="before_status" value="<?php echo $info["member_status"];?>"/>
            				</td>
            			</tr>	
            			<tr>
            				<th class="full_line">UUID</th>
            				<td class="full_line">
            					<input type="text" name="uuid" id="uuid" value="<?php echo $info["uuid"];?>" placeholder="UUID"/>
            				</td>
            			</tr>		
            			</tbody>		
            		</table>
            		<input type="hidden" name="editMode" id="editMode" value="<?php echo $editMode;?>"/>		
            		</form>

                    <div class="btn-wrap">
                            <button type="button" class="save-user form-btn" onclick="javascript:memberSave('<?php echo $editMode;?>');"><i class="fa-solid fa-circle-plus"></i> save</button>
                            <a href="<?php echo get_cookie("callback_url");?>"><button type="button" class="cancel-user form-btn"><i class="fa-solid fa-circle-minus"></i> cancel</button></a>
                        </div>
                </div>
            </main>

        </div>
        <!-- //main-content-wrap -->
    </div>
    <!-- <?php include_once APPPATH.'views/admin/inc_footer.php'; ?> -->



</body>
</html>