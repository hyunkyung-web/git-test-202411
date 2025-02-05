<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta http-equiv="Cache-Control" content="no-cache" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no"" />
    <title>KAKAO 컨텐트 상세보기</title>
    <meta property=" og:author" content="d'wave">
    <meta property="og:type" content="website">
    <meta property="og:title" content="닥터웨이브" />
    <meta property="og:description" content="닥터웨이브" />
    <meta property="og:image" content="https://dr-wave.co.kr/public/images/logo.png" />
    <meta property="og:url" content="" />
    <link rel="icon" type="image/png" href="/public/common/css/logo_ics.png" />
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR&family=Roboto&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="/public/common/css/user/main.css" />
    <link rel="stylesheet" href="/public/common/css/fontawesome.all.min.css" />
    <script type="text/javascript" src="/public/common/js/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="/public/common/js/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="/public/common/js/jquery.touchSwipe.min.js"></script>
    <script type="text/javascript" src="/public/common/js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="/public/common/js/jquery.ui.touch-punch.min.js"></script>
    <script src="/public/common/script/fontawesome.all.min.js"></script>
    <script type="text/javascript" src="/public/common/script/main.js"></script>
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
        j.src =
            'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
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

    <?php include_once APPPATH.'views/header.php'; ?>

    <section id="article-node" class="padd60">
        <button type="button" class="return_list">← Article로 돌아가기</button>
        <!-- <div class="cont_right padd20">
            <h1>CONTENT NAME</h1>
            <div class="cont_description">
                <p>CONTENT DESCRIPTION</p>
                <p>CONTENT DESCRIPTION</p>
                <p>CONTENT DESCRIPTION</p>
                <img src="/public/images/cont.png" alt="cont" />
            </div>
        </div> -->
        <!-- cont_left END -->

        <div class="cont_right padd20">
            <h1><?php echo $info["title"];?></h1>
            <div class="cont_description"><?php echo $info["body_text"];?></div>
        </div>
        <!-- cont_right END -->
        <!-- 첨부파일 박스 -->
        <div class="file_box flex_SB_center">
            <img src="/public/images/icon/icon_folder.png" alt="icon_folder" class="icon_folder">
            <a href="attached_file.file" download="">attached_file.file</a>
            <button type="button" class="btn_down"><img src="/public/images/icon/icon_down.png" alt="icon_down" class="icon_down"></button>
        </div>
        <button type="button" class="return_list list_bottom">목록</button>
    </section>

    <section id="reaction-area" class="padd60">
        <div class="cont_right padd20">
            <!-- <div class="cont_description"> -->
            <div class="react_area">
                <img src="/public/images/icon/icon_heart.png" alt="icon_heart" class="icon_heart">
                <span>좋아요 <span class="coountLike">4</span>개</span>
                <img src="/public/images/icon/icon_comment.png" alt="icon_comment" class="icon_comment">
                <span>댓글 <span class="countComment">3</span>개</span>
            </div>

            <div id="ajax_reply_list">
                <div class="comments_area padd10" id="ajax_reply_list">
                    <div class="comment_box">
                        <span class="c_name">dwave_it</span>
                        <span class="delete"><i class="fa-solid fa-minus"></i></span>
                        <span class="c_text">안녕하세요. 좋은 정보입니다.</span>
                    </div>
                </div>

            </div>
            <button type="button" class="btn_more">더보기 +</button>
            <button type="button" class="btn_fold">댓글 접기 ↑</button>
            <div class="enter_c_box flex_SB_center">
                <textarea name="c_box" id="c_box" placeholder="댓글 달기..." class="c_box" rows="1" onkeyup="resize(this)" onkeydown="resize(this)"></textarea>
                <button type="button" class="btn_chat">입력</button>
            </div>
            <!-- </div> -->
        </div>

    </section>
    <!-- contentBox END -->

    <?php include_once APPPATH.'views/footer.php'; ?>

    <script>
    //     	getReplyList();
    </script>

</body>

</html>