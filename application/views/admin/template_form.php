<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta http-equiv="Cache-Control" content="no-cache" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Template Information</title>
	<meta property="og:author" content="d'wave">
	<meta property="og:type" content="website">
	<meta property="og:title" content="닥터웨이브" />
	<meta property="og:description" content="닥터웨이브" />
	<meta property="og:image" content="https://dr-wave.co.kr/public/images/logo.png"/>
	<meta property="og:url" content="" />
	<link rel="icon" type="image/png" href="/public/common/css/logo_ics.png" />
    <link rel="stylesheet" href="/public/common/css/fontawesome.all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR&family=Roboto&Manjari:wght@100;400;700&display=swapp" rel="stylesheet" />
    <link rel="stylesheet" href="/public/common/css/local.css" />
    <script type="text/javascript" src="/public/common/js/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="/public/common/js/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="/public/common/js/jquery.touchSwipe.min.js"></script>
    <script type="text/javascript" src="/public/common/js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="/public/common/js/jquery.ui.touch-punch.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twbs-pagination/1.4.1/jquery.twbsPagination.min.js"></script>

    <script src="/public/common/script/fontawesome.all.min.js"></script>
    <script type="text/javascript" src="/public/common/common.js?ver=2205031000"></script>
    <script defer type="text/javascript" src="/public/common/script/local.js"></script>
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
                <h3>Template</h3>
                <nav>
                    <ul class="nav-links">
                        <!-- 검색, 로그아웃, user -->
                        <li><i class="fa-solid fa-magnifying-glass"></i></li>
                        <li><i class="fa-solid fa-power-off"></i></li>
                        <li><span style="color: #c6c5cd ">Hi</span>, <span>디웨이브</span></li>
                    </ul>
                </nav>
            </div>
            <!-- flex 2 -->
            <main class="main-content">
                <div>
                	<h3>Information</h3>
                    <form name="frm1" id="frm1">
            		<table>
            			<colgroup>
            				<col width="25%" />
            				<col width="75%" />				
            			</colgroup>
            			<tbody>
            			<tr>
            				<th class="full_line require">발신키구분</th>
            				<td class="full_line">
            					<select name="profile_key" id="profile_key">
            						<option value="">발신키 선택</option><?php
            						foreach($dataProfile as $row){?>
            						<option value="<?php echo $row["key"];?>" <?php echo $info["profile_key"]==$row["key"] ? "selected" : "";?>><?php echo $row["profile_nm"];?></option><?php 
            					}?>
            					</select>
            					<input type="hidden" name="profile_type" id="profile_type" value="<?php echo $info["profile_type"];?>"/>
            				</td>
            			</tr>
            			<tr>
            				<th class="full_line require">발송구분</th>
            				<td class="full_line">
            					<label><input type="radio" name="template_type" id="msg_type_1" value="at" <?php echo $info["template_type"]=="at" ? "checked" : ($info["template_type"]=="" ? "checked" : "");?>/><span>알림톡</span></label>
            					<label><input type="radio" name="template_type" id="msg_type_2" value="ft" <?php echo $info["template_type"]=="ft" ? "checked" : "";?>/><span>친구톡</span></label>
            				</td>
            			</tr>
            			<tr>
            				<th class="full_line require">템플릿코드</th>
            				<td class="full_line"><input type="text" name="template_cd" id="template_cd" value="<?php echo $info["template_cd"];?>" placeholder="템플릿코드" /></td>
            			</tr>
            			<tr>
            				<th class="full_line require">템플릿명</th>
            				<td class="full_line"><input type="text" name="template_nm" id="template_nm" value="<?php echo $info["template_nm"];?>" placeholder="템플릿명" /></td>				
            			</tr>
            			<tr>
            				<th>이미지선택</th>
            				<td>
            					<span style="display: inline-block; width: 85%;"><input type="text" name="img_url" id="img_url" value="<?php echo $info["img_url"];?>" style="width: 90%;" readonly /></span><span style="display: inline-block; width: 15%; text-align: right;"><button>찾기</button>&nbsp;</span>
            				</td>
            			</tr>
            			<tr>
            				<th>이미지링크</th>
            				<td><input type="text" name="img_link" id="img_link" value="<?php echo $info["img_link"];?>"/></td>
            			</tr>
            			<tr>
            				<th class="full_line require">메세지내용</th>
            				<td class="full_line">
            					<textarea name="template_msg" id="template_msg" placeholder="템플릿 메세지를 입력해주세요" onkeyup="javascript:adjustHeight('#template_msg');"><?php echo $info["template_msg"];?></textarea>
            				</td>				
            			</tr>
            			<tr>
            				<th class="full_line">버튼정보</th>
            				<td class="full_line"><button type="button" onclick="msgBtnAdd();">버튼추가(+)</button></td>								
            			</tr>
            			<tfoot class="item ft" id="ftButton"><?php
            			for($i=1; $i<=$info["btn_cnt"]; $i++){?>
            				<tr>
            					<td>
                					<button type="button" class="btn_remove" onclick="msgBtnRemove(this);">X</button>&nbsp;&nbsp;
                					<select name="btn_type[]">
                						<option value="">타입</option>
                						<option value="WL" <?php echo $info["btn_type_".$i] == "WL" ? "selected" : "";?>>웹버튼</option>
                					</select>
            					</td>
            					<td><input type="text" name="btn_name[]" placeholder="버튼명" value="<?php echo $info["btn_name_".$i];?>"></td>
            				</tr>
            				<tr>
            					<td colspan="2"><input type="text" name="btn_link[]" placeholder="연결링크" value="<?php echo $info["btn_link_".$i];?>"></td>
            				</tr><?php 
            			} ?>
            			</tfoot>
            			</tbody>		
            		</table>
            		<input type="hidden" name="editMode" id="editMode" value="<?php echo $editMode;?>"/>
            		<input type="hidden" name="idx" id="idx" value="<?php echo $idx;?>"/>
            		</form>

                    <div class="btn-wrap">
                        <button class="save-user form-btn"><i class="fa-solid fa-circle-plus"></i> save</button>
                        <button class="cancel-user form-btn" onclick="javascript: openMenu(100);"><i class="fa-solid fa-circle-minus"></i> cancel</button>
                    </div>
                </div>



            </main>

        </div>
        <!-- //main-content-wrap -->
    </div>
    <!-- <?php include_once APPPATH.'views/admin/inc_footer.php'; ?> -->



</body>
</html>