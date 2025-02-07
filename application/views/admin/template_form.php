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
    <meta property="og:image" content="https://dr-wave.co.kr/public/images/logo.png" />
    <meta property="og:url" content="" />
    <link rel="icon" type="image/png" href="/public/common/css/logo_ics.png" />
    <link rel="stylesheet" href="/public/common/css/fontawesome.all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR&family=Roboto&Manjari:wght@100;400;700&display=swapp" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/public/common/css/reset.css" />
    <link rel="stylesheet" href="/public/common/css/admin.css" />
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
    <script src="/public/common/script/fontawesome.all.min.js"></script>
    <script defer type="text/javascript" src="/public/common/script/common.js"></script>
    <script defer type="text/javascript" src="/public/common/script/admin.js"></script>
    <!-- Google Tag Manager -->
    <script>
    (function(w, d, s, l, i) {
        w[l] = w[l] || [];
        w[l].push({
            'gtm.start': new Date().getTime(),
            event: 'gtm.js'
        });
        var f = d.getElementsByTagName(s)[0],
            j = d.createElement(s),
            dl = l != 'dataLayer' ? '&l=' + l : '';
        j.async = true;
        j.src = 'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
        f.parentNode.insertBefore(j, f);
    })(window, document, 'script', 'dataLayer', 'GTM-5Z935QD');
    </script>
    <!-- End Google Tag Manager -->
</head>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-NMXDBRXH4Y"></script>
<script>
window.dataLayer = window.dataLayer || [];

function gtag() {
    dataLayer.push(arguments);
}
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
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5Z935QD" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <script>
    $(function() {
        $("#tabs").tabs();
    });
    </script>
    <!-- aside, button -->
    <div class="container">
        <div class="blind"></div> <?php include_once APPPATH.'views/admin/inc_aside.php'; ?> <div class="main-content-wrap">
            <!-- flex 1 --> <?php include_once APPPATH.'views/admin/inc_header.php'; ?>
            <!-- flex 2 -->
            <main class="main-content">
                <ul class="tabs flex_row">
                    <li><button class="btn_tab active" data-tab="tab_1" onclick="messageOpenTab(this)">템플릿설정</button></li>
                    <li><button class="btn_tab" data-tab="tab_2" onclick="messageOpenTab(this)">미리보기</button></li>
                    <li><button class="btn_tab" data-tab="tab_3" onclick="messageOpenTab(this)">친구톡발송</button></li>
                    <li><button class="btn_tab" data-tab="tab_4" onclick="messageOpenTab(this)">E-MAIL발송</button></li>
                    <li><button class="btn_tab" data-tab="tab_5" onclick="messageOpenTab(this)">LMS발송</button></li>
                </ul>
                <!-- tab_content_wrap =  tab_content + popup -->
                <div class="tab_content_wrap">
                    <div id="tab_1" class="tab_content active">
                        <form name="frm1" id="frm1">
                            <table class="form-table">
                                <colgroup>
                                    <col width="25%" />
                                    <col width="75%" />
                                </colgroup>
                                <tbody>
                                    <tr>
                                        <th class="full_line require"><label for="profile_key">발신키구분</label></th>
                                        <td class="full_line">
                                            <select class="form-select" name="profile_key" id="profile_key"><?php
											foreach($dataProfile as $row){?> <option value="<?php echo $row["key"];?>" <?php echo $info["profile_key"]==$row["key"] ? "selected" : "";?>><?php echo $row["profile_nm"];?></option><?php
										}?> </select>
                                            <input type="hidden" name="profile_type" id="profile_type" value="<?php echo $info["profile_type"];?>" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="full_line require"><label for="msg_type_2">발송구분</label></th>
                                        <td class="full_line">
                                            <!-- <label><input type="radio" name="template_type" id="msg_type_1" value="at" <?php echo $info["template_type"]=="at" ? "checked" : "";?>/><span>알림톡</span></label> -->
                                            <label><input type="radio" name="template_type" id="msg_type_2" value="ft" <?php echo $info["template_type"]=="ft" ? "checked" : "";?> /><span>친구톡</span></label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="full_line require"><label>사용여부</label></th>
                                        <td class="full_line">
                                            <label><input type="radio" name="use_yn" id="use_yn_1" value="Y" <?php echo $info["use_yn"]=="Y" ? "checked" : "";?> /><span>사용</span></label>
                                            <label><input type="radio" name="use_yn" id="use_yn_2" value="N" <?php echo $info["use_yn"]=="N" ? "checked" : "";?> /><span>사용안함</span></label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="full_line require"><label for="template_cd">템플릿코드</label></th>
                                        <td class="full_line"><input type="text" name="template_cd" id="template_cd" value="<?php echo $info["template_cd"];?>" placeholder="템플릿코드" /></td>
                                    </tr>
                                    <tr>
                                        <th class="full_line require"><label for="title">제목</label></th>
                                        <td class="full_line"><input type="text" name="title" id="title" value="<?php echo $info["title"];?>" placeholder="템플릿명" /></td>
                                    </tr>
                                    <tr>
                                        <th onclick="javascript:cmmOpenPop('.pop_img');" style="cursor: pointer;"><label for="img_url">이미지선택</label></th>
                                        <td>
                                            <input type="text" name="img_url" id="img_url" value="<?php echo $info["img_url"];?>" readonly />
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><label for="img_link">이미지링크</label></th>
                                        <td><input type="text" name="img_link" id="img_link" value="<?php echo $info["img_link"];?>" /></td>
                                    </tr>
                                    <tr>
                                        <th class="full_line require"><label for="template_msg">메세지내용</label></th>
                                        <td class="full_line">
                                            <textarea name="template_msg" id="template_msg" placeholder="템플릿 메세지를 입력해주세요" onkeyup="javascript: adjustHeight('#template_msg');"><?php echo $info["template_msg"];?></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="full_line" onclick="javascript:msgBtnAdd();" style="cursor: pointer;"><label>버튼추가+</label></th>
                                        <td class="full_line"></td>
                                    </tr>
                                <tfoot class="item ft" id="ftButton"><?php
								for($i=1; $i<=$info["btn_cnt"]; $i++){?> <tr>
                                        <td>
                                            <button type="button" class="btn_remove" onclick="msgBtnRemove(this);">X</button>&nbsp;&nbsp; <select class="category-select form-select" name="btn_type[]">
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
                            <input type="hidden" name="editMode" id="editMode" value="<?php echo $editMode;?>" />
                            <input type="hidden" name="idx" id="idx" value="<?php echo $idx;?>" />
                        </form>
                        <div class="btn-wrap">
                            <button type="button" class="save-user form-btn" onclick="javascript:templateSave('<?php echo $editMode;?>');"><i class="fa-solid fa-circle-plus"></i> save</button>
                            <a href="<?php echo get_cookie("admin_return_url");?>"><button type="button" class="cancel-user form-btn"><i class="fa-solid fa-circle-minus"></i> cancel</button></a>
                        </div>
                    </div>
                    <!-- 탭 2 -->
                    <div id="tab_2" class="tab_content">
                        <div class="mobile_screen">
                            <div><?php
							if(!empty($info["img_link"])){
								echo '<a href="'.$info["img_link"].'" target="_black"><img src="'.$info["img_url"].'"/></a>';
							}else {
								echo !empty($info["img_url"])?'<img src="'.$info["img_url"].'"/>' : '';
							}?> </div>
                            <div><?php echo nl2br($info["title"].'<br/><br/>'.$info["template_msg"]);?></div>
                            <div><?php
							for($i=1; $i<=$info["btn_cnt"]; $i++){?> <a href="<?php echo $info["btn_link_".$i];?>" target="_blank"><button class="btn_link"><?php echo $info["btn_name_".$i];?></button></a><?php
							}?> </div>
                        </div>
                    </div>
                    <!-- 탭 3 -->
                    <div id="tab_3" class="tab_content">
                        <form name="frm_kakao" id="frm_kakao">
                            <table class="form-table">
                                <colgroup>
                                    <col width="25%" />
                                    <col width="75%" />
                                </colgroup>
                                <tbody>
                                </tbody>
                            </table>
                        </form>
                    </div>
                    <!-- 탭 4 -->
                    <div id="tab_4" class="tab_content">
                        <form name="frm_email" id="frm_email">
                            <table class="form-table">
                                <colgroup>
                                    <col width="25%" />
                                    <col width="75%" />
                                </colgroup>
                                <tbody>
                                </tbody>
                            </table>
                        </form>
                    </div>
                    <!-- 탭 5 -->
                    <div id="tab_5" class="tab_content">
                        <form name="frm_lms" id="frm_lms">
                            <table class="form-table">
                                <colgroup>
                                    <col width="25%" />
                                    <col width="75%" />
                                </colgroup>
                                <tbody>
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
                <!-- //tab_content_wrap -->
                <div class="pop_img">
                    <div class="btn_pop_close">
                        <!-- <a onclick="cmmClosePop('.pop_img');">Ⅹ</a> -->
                        <a onclick="cmmClosePop('.pop_img');"><i class="fa-solid fa-xmark"></i></a>
                    </div>
                    <!-- img_list -->
                    <ul class="img_list"><?php
                    foreach($img_data as $row){ ?> <li>
                            <img src="<?php echo $row["img_url"]?>" onclick="javascript: imgUrlView(this.src);" />
                            <h5><?php echo $row["img_name"]?></h5>
                        </li><?php
                    }?></ul>
                </div>
                <!-- 이미지 확대 -->
                <div class="pop_img_big">
                    <img src="" alt="확대">
                </div>
            </main>
            <script>
            $(window).on("load", function() {
                adjustHeight('#template_msg');
            });
            </script>
        </div>
        <!-- //main-content-wrap -->
    </div>
    <!-- <?php include_once APPPATH.'views/admin/inc_footer.php'; ?> -->
</body>
</html>