<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>내집꾸미기</title>
    <script src="/resources/jquery-3.4.1.min.js"></script>
    <link rel="stylesheet" href="/resources/bootstrap-4.3.1-dist/css/bootstrap.min.css">
    <script src="/resources/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="/resources/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/resources/css/style.css">
    <script>
        $(function(){
            $(".custom-file-input").on("change", function(){
                if(this.files.length > 0)
                    $(this).siblings(".custom-file-label").text(this.files[0].name);
            });

            $("[data-target='#sign-up']").on("click", function(){
                let canvas = $("#captcha-canvas")[0];
                let ctx = canvas.getContext("2d");
                ctx.font = "40px 나눔스퀘어, sans-serif";

                let text = Math.random().toString(36).substr(2, 5);
                let tw = ctx.measureText(text).width;

                ctx.fillText(text, canvas.width / 2 - text.width / 2, canvas.height / 2 - 40 / 2);
                $("#captcha").val(text);
            });
        });
    </script>
</head>
<body>
    <!-- 헤더 영역 -->
    <div id="header">
        <div class="container h-100">
            <div class="d-between h-100">
                <div class="left align-items-center d-flex">
                    <a href="/" class="mr-5">
                        <img src="/resources/images/logo.svg" alt="내집꾸미기" title="내집꾸미기" height="50">
                    </a>
                    <div class="nav d-none d-lg-flex">
                        <a href="/">홈</a>
                        <a href="/online-party">온라인 집들이</a>
                        <a href="/store">스토어</a>
                        <a href="/specialists">전문가</a>
                        <a href="/estimates">시공 견적</a>
                    </div>
                </div>
                <div class="right d-flex align-items-center">
                    <div class="auth d-none d-lg-flex">
                        <?php if(user()):?>
                            <a href="#" data-toggle="modal" data-taret="#sign-in">로그인</a>
                            <a href="#" data-toggle="modal" data-target="#sign-up">회원가입</a>
                        <?php else:?>
                            <span class="fx-n2 text-gold"><?=user()->user_name?>(<?=user()->user_id?>)</span>
                            <a href="/logout">로그아웃</a>
                        <?php endif;?>
                    </div>
                    <button class="menu-btn mr-3 d-lg-none">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                    <div class="menu d-lg-none">
                        <div class="m-nav">
                            <a href="/">홈</a>
                            <a href="/online-party">온라인 집들이</a>
                            <a href="/store">스토어</a>
                            <a href="/specialists">전문가</a>
                            <a href="/estimates">시공 견적</a>
                        </div>
                        <div class="m-auth">
                            <?php if(user()):?>
                                <a href="#" data-toggle="modal" data-taret="#sign-in">로그인</a>
                                <a href="#" data-toggle="modal" data-target="#sign-up">회원가입</a>
                            <?php else:?>
                                <span class="fx-n2 text-gold mr-3"><?=user()->user_name?>(<?=user()->user_id?>)</span>
                                <a href="/logout">로그아웃</a>
                            <?php endif;?>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /헤더 영역 -->

    <!-- 로그인 모달 -->
    <div id="sign-in" class="modal fade">
        <div class="modal-dialog">
            <form action="/sign-in" method="post" class="modal-content">
                <div class="modal-body px-4 py-5">
                    <div class="title text-center mb-5">
                        SIGN IN
                    </div>
                    <div class="form-group">
                        <label for="login_id">아이디</label>
                        <input type="text" id="login_id" name="user_id" class="form-control" placeholder="아이디를 입력하세요" required>
                    </div>
                    <div class="form-group">
                        <label for="login_pw">비밀번호</label>
                        <input type="password" id="login_pw" name="password" class="form-control" placeholder="비밀번호를 입력하세요" required>
                    </div>
                    <div class="form-group mt-4">
                        <button class="black-btn w-100 py-3">로그인</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- /로그인 모달 -->

    <!-- 회원가입 모달 -->
    <div id="sign-up" class="modal fade">
        <div class="modal-dialog">
            <form action="/sign-up" method="post" class="modal-content">
                <div class="modal-body px-4 py-5">
                    <div class="title text-center mb-5">
                        SIGN UP
                    </div>
                    <div class="form-group">
                        <label for="join_id">아이디</label>
                        <input type="text" id="join_id" name="user_id" class="form-control" placeholder="아이디를 입력하세요" required>
                    </div>
                    <div class="form-group">
                        <label for="join_pw">비밀번호</label>
                        <input type="password" id="join_pw" name="password" class="form-control" placeholder="비밀번호를 입력하세요" required>
                    </div>
                    <div class="form-group">
                        <label for="join_name">이름</label>
                        <input type="text" id="join_name" name="user_name" class="form-control" placeholder="이름을 입력하세요" required>
                    </div>
                    <div class="form-group">
                        <label for="join_photo">사진</label>
                        <div class="custom-file">
                            <input type="file" id="join_photo" name="photo" class="custom-file-input">
                            <label for="join_photo" class="custom-file-label">파일을 업로드 하세요</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="hidden" id="captcha" name="captcha">
                        <canvas id="captcha-canvas" class="w-100" width="400" height="100"></canvas>
                        <input type="text" name="catpcha-input" class="form-control" placeholder="상단의 문자를 입력하세요">
                    </div>
                    <div class="form-group mt-4">
                        <button class="black-btn w-100 py-3">회원가입</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- /회원가입 모달 -->