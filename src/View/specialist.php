<!-- 비주얼 영역 -->
<div id="visual" style="height: 400px;">
    <div class="design-line d-none d-lg-block"></div>
    <div class="design-line d-none d-lg-block"></div>
    <div class="images">
        <img src="/resources/images/slide/3.jpg" alt="슬라이드 이미지" title="슬라이드 이미지">
    </div>
    <div class="position-center text-center mt-4">
        <div class="fx-7 font-weight-bolder segoe text-white">SPECIALIST</div>
        <div class="text-gray">당신의 상상을 현실로 이뤄줄 전문적인 지식을 시공사들이 모였습니다</div>
    </div>
</div>
<!-- /비주얼 영역 -->

<!-- 전문가 소개 -->
<div class="container padding">
    <div>
        <span class="text-muted">전문가 소개</span>
        <div class="title">SPECIALISTS</div>
    </div>
    <hr class="mt-4 mb-5">
    <div class="row">
        <?php foreach($userList as $user):?>
        <div class="special-item col-lg-3 col-6 mb-5 mb-lg-none">
            <div class="inner">
                <div class="front">
                    <img src="/upload/users/<?=$user->photo?>" alt="전문가 이미지" title="전문가 이미지">
                </div>
                <div class="back">
                    <div class="w-100 h-100 d-flex flex-column-reverse align-items-center pb-5">
                        <div class="d-flex flex-column text-center align-items-center">
                            <span class="fx-2"><?=$user->user_name?></span>
                            <small class="text-muted">(<?=$user->user_id?>)</small>
                            <div class="mt-3">
                                <?php printScore($user->total, $user->cnt) ?>
                            </div>
                            <div class="bar my-3"></div>
                            <button class="black-btn px-4" data-toggle="modal" data-target="#review-modal" data-id="<?=$user->id?>">시공 후기작성</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach;?>
    </div>
</div>
<!-- /전문가 소개 -->

<!-- 시공 후기 -->
<div class="bg-gray">
    <div class="container py-5">
        <div class="sticky-top bg-gray pt-4">
            <div>
                <span class="text-muted">전문가 시공 후기</span>
                <div class="title">REVIEWS</div>
            </div>
            <div class="table-head mt-3">
                <div class="cell-15">전문가 정보</div>
                <div class="cell-40">후기 내용</div>
                <div class="cell-15">작성자</div>
                <div class="cell-15">비용</div>
                <div class="price15">평점</div>
            </div>
        </div>
        <div class="list">
            <?php foreach($reviewList as $review):?>
            <div class="table-row">
                <div class="cell-15">
                    <span><?=$review->s_name?></span>
                    <small class="text-gold">(<?=$review->s_id?>)</small>
                </div>
                <div class="cell-40">
                    <p class="fx-n2 text-muted"><?=nl2br(htmlentities($review->content))?></p>
                </div>
                <div class="cell-15">
                    <span><?=$review->user_name?></span>
                    <small class="text-muted"><?=$review->user_id?></small>
                </div>
                <div class="cell-15">
                    <span><?=number_format($review->price)?></span>
                    <small class="text-muted">원</small>
                </div>
                <div class="cell-15">
                    <div class="text-gold">
                        <?=printScore($review->score)?>
                    </div>
                </div>
            </div>
            <?php endforeach;?>
        </div>
    </div>
</div>
<!-- /시공 후기 -->


<!-- 시공 후기 모달  -->
<div id="review-modal" class="modal fade">
    <div class="modal-dialog">
        <form action="/specialists/review" class="modal-content" method="post">
            <input type="hidden" id="sid" name="sid">
            <div class="modal-body px-4 py-5">
                <div class="title text-center mb-5">
                    REVIEW
                </div>
                <div class="form-group">
                    <label for="price">비용</label>
                    <input type="number" class="form-control" id="price" name="price" value="1" min="0" step="1000" required>
                </div>
                <div class="form-group">
                    <label for="score">평점</label>
                    <select name="score" id="score" class="form-control" required>
                        <option value="1">1점</option>
                        <option value="2">2점</option>
                        <option value="3">3점</option>
                        <option value="4">4점</option>
                        <option value="5">5점</option>
                    </select>
                </div>
                <div class="form-group">
                    <textarea name="content" id="content" cols="30" rows="10" class="form-control" placeholder="시공 후기를 구체적으로 작성해 주세요!" required></textarea>
                </div>
                <div class="form-group mt-4">
                    <button class="black-btn w-100 py-3">작성 완료</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    $(function(){
        $("[data-target='#review-modal']").on("click", function(){
            $("#sid").val(this.dataset.id);
        });
    });
</script>
<!-- /시공 후기 모달  -->