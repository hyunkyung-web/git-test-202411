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
                	<div>
                        <ul>
                            <li><a href="#tabs-1">메세지정보</a></li>
                            <li><a href="#tabs-2">카카오톡</a></li>
                            <li><a href="#tabs-3">이메일</a></li>
                            <li><a href="#tabs-4">LMS</a></li>
        				</ul>
    				</div>

				    <div id="tabs-1">
                    	<form name="frm1" id="frm1">
							<table class="form-table">
								<colgroup>
									<col width="25%" />
									<col width="75%" />
								</colgroup>
								<tbody>
								<tr>
									<th class="full_line require">발송구분</th>
									<td class="full_line">
										<!-- <label><input type="radio" name="template_type" id="msg_type_1" value="at" <?php echo $info["template_type"]=="at" ? "checked" : "";?>/><span>알림톡</span></label> -->
										<label><input type="radio" name="template_type" id="msg_type_2" value="ft" <?php echo $info["template_type"]=="ft" ? "checked" : "";?>/><span>친구톡</span></label>
										<input type="hidden" name="profile_key" id="profile_key" value="<?php echo $info["profile_key"];?>"/>
									</td>
								</tr>
								<tr>
									<th class="full_line require">템플릿코드</th>
									<td class="full_line"><input type="text" name="template_cd" id="template_cd" value="<?php echo $info["template_cd"];?>" placeholder="템플릿코드" readonly/></td>
								</tr>
								<tr>
									<th class="full_line require">제목</th>
									<td class="full_line"><input type="text" name="title" id="title" value="<?php echo $info["title"];?>" placeholder="템플릿명" readonly/></td>
								</tr>
								<tr>
									<th onclick="javascript:cmmOpenPop('.pop_img');" style="cursor: pointer;">이미지</th>
									<td>
										<input type="text" name="img_url" id="img_url" value="<?php echo $info["img_url"];?>" readonly/>
									</td>
								</tr>
								<tr>
									<th>이미지링크</th>
									<td><input type="text" name="img_link" id="img_link" value="<?php echo $info["img_link"];?>" readonly/></td>
								</tr>
								<tr>
									<th class="full_line require">메세지내용</th>
									<td class="full_line">
										<textarea name="template_msg" id="template_msg" placeholder="템플릿 메세지를 입력해주세요" readonly><?php echo $info["template_msg"];?></textarea>
									</td>
								</tr>
								<tr>
									<th colspan="2">버튼 정보</th>
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
							<input type="hidden" name="msg_target" id="msg_target"/>
                		</form>

                        <div class="btn-wrap"></div>
                	</div>

                	<div id="tabs-2">
                		<table class="form-table">
                			<colgroup>
                				<col width="50%">
                				<col width="50%">
                			</colgroup>
                			<tr>
                				<td>
                        			<div class="mobile_screen">
                            			<div><?php
                            			if(!empty($info["img_link"])){
                            			    echo '<a href="'.$info["img_link"].'" target="_black"><img src="'.$info["img_url"].'"/></a>';
                            			}else {
                            			    echo !empty($info["img_url"])?'<img src="'.$info["img_url"].'"/>' : '';
                            			}?>
                            			</div>
                            			<div><?php echo nl2br($info["title"].'<br/><br/>'.$info["template_msg"]);?></div>
                            			<div style="text-align: center;"><?php
                            			for($i=1; $i<=$info["btn_cnt"]; $i++){?>
                            			     <a href="<?php echo $info["btn_link_".$i];?>" target="_blank"><button class="btn_link"><?php echo $info["btn_name_".$i];?></button></a><?php
                            			}?>
            							</div>
                        			</div>
                				</td>
                				<td>
                					<div class="mobile_screen">
										<div class="address_list">
											<form name="frmSearch" id="frmSearch" >
												<div class="search-bar">
													<input type="hidden" name="sch_1">
													<input type="text" name="sch_2" placeholder="성명, 이메일, 연락처, 소속/부서" class="search-input" autocomplet="off" value="<?php echo $schData["sch_2"];?>" />
													<button type="button" class="search-button" onclick="javascript: noticeList(1);">Search</button>
												</div>
											</form>
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
																	<input type="checkbox" class="display-none" id="chk_all">
																	<span class="custom-checkbox"></span>
																</label>
															</th>
															<th>성명(이메일, 연락처, 소속/부서)</th>

														</tr>
													</thead>
													<tbody id="item-list">
														<tr>
															<td>
																<label>
																	<input type="checkbox" class="display-none" name="chk_address" id="chk_address_1" data-email="hyunkyung.kho@d-wave.co.kr" data-phone="01077672992" title="고현경">
																	<span class="custom-checkbox"></span>
																</label>
															</td>
															<td class="left">고현경(test@ddd.com)</td>
														</tr>
														<tr>
															<td >
																<label>
																	<input type="checkbox" class="display-none" name="chk_address" id="chk_address_2" data-email="kk.kkk@d-wave.co.kr" data-phone="01012345678"" title="홍길동">
																	<span class="custom-checkbox"></span>
																</label>
															</td>
															<td class="left">홍길동(test@ddd.com)</td>
														</tr>
														<tr>
															<td>
																<label>
																	<input type="checkbox" class="display-none" name="chk_address" id="chk_address_4" data-email="hyunkyung.kho@d-wave.co.kr" data-phone="01048586666" title="김성언">
																	<span class="custom-checkbox"></span>
																</label>
															</td>
															<td class="left">김성언(test@ddd.com)</td>
														</tr>
														<tr>
															<td>
																<label>
																	<input type="checkbox" class="display-none" name="chk_address" id="chk_address_5" data-email="hyunkyung.kho@d-wave.co.kr" data-phone="01098986666" title="조장운">
																	<span class="custom-checkbox"></span>
																</label>
															</td>
															<td class="left">조장운(test@ddd.com)</td>
														</tr>
														<tr>
															<td>
																<label>
																	<input type="checkbox" class="display-none" name="chk_address" id="chk_address_6" data-email="hyunkyung.kho@d-wave.co.kr" data-phone="01033336565" title="황지니">
																	<span class="custom-checkbox"></span>
																</label>
															</td>
															<td class="left">황지니(test@ddd.com)</td>
														</tr>
													</tbody>
												</table>
											</div>
											<div class="address_selected_wrap">
												<p class="address_selected">
													<!-- <label for="chk_address_1"><span>고현경 X</span></label> -->
												</p>
											</div>

											<input type="text" name="kakako_target" id="kakako_target"  />
											<!-- 발송 버튼 2개 -->
											<div class="btn_send_message flex_row flex_between">
												<button onclick="javascript: sendKakaoTalk('ft');" class="detail-btn">선택 발송</button>
												<button onclick="javascript: sendKakaoTalk('ft');" class="detail-btn"">전체 발송</button>
											</div>
											<!-- 발송 버튼 1개 small-->
											<div class="btn_send_message_type2 flex_row flex_end">
												<button onclick="javascript: sendKakaoTalk('ft');" class="red"">발송</button>
											</div>
											<!-- 발송 버튼 1개 big-->
											<div class="btn_send_message_type2_big flex_row flex_end">
												<button onclick="javascript: sendKakaoTalk('ft');" class="red"">발송</button>
											</div>
										</div>
									<!-- //address_list -->

									</div>

            					</td>
            				</tr>
            			</table>
                	</div>

                	<div id="tabs-3">
						<table class="form-table">
							<tr>
								<td><input type="text" name="kakako_target" id="kakako_target"  placeholder="받는사람을 선택하세요"/></td>
							</tr>								
							<tr>
								<td>
								<div class="mobile_screen">
									<div><?php echo $info["title"];?></div>
									<div><?php
                        			if(!empty($info["img_link"])){
                        			    echo '<a href="'.$info["img_link"].'" target="_black"><img src="'.$info["img_url"].'"/></a>';
                        			}else {
                        			    echo !empty($info["img_url"])?'<img src="'.$info["img_url"].'"/>' : '';
                        			}?>
                        			</div>
                        			<div><?php echo nl2br($info["template_msg"]);?></div>
                        			<div style="text-align: center;"><?php
                        			for($i=1; $i<=$info["btn_cnt"]; $i++){?>
                        			     <a href="<?php echo $info["btn_link_".$i];?>" target="_blank"><input type="button"><?php echo $info["btn_name_".$i];?></button></a><?php
                        			}?>
    								</div>
    							</div>
								</td>
							</tr>
							</tbody>
						</table>
    				</div>
    				<div id="tabs-4">
                    	<table class="form-table">
							<colgroup>
								<col width="50%" />
								<col width="50%" />
							</colgroup>
							<tr>
								<td></td>
								<td></td>
							</tr>
							</tbody>
						</table>
    				</div>
    				
    				<div class="주소록" style="width: 100%; position: absolute; top: 0; left: 0;">
    					<h1>주소록</h1>
    				</div>
    				
				</div>
				
				
            </main>

            <script>
            	$(window).on("load", function(){
            		adjustHeight('#template_msg');
            	});
            </script>

        </div>
        <!-- //main-content-wrap -->
    </div>
    <!-- <?php include_once APPPATH.'views/admin/inc_footer.php'; ?> -->



</body>
</html>