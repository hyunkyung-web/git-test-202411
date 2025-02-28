<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta http-equiv="Cache-Control" content="no-cache" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no" />
    <title>Support - Call</title>
    <meta property="og:author" content="d'wave">
    <meta property="og:type" content="website">
    <meta property="og:title" content="닥터웨이브" />
    <meta property="og:description" content="닥터웨이브" />
    <meta property="og:image" content="https://dr-wave.co.kr/public/images/logo.png" />
    <meta property="og:url" content="" />
    <link rel="icon" type="image/png" href="/public/common/css/logo_ics.png" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous" />
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
    '2pp_name': 'dr-wave.co.kr',
    '3creen_name': 'Home'
});
4
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

    <div class="member-wrap support-wrap">
        <div class="folder-index">
            <div class="index index_1 active" onclick="switchTab(this)">고객 지원</div>
            <div class="index index_2" onclick="switchTab(this)">요청 내역</div>
        </div>
        <div class="container request-container active">
            <div class="member_logo support">
                <h1>고객 지원</h1>
            </div>

            <div class="member-container call-container">
                <p>* 방문 요청, 자료 요청 등을 할 수 있습니다.</p>
                <!-- <p style="font-size: 0.9em; color: #aaa">요청 내역을 보시려면 <span style="text-decoration: underline">여기</span>를 클릭해주세요.</p> -->
                <form class="signup-form call-form" id="frm1" name="frm1">
                    <div class="form_item call_item">
                        <div class="chatBot">
                            <img src="/public/images/icon/icon_face.png" alt="icon_bot" class="icon_bot">
                            <input type="text" name="partner" id="partner" placeholder="담당자를 선택해주세요." readonly="readonly" value="" />
                        </div>
                        <div class="select_contact">담당자 검색</div>
                    </div>

                    <div class="form_item call_item">
                        <div class="chatBot">
                            <img src="/public/images/icon/icon_face.png" alt="icon_bot" class="icon_bot">
                            <input type="text" name="call_type" id="call_type" placeholder="요청 사항을 선택해주세요." readonly="readonly" />
                        </div>
                        <div class="call_box">
                            <label for="call_visit">
                                <input type="radio" name="type" id="call_visit" value="" class="chk_type">
                                <span class="radio_img"></span>
                                <!-- <label for="call_visit" class="type_val">방문요청</label> -->
                                <span class="type_val">방문요청</span>
                            </label>

                            <label for="call_doc">
                                <input type="radio" name="type" id="call_doc" value="" class="chk_type">
                                <span class="radio_img"></span>
                                <span class="type_val">자료요청</span>
                            </label>

                            <label for="call_etc">
                                <input type="radio" name="type" id="call_etc" value="" class="chk_type">
                                <span class="radio_img"></span>
                                <span class="type_val">기타</span>
                            </label>
                        </div>
                    </div>

                    <div class="form_item call_item inform_box visit_box">
                        <div class="chatBot">
                            <img src="/public/images/icon/icon_face.png" alt="icon_bot" class="icon_bot">
                            <input type="text" name="inform" id="inform" placeholder="아래 정보를 입력해주세요." readonly="readonly" />
                        </div>
                        <div class="informs visit">
                            <!-- 날짜 시간 요청내용 -->
                            <div class="inform date">
                                <span>날짜</span>
                                <input type="date" id="date" name="date" />
                            </div>

                            <div class="inform text">
                                <span>요청 내용</span>
                                <textarea name="detail" id="call_detail" rows="4" placeholder="요청 내용을 입력하세요."></textarea>
                            </div>

                        </div>
                    </div>
                    <div class="form_item call_item inform_box doc_box">
                        <div class="chatBot">
                            <img src="/public/images/icon/icon_face.png" alt="icon_bot" class="icon_bot">
                            <span>아래 정보를 입력해주세요.</span>
                        </div>
                        <div class="informs doc">
                            <!-- 요청내용 -->
                            <div class="inform text">
                                <span>요청 내용</span>
                                <textarea name="detail" id="doc_detail" rows="4" placeholder="요청 내용을 입력하세요."></textarea>
                            </div>

                        </div>
                    </div>

                    <button type="button" class="requestButton">요청하기</button>
                </form>
            </div>

            <!-- 담당자 list -->
            <div class="assigneeList padd20">
                <div class="assigneeList_header flex_SB_center">
                    <p>* 담당자를 선택해주세요.</p>
                    <span class="close"><i class="fa-regular fa-circle-xmark" style="color: #181c32;"></i></span>
                </div>

                <div class="searchBox flex_SB_center">
                    <select name="sch_p" id="sch_p" class="list_select">
                        <option value="">이름</option>
                        <!-- <option value="">이메일</option> -->
                        <!-- <option value="">연락처</option> -->
                        <option value="">부서</option>
                    </select>
                    <input type="text" name="searchInput" id="searchInput" class="searchInput" placeholder="검색어를 입력하세요.">
                    <button type="button" class="searchButton">검색</button>
                </div>
                <div class="tableWrapper">
                    <div class="theadRow">
                        <div class="headerCell headerCell1">
                            <input type="checkbox" class="checkbox" name="chk_all" id="chk_all">
                        </div>
                        <div class="headerCell headerCell2">이름</div>
                        <!-- <div class="headerCell headerCell3">이메일</div> -->
                        <!-- <div class="headerCell headerCell4">연락처</div> -->
                        <div class="headerCell headerCell5">부서</div>
                    </div>

                    <div class="tableBody">
                        <div class="rowItem">
                            <div class="tableCell tableCell1">
                                <input type="checkbox" class="checkbox" name="chk_p">
                            </div>
                            <div class="tableCell tableCell2 p_name">홍길동</div>
                            <!-- <div class="tableCell tableCell3 p_email">dwave_it@d-wave.co.kr</div> -->
                            <!-- <div class="tableCell tableCell4">010-1111-2222</div> -->
                            <div class="tableCell tableCell5">XX부서</div>
                        </div>
                        <div class="rowItem">
                            <div class="tableCell tableCell1">
                                <input type="checkbox" class="checkbox" name="chk_p">
                            </div>
                            <div class="tableCell tableCell2 p_name">네이버</div>
                            <!-- <div class="tableCell tableCell3 p_email">naver@naver.com</div> -->
                            <!-- <div class="tableCell tableCell4">010-1234-1234</div> -->
                            <div class="tableCell tableCell5">YY부서</div>
                        </div>
                        <div class="rowItem">
                            <div class="tableCell tableCell1">
                                <input type="checkbox" class="checkbox" name="chk_p">
                            </div>
                            <div class="tableCell tableCell2 p_name">김구글</div>
                            <!-- <div class="tableCell tableCell3 p_email">google@gmail.com</div> -->
                            <!-- <div class="tableCell tableCell4">010-2222-3333</div> -->
                            <div class="tableCell tableCell5">AA부서</div>
                        </div>
                        <div class="rowItem">
                            <div class="tableCell tableCell1">
                                <input type="checkbox" class="checkbox" name="chk_p">
                            </div>
                            <div class="tableCell tableCell2 p_name">이다음</div>
                            <!-- <div class="tableCell tableCell3 p_email">daum@daum.net</div> -->
                            <!-- <div class="tableCell tableCell4">010-3333-4444</div> -->
                            <div class="tableCell tableCell5">DD부서</div>
                        </div>
                    </div>
                </div>

                <div class="assigneeList_footer">
                    <button type="button" class="btn_select">다음</button>
                </div>
            </div>
        </div>

        <!-- 요청 내역 -->
        <div class="container request-history">
            <div class="member_logo support">
                <h1>요청 내역</h1>
            </div>

            <div class="requestList padd20">
                <!-- 요청 내역 없음 -->
                <div class="requestNone">
                    <p>요청 내역이 없습니다.</p>
                </div>

                <!-- 요청내역 list -->
                <div class="tableWrapper user">
                    <!-- 요청 내역 Title -->
                    <div class="theadRow user">
                        <div class="headerCell numCol">번호</div>
                        <div class="headerCell requestType">요청타입</div>
                        <div class="headerCell assigned">담당자</div>
                        <div class="headerCell requestDate">요청날짜</div>
                    </div>

                    <!-- 요청 내역 item -->
                    <div class="tableBody user">
                        <div class="rowItem requestItem">
                            <div class="tableCell numCell">1</div>
                            <div class="tableCell typeCell">방문요청</div>
                            <div class="tableCell assignCell">홍길동</div>
                            <div class="tableCell dateCell">2025-01-17</div>
                        </div>
                        <div class="rowItem requestItem">
                            <div class="tableCell numCell">2</div>
                            <div class="tableCell typeCell">자료요청</div>
                            <div class="tableCell assignCell">김구글</div>
                            <div class="tableCell dateCell">2025-01-17</div>
                        </div>
                        <div class="rowItem requestItem">
                            <div class="tableCell numCell">3</div>
                            <div class="tableCell typeCell">기타</div>
                            <div class="tableCell assignCell">이다음</div>
                            <div class="tableCell dateCell">2025-01-17</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="blind"></div>
    </div>

    <?php include_once APPPATH.'views/footer.php'; ?>

</body>

</html>