<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta http-equiv="Cache-Control" content="no-cache" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Internal User Information</title>
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
                    <form name="frm1" id="frm1">
            		<table class="form-table">
            			<colgroup>
            				<col width="25%" />
            				<col width="75%" />
            			</colgroup>
            			<tbody>
            			<tr>
            				<th class="full_line require">아이디</th>
            				<td class="full_line">
            					<input type="text" name="user_id" id="user_id"  value="<?php echo $info["user_id"];?>" placeholder="아이디" <?php echo $editMode=="U" ? 'readonly' : '';?>/>
            					<?php if($editMode=="N") { ?><button type="button" class="form-btn detail-btn" onclick="userDuplicateCheck();return(false);"><i class="fa-solid fa-circle-check"></i> 중복확인</button><?php }?>
            					<?php if($editMode=="U") { ?><button type="button" id="btnChgPw" class="form-btn detail-btn"  onclick="userPasswordChange();return(false);"><i class="fa-solid fa-circle-check"></i> 암호변경</button><?php }?>

            				</td>
            			</tr>
            			<tr class="user-password" <?php echo $editMode=="U" ? 'style="display: none;"' : '';?>>
            				<th class="full_line require">비밀번호</th>
            				<td class="full_line">
            					<input type="password" name="user_pw" id="user_pw" placeholder="비밀번호" />
            				</td>
            			</tr>
            			<tr class="user-password" <?php echo $editMode=="U" ? 'style="display: none;"' : '';?>>
            				<th class="full_line require">비밀번호(확인)</th>
            				<td class="full_line">
            					<input type="password" name="user_pw_2" id="user_pw_2" placeholder="비밀번호 확인" />
            				</td>
            			</tr>
            			<tr>
            				<th class="full_line require">성명</th>
            				<td class="full_line"><input type="text" name="user_nm" id="user_nm" value="<?php echo $info["user_nm"];?>" placeholder="성명" /></td>
            			</tr>
            			<tr>
            				<th class="full_line">이메일</th>
            				<td class="full_line"><input type="text" name="user_email" id="user_email" value="<?php echo $info["user_email"];?>" placeholder="이메일" /></td>
            			</tr>
            			<tr>
            				<th class="full_line">소속</th>
            				<td class="full_line">
            					<input type="text" name="company" id="company" value="<?php echo $info["company"];?>" placeholder="소속"/>
            				</td>
            			</tr>
            			<tr>
            				<th class="full_line">부서</th>
            				<td class="full_line">
            					<input type="text" name="dept" id="dept" value="<?php echo $info["dept"];?>" placeholder="부서"/>
            				</td>
            			</tr>
            			<tr>
            				<th class="full_line require">권한분류</th>
            				<td class="full_line">
            					<input type="radio" name="user_type" id="user_type_1" value="user" <?php echo $info["user_type"]=="user" ? "checked" : '';?>/><label for="userType_1">일반</label>
            					<input type="radio" name="user_type" id="user_type_2" value="admin" <?php echo $info["user_type"]=="admin" ? "checked" : '';?>/><label for="userType_2">관리자</label>
            				</td>
            			</tr>
            			<tr>
            				<th class="full_line require">정보수신</th>
            				<td class="full_line">
            					<input type="radio" name="optin" id="optin_2" value="N" <?php echo $info["optin"]!="Y" ? "checked" : '';?>/><label for="optin_2">동의안함</label>
            					<input type="radio" name="optin" id="optin_1" value="Y" <?php echo $info["optin"]=="Y" ? "checked" : '';?>/><label for="optin_1">동의함</label><?php
            					if($info["optin"]=="Y"){?>
            						<input type="date" name="optin_dt" id="optin_dt" style="border: none;" readonly value="<?php echo isset($info["optin_dt"]) ? date('Y-m-d', strtotime($info["optin_dt"])) : '';?>" />
            						<input type="checkbox" name="optin_update" id="optin_update" value="Y" /><label for="optinUpdate">수신재동의</label><?php
                                }?>
            					<input type="hidden" name="optin_old" id="optin_old" value="<?php echo $info["optin"];?>" />
            				</td>
            			</tr>
            			<tr>
            				<th class="full_line require">사용여부</th>
            				<td class="full_line">
            					<label><input type="radio" name="use_yn" id="use_yn_1" value="Y" <?php echo $info["use_yn"]=="Y" ? "checked" : '';?>/>사용</label>
            					<label><input type="radio" name="use_yn" id="use_yn_2" value="N" <?php echo $info["use_yn"]!="Y" ? "checked" : '';?>/>사용안함</label>
            				</td>
            			</tr>

            			</tbody>
            		</table>
            		<input type="hidden" name="editMode" id="editMode" value="<?php echo $editMode;?>"/>
            		<input type="hidden" name="idx" id="idx" value="<?php echo $info["idx"];?>"/>
            		</form>

                    <div class="btn-wrap">
                            <button type="button" class="save-user form-btn" onclick="javascript:userSave('<?php echo $editMode;?>');"><i class="fa-solid fa-circle-plus"></i> save</button>
                            <button type="button" class="cancel-user form-btn" onclick="javascript: openMenu(900);"><i class="fa-solid fa-circle-minus"></i> cancel</button>
                        </div>
                </div>
            </main>

        </div>
        <!-- //main-content-wrap -->
    </div>
    <!-- <?php include_once APPPATH.'views/admin/inc_footer.php'; ?> -->



</body>
</html>