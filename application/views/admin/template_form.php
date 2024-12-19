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

	<script>
    	$(function(){
    		$("#tabs").tabs();
    	});
	</script>

    <!-- aside, button -->
    <div class="container">
    	<div class="blind"></div>
        <?php include_once APPPATH.'views/admin/inc_aside.php'; ?>
        <div class="main-content-wrap">

            <!-- flex 1 -->
            <?php include_once APPPATH.'views/admin/inc_header.php'; ?>
            <!-- flex 2 -->
            <main class="main-content">
                <div id="tabs">
                	<div style="width: 100%; overflow: hidden;"> 
                        <ul>
                            <li><a href="#tabs-1">form</a></li>
                            <li><a href="#tabs-2">Preview</a></li>
        				</ul>  
    				</div>
    				    
				    <div id="tabs-1">         	
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
                					<select class="category-select form-select" name="profile_key" id="profile_key"><?php 
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
                					<label><input type="radio" name="template_type" id="msg_type_1" value="at" <?php echo $info["template_type"]=="at" ? "checked" : "";?>/><span>알림톡</span></label>
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
                				<th onclick="javascript:cmmOpenPop('.pop_img');" style="cursor: pointer;">이미지선택</th>
                				<td>
                					<input type="text" name="img_url" id="img_url" value="<?php echo $info["img_url"];?>" readonly />
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
                				<th class="full_line" onclick="javascript:msgBtnAdd();" style="cursor: pointer;">버튼추가+</th>
                				<td class="full_line"></td>								
                			</tr>
                			<tfoot class="item ft" id="ftButton"><?php
                			for($i=1; $i<=$info["btn_cnt"]; $i++){?>
                				<tr>
                					<td>
                    					<button type="button" class="btn_remove" onclick="msgBtnRemove(this);">X</button>&nbsp;&nbsp;
                    					<select class="category-select form-select" name="btn_type[]">
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
                            <button type="button" class="save-user form-btn" onclick="javascript:templateSave('<?php echo $editMode;?>');"><i class="fa-solid fa-circle-plus"></i> save</button>
                            <button type="button" class="cancel-user form-btn" onclick="javascript: openMenu(200);"><i class="fa-solid fa-circle-minus"></i> cancel</button>
                        </div>
                	</div>
                	
                	<div id="tabs-2">
            			<div class="mobile_screen" style="width: 300px; border-radius: 8px; border: solid 1px #f1f1f1; margin: 1.5em 0">
                			<div style="width: 100%; border-radius: 8px;">
                				<img src="https://mud-kage.kakao.com/dn/xRPSI/btsKOqGeRa7/QVKEY9vwUAd1NPvh3zyuJ1/img_l.jpg" style="width: 100%; border-radius: 8px;"/>
            				</div>
                			<div style="width: 100%; padding: 1em; font-size: 0.8em;"><?php echo nl2br('국내 성인 ADHD 현황 - 2023년도

2023년도 국내 성인 인구수(20-44세)9 : 16,870,491명
● 예 상 ADHD 환자 수(유병률 4.4%) : 742,302명
* 국가 통계 포털에서 확인한 2021년도 국내 20-44세 인구 수에 미국 18-44세 성인 ADHD 유병률인
4.4%6를 곱하여 산출하였습니다.
● 질 병코드 F90.0(과다활동을 수반한 주의력결핍장애) 환자 수(20-44세)10 : 87,136명
● 국 내 성인 ADHD 잠재 환자 중, 예상 진단율 : 11.7%
* 질병코드 F90.0으로 진단받은 환자 수를 예상 ADHD 환자 수로 나누어 산출하였습니다.');?></div>
                			<div style="width: 100%; margin: 0.5em 0; text-align: center;">
								<button class="btn_link" style="width: 95%; font-size: 0.8em; padding: 0.5em;  border-radius: 4px; background: #f1f1f1; color: #000; text-align: center; font-weight: 400;">컨텐츠 확인하기</button>
                			 </div>
            			</div>
                	</div>
                    
            	</div>
            	
            	<div class="pop_img">
            		<div class="btn_pop_close">
            			<a onclick="cmmClosePop('.pop_img');">Ⅹ</a>
            		</div>
            		<div class="img_list"><?php
            		foreach($img_data as $row){ ?>
            			<div>
            				<img src="<?php echo $row["img_url"]?>" onclick="javascript:imgUrlView(this.src);" />
            				<h5><?php echo $row["img_name"]?></h5>
            			</div><?php 
            		}?>
            		</div>                		            			
            	</div>
            </main>

        </div>
        <!-- //main-content-wrap -->
    </div>
    <!-- <?php include_once APPPATH.'views/admin/inc_footer.php'; ?> -->



</body>
</html>