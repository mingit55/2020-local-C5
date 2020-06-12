<!-- 비주얼 영역 -->
<div id="visual" style="height: 400px;">
    <div class="design-line d-none d-lg-block"></div>
    <div class="design-line d-none d-lg-block"></div>
    <div class="images">
        <img src="/resources/images/slide/2.jpg" alt="슬라이드 이미지" title="슬라이드 이미지">
    </div>
    <div class="position-center text-center mt-4">
        <div class="fx-7 font-weight-bolder segoe text-white">PARTY</div>
        <div class="text-gray">당신만의 노하우를 모두에게 알려보세요</div>
    </div>
</div>
<!-- /비주얼 영역 -->

<!-- 온라인 집들이 -->
<div class="container padding">
    <div class="d-between align-items-end">
        <div>
            <span class="text-muted">온라인 집들이</span>
            <div class="title">KNOWHOW</div>
        </div>
        <button class="border-btn px-4 py-2" data-toggle="modal" data-target="#write-modal">
            글쓰기
            <i class="fa fa-pencil ml-2"></i>
        </button>
    </div>
    <hr class="mt-4 mb-5">
    <div class="row">
        <?php foreach($knowhows as $knowhow) :?>
        <div class="col-lg-3 col-md-6 mb-5 mb-lg-none">
            <div class="knowhow-item border">
                <div class="image">
                    <img class="fit-cover" src="/upload/knowhows/<?=$knowhow->before_img?>" alt="Before 이미지" title="Before 이미지">
                    <img class="fit-cover" src="/upload/knowhows/<?=$knowhow->after_img?>" alt="After 이미지" title="After 이미지">
                </div>
                <div class="mt-3 px-3 py-3">
                    <div class="d-between">
                        <div>
                            <span><?=$knowhow->user_name?></span>
                            <small class="text-gold ml-1">(<?=$knowhow->user_id?>)</small>
                            <small class="text-muted ml-1"><?=date("Y년 m월 d일", strtotime($knowhow->created_at))?></small>
                        </div>
                        <div class="text-gold">
                            <i class="fa fa-star"></i>
                            <?= $knowhow->cnt === 0 ? 0 : (int)($knowhow->total / $knowhow->cnt) ?>
                        </div>
                    </div>
                    <div class="mt-3">
                        <p class='text-muted fx-n1'><?= nl2br(htmlentities($knowhow->content)) ?></p>
                    </div>
                    <div class="mt-2 d-between">
                        <small class="text-muted">이 글의 평점을 매겨주세요</small>
                        <button class="black-btn" data-toggle="modal" data-target="#score-modal" data-id="<?=$knowhow->id?>">평점 주기</button>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach;?>
    </div>
</div>
<!-- /온라인 집들이 -->

<!-- 글쓰기 모달 -->
<div id="write-modal" class="modal fade">
    <div class="modal-dialog">
        <form method="/knowhows" method="post" enctype="multipart/form-data" class="modal-content">
            <div class="modal-body px-4 py-5">
                <div class="title text-center mb-5">
                    KNOWHOW
                </div>
                <div class="form-group">
                    <label for="before_img">Before 사진</label>
                    <div class="custom-file">
                        <input type="file" name="before_img" class="custom-file-input" id="before_img" required>
                        <label for="before_img" class="custom-file-label">파일을 업로드해 주세요</label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="after_img">After 사진</label>
                    <div class="custom-file">
                        <input type="file" name="after_img" class="custom-file-input" id="after_img" required>
                        <label for="after_img" class="custom-file-label">파일을 업로드해 주세요</label>
                    </div>
                </div>
                <div class="form-group">
                    <textarea name="content" id="content" cols="30" rows="10" class="form-control" placeholder="나만의 인테리어 노하우를 작성해 보세요!" required></textarea>
                </div>
                <div class="form-group mt-4">
                    <button class="black-btn w-100 py-3">작성 완료</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- /글쓰기 모달 -->

<!-- 평점 모달 -->
<div id="score-modal" class="modal fade">
    <div class="modal-dialog">
        <form action="/knowhows/reviews" method="post" class="modal-content">
            <input type="hidden" id="kid" name="kid">
            <input type="hidden" id="score" name="score">
            <div class="modal-body text-center py-3">
                <small>이 게시글의 평점을 매겨보세요!</small>
                <div>
                    <button class="mx-2 border border-gold text-gold px-2 py-1" data-value="1">
                        <i class="fa fa-star"></i>
                        1
                    </button>
                    <button class="mx-2 border border-gold text-gold px-2 py-1" data-value="2">
                        <i class="fa fa-star"></i>
                        2
                    </button>
                    <button class="mx-2 border border-gold text-gold px-2 py-1" data-value="3">
                        <i class="fa fa-star"></i>
                        3
                    </button>
                    <button class="mx-2 border border-gold text-gold px-2 py-1" data-value="4">
                        <i class="fa fa-star"></i>
                        4
                    </button>
                    <button class="mx-2 border border-gold text-gold px-2 py-1" data-value="5">
                        <i class="fa fa-star"></i>
                        5
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    $(function(){
        $("[data-target='#score-modal']").on("click", function(){
            $("#kid").val(this.dataset.id);
        });

        $("#score-modal form").on("submit", e => {
            e.preventDefault();
        }); 

        $("#score-modal button").on("click", function(){
            $("#score").val(this.dataset.value);
            $("#score-modal form")[0].submit();
        });
    });
</script>
<!-- /평점 모달 -->