<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta http-equiv="Cache-Control" content="no-cache" />
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no, maximum-scale=1, width=device-width" />
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
    <link rel="stylesheet" href="/public/common/css/reset.css" />
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
    	<div class="blind"></div>
        <?php include_once APPPATH.'views/admin/inc_aside.php'; ?>
        <div class="main-content-wrap">

            <!-- flex 1 -->
            <?php include_once APPPATH.'views/admin/inc_header.php'; ?>
            <!-- flex 2 -->
            <main class="main-content">
				<ul class="tabs flex_row">
					<li><button class="btn_tab active" data-tab="tab_1" onclick="messageOpenTab(this)">메세지정보</button></li>
					<li><button class="btn_tab" data-tab="tab_2" onclick="messageOpenTab(this)">KAKAO TALK</button></li>
					<li><button class="btn_tab" data-tab="tab_3" onclick="messageOpenTab(this)">E-MAIL</button></li>
					<li><button class="btn_tab" data-tab="tab_4" onclick="messageOpenTab(this)">LMS</button></li>
				</ul>

				<!-- tab_content_wrap =  tab_content + popup -->
				<div class="tab_content_wrap">
				<!-- tab_1 : 메세지 정보 -->
					<div id="tab_1" class="tab_content active">
						<form name="frm1" id="frm1">
							<table class="form-table">
								<colgroup>
									<col width="25%" />
									<col width="75%" />
								</colgroup>
								<tbody>
								<tr>
									<th class="require"><label>발송구분</label></th>
									<td>
										<!-- <label><input type="radio" name="template_type" id="msg_type_1" value="at" <?php echo $info["template_type"]=="at" ? "checked" : "";?>/><span>알림톡</span></label> -->
										<label><input type="radio" name="template_type" id="msg_type_2" value="ft" <?php echo $info["template_type"]=="ft" ? "checked" : "";?>/><span>친구톡</span></label>
										<input type="hidden" name="profile_key" id="profile_key" value="<?php echo $info["profile_key"];?>"/>
									</td>
								</tr>
								<tr>
									<th class="require"><label>템플릿코드</label></th>
									<td><input type="text" name="template_cd" id="template_cd" value="<?php echo $info["template_cd"];?>" placeholder="템플릿코드" readonly/></td>
								</tr>
								<tr>
									<th class="require"><label>제목</label></th>
									<td><input type="text" name="title" id="title" value="<?php echo $info["title"];?>" placeholder="템플릿명" readonly/></td>
								</tr>
								<tr>
									<th onclick="javascript:cmmOpenPop('.pop_img');" style="cursor: pointer;"><label>이미지선택</label></th>
									<td>
										<input type="text" name="img_url" id="img_url" value="<?php echo $info["img_url"];?>" readonly/>
									</td>
								</tr>
								<tr>
									<th><label>이미지링크</label></th>
									<td><input type="text" name="img_link" id="img_link" value="<?php echo $info["img_link"];?>" readonly/></td>
								</tr>
								<tr>
									<th class="require"><label>메세지내용</label></th>
									<td>
										<textarea name="template_msg" id="template_msg" placeholder="템플릿 메세지를 입력해주세요" readonly><?php echo $info["template_msg"];?></textarea>
									</td>
								</tr>
								<tr>
									<th colspan="2"><label>버튼 정보</label></th>
								</tr>
								<tfoot class="item ft" id="ftButton"><?php
								for($i=1; $i<=$info["btn_cnt"]; $i++){?>
									<tr>
										<td>
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
							<input type="hidden" name="template_idx" id="template_idx" value="<?php echo $idx;?>"/>
							<input type="text" name="msg_target" id="msg_target" style="border: solid"/>
						</form>

						<div class="btn-wrap"></div>
					</div>

					<!-- tab_2 카카오톡 -->
					<div id="tab_2" class="tab_content">
						<div class="mobile_screen">
							<div class="flex_row flex_between">
								<!-- 발송 버튼 2개 -->
								<div class="btn_send_message flex_row">
									<button class="red" onclick="javascript: sendKakaoTalk('ft');">선택 발송</button>
									<button class="red">전체 발송</button>
								</div>

								<!-- 주소록 popup -->
								<button class="open_pop mint" onclick="javascript: viewAddressBook('tab_2');">수신자 선택</button>
							</div>
							<!-- 최종 발송 타겟 -->
							<div class="address_selected_wrap">
								<p class="address_selected fix"></p>
								<p class="address_selected tmp" style="display: none;"></p>
							</div>

							<div><?php
							if(!empty($info["img_link"])){
								echo '<a href="'.$info["img_link"].'" target="_black"><img src="'.$info["img_url"].'"/></a>';
							}else {
								echo !empty($info["img_url"])?'<img src="'.$info["img_url"].'"/>' : '';
							}?>
							</div>
							<div><?php echo nl2br($info["title"].'<br/><br/>'.$info["template_msg"]);?></div>
							<div class="flex_col btn_wrap"><?php
							for($i=1; $i<=$info["btn_cnt"]; $i++){?>
									<a href="<?php echo $info["btn_link_".$i];?>" target="_blank"><button class="btn_link"><?php echo $info["btn_name_".$i];?></button></a><?php
							}?>
							</div>
						</div>
					</div>

					<div id="tab_3" class="tab_content">

						<div class="mobile_screen">
							<div class="flex_row flex_between">
								<!-- 발송 버튼 2개 -->
								<div class="btn_send_message flex_row">
									<button class="red">선택 발송</button>
									<button class="red">전체 발송</button>
								</div>

								<button class="open_pop mint" onclick="viewAddressBook('tab_3')">수신자 선택</button>
							</div>
							<!-- 최종 발송 타겟 -->
							<div class="address_selected_wrap">
								<p class="address_selected fix"></p>
								<p class="address_selected tmp" style="display: none;"></p>
							</div>

    						<div><?php echo nl2br($info["title"]); ?></div>
							<div><?php
							if(!empty($info["img_link"])){
								echo '<a href="'.$info["img_link"].'" target="_black"><img src="'.$info["img_url"].'"/></a>';
							}else {
								echo !empty($info["img_url"])?'<img src="'.$info["img_url"].'"/>' : '';
							}?>
							</div>
							<div><?php echo nl2br($info["template_msg"]); ?></div>
							<div class="flex_col"><?php
							for($i=1; $i<=$info["btn_cnt"]; $i++){?>
									<a href="<?php echo $info["btn_link_".$i];?>" target="_blank"><input type="button" class="btn_link" value="<?php echo $info["btn_name_".$i];?>"></a><?php
							}?>
							</div>
						</div>

					</div>

					<div id="tab_4" class="tab_content">
						<div class="mobile_screen">
							<div class="flex_row flex_between">
								<!-- 발송 버튼 2개 -->
								<div class="btn_send_message flex_row">
									<button class="red">선택 발송</button>
									<button class="red">전체 발송</button>
								</div>

								<button class="open_pop mint" onclick="viewAddressBook('tab_4')">수신자 선택</button>
							</div>
							<!-- 최종 발송 타겟 -->
							<div class="address_selected_wrap">
								<p class="address_selected fix"></p>
								<p class="address_selected tmp" style="display: none;"></p>
							</div>

    						<div><?php echo nl2br($info["title"]); ?></div>
							<div><?php
							if(!empty($info["img_link"])){
								echo '<a href="'.$info["img_link"].'" target="_black"><img src="'.$info["img_url"].'"/></a>';
							}else {
								echo !empty($info["img_url"])?'<img src="'.$info["img_url"].'"/>' : '';
							}?>
							</div>
							<div><?php echo nl2br($info["template_msg"]); ?></div>

						</div>
					</div>


					<!-- 주소록 popup -->
					<div class="mobile_screen_pop popup">
						<div class="address_list">
							<!-- 하위 div 3개 구성 -->
							<div>
								<form name="frmSearch" id="frmSearch" class="flex_row flex_between" onsubmit="return false">
									<div style="clear: both;">
										<input type="hidden" name="tmp_cellphone" id="tmp_cellphone" class="target kakao" />
                						<input type="hidden" name="tmp_email" id="tmp_email" class="target email" />
                						<input type="hidden" name="target_cellphone" id="target_cellphone" class="target kakao" style="background: yellow;"/>
                						<input type="hidden" name="target_email" id="target_email" class="target email" style="background: yellow;"/>
                					</div>
									<div class="search-bar">
										<input type="hidden" name="sch_1" id="sch_1">
										<input type="text" name="sch_2" id="sch_2" placeholder="성명, 이메일, 연락처, 소속/부서" class="search-input" />
										<button type="button" class="search-button" onclick="javascript: targetSearch();">Search</button>
										<input type="hidden" value=""/>										
									</div>

									<!-- 하위 삭제버튼 이용할 경우, search-bar -- width: 60% 로 조정 필요 -->
									<!-- <button type="button" class="btn_close" onclick="closePopup();">X</button> -->
								</form>
							</div>
							<div class="list_table_wrap">
								<table class="list-table">
									<colgroup>
										<col width="5%"/>
										<col width="95%"/>
									</colgroup>
									<thead>
										<tr>
											<th>
												<label>
													<input type="checkbox" class="display-none" name="chk_all" id="chk_all" onclick="javascript: clickCheckAll(this);"><span class="custom-checkbox"></span>
												</label>
											</th>
											<th>성명(이메일, 연락처, 소속/부서)</th>
										</tr>
									</thead>
									<tbody id="item_list">
										<tr>
											<td>
												<label>
													<input type="checkbox" class="display-none" name="chk_address" id="chk_01011112222" data-email="gildong.hong@dr-wave.co.kr" data-phone="01011112222" title="홍길동">
													<span class="custom-checkbox"></span>
												</label>
											</td>
											<td class="left"><label for="chk_01011112222">홍길동(gildong.hong@dr-wave.co.kr)</label></td>
										</tr>
									</tbody>
								</table>
							</div>
							
							<div class="address_selected_wrap">
								<p class="address_selected_tmp" id="tmp_label"></p>
								<p class="address_selected_tmp" id="fix_label" style="display: none;"></p>
							</div>

							<!-- 버튼 2개  : 취소, 확인 -->
							<div class="btn_confirm flex_row flex_end">
								<button onclick="javascript: clear_target();" class="white">취소</button>
								<button onclick="javascript: fix_target();" class="mint"> 확인</button>
							</div>


						</div>
						<!-- //address_list -->

					</div>

				</div>
				<!-- //tab_content_wrap -->

				<div class="pop_img">
            		<div class="btn_pop_close">
            			<a onclick="cmmClosePop('.pop_img');">Ⅹ</a>
            		</div>
            		<div class="img_list"><?php
            		foreach($img_data as $row){ ?>
            			<div>
            				<img src="<?php echo $row["img_url"]?>" onclick="javascript: imgUrlView(this.src);" />
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

<script>

$(window).on("load", function(){
	adjustHeight('#template_msg');
});

let view_tab;
let cellphone_info = [];
let email_info = [];

let fix_cellphone_info = [];
let fix_email_info = [];

function viewAddressBook(tab_val){
	view_tab = tab_val;
	
	$("#sch_2").val('');
	openPopup('.mobile_screen_pop'); 
	targetSearch();
}

function clickCheckAll(e){

	var addStr = '';
	var fixStr = '';

	if($(e).is(":checked")){

		$("input[name=chk_address]:checked").each(function(idx, e){			
			//배열에서 제거 할 값의 index를 찾는다
			var find_1 = cellphone_info.indexOf(e.dataset.cellphone);
			var find_2 = email_info.indexOf(e.dataset.email);

			//index값을 근거로 배열에서 행을 삭제한다
			cellphone_info.splice(find_1, 1);
			email_info.splice(find_2, 1);

			//라벨 제거
			$("#tmp_label .label_added."+e.dataset.chk_id).remove();
			$("#fix_label .label_added."+e.dataset.chk_id).remove();
			
		});

		
		$("input[name=chk_address]").prop("checked", true);

		$("input[name=chk_address]:checked").each(function(idx, e){			
			cellphone_info.push(e.dataset.cellphone);
			email_info.push(e.dataset.email);
			addStr += '<label class="label_added '+e.dataset.chk_id+'" onclick="javascript: tmpRemove(this);" data-chk_id="'+e.dataset.chk_id+'" data-cellphone="'+e.dataset.cellphone+'" data-email="'+e.dataset.email+'"><span>'+e.title+' X</span></label>';
	    	fixStr += '<label class="label_added '+e.dataset.chk_id+'" onclick="javascript: fixRemove(this);" data-chk_id="'+e.dataset.chk_id+'" data-cellphone="'+e.dataset.cellphone+'" data-email="'+e.dataset.email+'"><span>'+e.title+' X</span></label>';
		});
		
		//최종 타켓 배열 값을 임시로 전달 
		$("#tmp_cellphone").val(cellphone_info);
		$("#tmp_email").val(email_info);
		//라벨 추가
		$("#tmp_label").append(addStr);
		$("#fix_label").append(fixStr);
		
	}else {
		$("input[name=chk_address]").prop("checked", false);

		$("input[name=chk_address]:not(:checked)").each(function(idx, e){			
			//배열에서 제거 할 값의 index를 찾는다
			var find_1 = cellphone_info.indexOf(e.dataset.cellphone);
			var find_2 = email_info.indexOf(e.dataset.email);

			//index값을 근거로 배열에서 행을 삭제한다
			cellphone_info.splice(find_1, 1);
			email_info.splice(find_2, 1);

			//라벨 제거
			$("#tmp_label .label_added."+e.dataset.chk_id).remove();	
			$("#fix_label .label_added."+e.dataset.chk_id).remove();	
		});		
		
		//최종 타켓 배열 값을 임시로 전달 
		$("#tmp_cellphone").val(cellphone_info);
		$("#tmp_email").val(email_info);		
	}
	
}

//개별 추가
function clickChkbox(e){

	var addStr;
	var fixStr;
	var totalCnt = $("#total_cnt").val();
	var chkCnt = $("input[name=chk_address]:checked").length;

	if(totalCnt != chkCnt){
		$("#chk_all").prop("checked", false);
	}else {
		$("#chk_all").prop("checked", true);
	}

	if($(e).is(":checked")){

    	cellphone_info.push(e.dataset.cellphone);
    	email_info.push(e.dataset.email);
    	
    	//최종 타켓 배열 값을 임시 텍스트박스로 전달 
    	$("#tmp_cellphone").val(cellphone_info);
    	$("#tmp_email").val(email_info);
    		
    	addStr = '<label class="label_added '+e.dataset.chk_id+'" onclick="javascript: tmpRemove(this);" data-chk_id="'+e.dataset.chk_id+'" data-cellphone="'+e.dataset.cellphone+'" data-email="'+e.dataset.email+'"><span>'+e.title+' X</span></label>';
    	fixStr = '<label class="label_added '+e.dataset.chk_id+'" onclick="javascript: fixRemove(this);" data-chk_id="'+e.dataset.chk_id+'" data-cellphone="'+e.dataset.cellphone+'" data-email="'+e.dataset.email+'"><span>'+e.title+' X</span></label>';
    	//라벨 추가
    	$("#tmp_label").append(addStr);
    	$("#fix_label").append(fixStr);
	} else {
		//배열에서 제거 할 값의 index를 찾는다
		var find_1 = cellphone_info.indexOf(e.dataset.cellphone);
		var find_2 = email_info.indexOf(e.dataset.email);

		//index값을 근거로 배열에서 행을 삭제한다
		cellphone_info.splice(find_1, 1);
		email_info.splice(find_2, 1);

		//최종 타켓 배열 값을 임시 텍스트박스로 전달 
		$("#tmp_cellphone").val(cellphone_info);
		$("#tmp_email").val(email_info);
		//라벨 제거
		$("#tmp_label .label_added."+e.dataset.chk_id).remove();
		$("#fix_label .label_added."+e.dataset.chk_id).remove();		
	}	
}

function tmpRemove(e){
	//배열에서 제거 할 값의 index를 찾는다
	var find_1 = cellphone_info.indexOf(e.dataset.cellphone);
	var find_2 = email_info.indexOf(e.dataset.email);

	//index값을 근거로 배열에서 행을 삭제한다
	cellphone_info.splice(find_1, 1);
	email_info.splice(find_2, 1);

	//최종 타켓 배열 값을 임시 텍스트박스로 전달 
	$("#tmp_cellphone").val(cellphone_info);
	$("#tmp_email").val(email_info);
	//라벨 제거
	$("#tmp_label .label_added."+e.dataset.chk_id).remove();
	$("#fix_label .label_added."+e.dataset.chk_id).remove();
	//체크박스 해제
	if($("#"+e.dataset.chk_id)){
		$("#"+e.dataset.chk_id).prop("checked", false);
	}
}


function fixRemove(e){
	//배열에서 제거 할 값의 index를 찾는다
	var find_1 = cellphone_info.indexOf(e.dataset.cellphone);
	var find_2 = email_info.indexOf(e.dataset.email);

	//index값을 근거로 배열에서 행을 삭제한다
	cellphone_info.splice(find_1, 1);
	email_info.splice(find_2, 1);

	//최종 타켓 배열 값을 임시 텍스트박스로 전달 
	$("#tmp_cellphone").val(cellphone_info);
	$("#tmp_email").val(email_info);
	//라벨 제거
	$("#tmp_label .label_added."+e.dataset.chk_id).remove();
	$("#fix_label .label_added."+e.dataset.chk_id).remove();

	fix_target();
}

function fix_target(){

	$("#target_cellphone").val($("#tmp_cellphone").val());
	$("#target_email").val($("#tmp_email").val());

	//확정라벨을 모두 제거하고 선택라벨로 대체한다
	$("#"+view_tab+" .address_selected label").remove();
	$("#fix_label label").clone().appendTo("#"+view_tab+" .address_selected.fix");
	$("#tmp_label label").clone().appendTo("#"+view_tab+" .address_selected.tmp");

	//확정 배열을 임시 배열값으로 대체
	fix_cellphone_info = cellphone_info.slice();
	fix_email_info = email_info.slice();

	$("#chk_all").prop("checked", false);
	closePopup();
}

function clear_target(){
	$("#tmp_cellphone").val($("#target_cellphone").val());
	$("#tmp_email").val($("#target_email").val());

	//선택라벨을 모두 제거하고 확정 라벨로 대체한다
	$("#tmp_label label").remove();
	$("#fix_label label").remove();
	
	$("#"+view_tab+" .address_selected.fix label").clone().appendTo("#fix_label");
	$("#"+view_tab+" .address_selected.tmp label").clone().appendTo("#tmp_label");
	//임시 배열을 확정 배열값으로 대체
	cellphone_info = fix_cellphone_info.slice();
	email_info = fix_email_info.slice();

	$("#chk_all").prop("checked", false);
	closePopup();
}

</script>


</body>
</html>