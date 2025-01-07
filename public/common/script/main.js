$(function () {
    // 댓글 버튼 눌렀을때 입력창 활성화
    $(".icon_comment").click(function () {
        $("#c_box").focus();
    });

    // 댓글 더보기
    showMore(".btn_more");

    // 좋아요 버튼 클릭시 빨간 하트 변경
    $(".icon_heart").click(function () {
        // controlImg(".icon_heart");
        const img_src = $(".icon_heart").attr("src");
        // console.log(img_src);
        if (img_src == "/public/images/icon/icon_heart.png") {
            $(".icon_heart").attr("src", "/public/images/icon/icon_heart_full.png");
        } else if (img_src == "/public/images/icon/icon_heart_full.png") {
            $(".icon_heart").attr("src", "/public/images/icon/icon_heart.png");
        }
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const hamburgerMenu = document.querySelector(".hamburger-menu");
    const navLinks = document.querySelector(".menu-toggle");

    navLinks.addEventListener("click", function () {
        hamburgerMenu.classList.toggle("active");
        navLinks.classList.toggle("active");
    });
});

function callData(pageNum) {
    var callUrl;

    switch (pageNum) {
        // main
        case 1:
            callUrl = "/";
            break;
        //member
        case 11:
            callUrl = "/member/verify";
            break;
        case 12:
            callUrl = "member/sign_up";
            break;
        // article
        case 2:
            callUrl = "/article/list";
            break;
        case 21:
            callUrl = "/article/node";
            break;
    }

    window.location.href = callUrl;
}

// 댓글 textarea 자동 높이 조절 + 입력 버튼 활성화
function resize(obj) {
    if (obj.style.height == "0px" || obj.scrollHeight == 0) {
        obj.style.height = "auto";
    } else {
        obj.style.height = "auto";
        obj.style.height = obj.scrollHeight + "px";
    }

    if (obj.value.length > 0) {
        $(".btn_chat").addClass("on");
    } else {
        $(".btn_chat").removeClass("on");
    }
}

// 댓글 더보기
function showMore(obj) {
    // 댓글 갯수 5이하 더보기 버튼 안보이기
    if ($(".comment_box").length <= 5) {
        $(obj).hide();
        $(".comment_box").addClass("show");
    } else {
        // 댓글 갯수 5이상 더보기 버튼 보이기
        $(".comment_box").slice(0, 5).addClass("show");
        $(obj).click(function (e) {
            e.preventDefault();
            $(".comment_box:hidden").slice(0, 5).addClass("show"); // 클릭시 more 갯수 지저정
            if ($(".comment_box:hidden").length == 0) {
                // 컨텐츠 남아있는지 확인
                $(obj).hide(); // 컨텐츠 없을 시 더보기 버튼 사라짐
                $(".btn_fold").show(); // 댓글 접기 버튼 활성화
            }
        });
    }

    $(".btn_fold").click(function () {
        $(".comment_box").removeClass("show");
        $(".comment_box").slice(0, 5).addClass("show");
        $(this).hide(); // 댓글 접기 버튼 사라짐
        $(obj).show(); // 더보기 버튼 활성화
    });
}

// 좋아요 버튼
function controlImg(obj) {
    const img_src = obj.attr("src");
    console.log(img_src);
    if (img_src == "/public/images/icon/icon_heart.png") {
        obj.attr("src", "/public/images/icon/icon_heart_full.png");
    } else if (img_src == "/public/images/icon/icon_heart_full.png") {
        obj.attr("src", "/public/images/icon/icon_heart.png");
    }
}
