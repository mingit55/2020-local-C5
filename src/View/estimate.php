<!-- 비주얼 영역 -->
<div id="visual" style="height: 400px;">
    <div class="design-line d-none d-lg-block"></div>
    <div class="design-line d-none d-lg-block"></div>
    <div class="images">
        <img src="/resources/images/slide/1.jpg" alt="슬라이드 이미지" title="슬라이드 이미지">
    </div>
    <div class="position-center text-center mt-4">
        <div class="fx-7 font-weight-bolder segoe text-white">ESTIMATE</div>
        <div class="text-gray">전문적인 시공사에게 당신의 인테리어를 맡겨보세요</div>
    </div>
</div>
<!-- /비주얼 영역 -->

<!-- 요청 영역 -->
<div class="bg-white">
    <div class="container py-5">
        <div class="sticky-top bg-white pt-4">
            <div class="d-between align-items-end">
                <div>
                    <span class="text-muted">시공 견적 요청</span>
                    <div class="title">REQUESTS</div>
                </div>
                <button class="border-btn px-4 py-2" data-toggle="modal" data-target="#request-modal">
                    견적 요청
                    <i class="fa fa-angle-right ml-2"></i>
                </button>
            </div>
            <div class="table-head mt-3">
                <div class="cell-10">상태</div>
                <div class="cell-40">내용</div>
                <div class="cell-15">작성자</div>
                <div class="cell-15">시공일</div>
                <div class="cell-10">견적 개수</div>
                <div class="cell-10">+</div>
            </div>
        </div>
        <div class="list">
            <?php foreach($reqList as $req):?>
                <div class="table-row">
                    <div class="cell-10">
                        <?php if($req->sid):?>
                            <span class="bg-gold text-white px-2 py-1 fx-n1 rounded-pill">완료</span>
                        <?php else: ?>
                            <span class="bg-gold text-white px-2 py-1 fx-n1 rounded-pill">진행 중</span>
                        <?php endif;?>
                    </div>
                    <div class="cell-40">
                        <p class="text-muted fx-n2"><?=nl2br(htmlentities($req->content))?></p>
                    </div>
                    <div class="cell-15">
                        <span class="fx-n1"><?=$req->user_name?></span>
                        <small class="text-gold"><?=$req->user_id?></small>
                    </div>
                    <div class="cell-15">
                        <span class="fx-n1"><?=date("Y년 m월 d일", strtotime($req->start_date))?></span>
                    </div>
                    <div class="cell-10">
                        <span class="fx-n1"><?=number_format($req->cnt)?></span>
                        <small class="text-muted">개</small>
                    </div>
                    <div class="cell-10">
                        <?php if(user()->type && user()->id !== $req->uid && array_search($req->id, $myList) === false) :?>
                            <button class="black-btn" data-toggle="modal" data-target="#response-modal" data-id="<?=$req->id?>">견적 보내기</button>
                        <?php elseif(user()->id === $req->uid) :?>
                            <button class="black-btn" data-toggle="modal" data-target="#view-modal" data-id="<?=$req->id?>">견적 보기</button>
                        <?php else: ?>
                            -
                        <?php endif;?>
                    </div>
                </div>
            <?php endforeach;?>
        </div>
    </div>
</div>
<!-- /요청 영역 -->

<!-- 응답 영역 -->
<div class="bg-white">
    <div class="container py-5">
        <div class="sticky-top bg-white pt-4">
            <div>
                <span class="text-muted">보낸 견적</span>
                <div class="title">RESPONSES</div>
            </div>
            <div class="table-head mt-3">
                <div class="cell-10">상태</div>
                <div class="cell-40">내용</div>
                <div class="cell-15">작성자</div>
                <div class="cell-15">시공일</div>
                <div class="cell-10">입력한 비용</div>
                <div class="cell-10">+</div>
            </div>
        </div>
        <div class="list">
            <?php foreach($resList as $res):?>
            <div class="table-row">
                <div class="cell-10">
                    <?php if(!$res->sid):?>
                        <span class="bg-gold text-white px-2 py-1 fx-n1 rounded-pill">진행 중</span>
                    <?php elseif($res->sid === $res->id):?>
                        <span class="bg-gold text-white px-2 py-1 fx-n1 rounded-pill">선택</span>
                    <?php else: ?>
                        <span class="bg-gold text-white px-2 py-1 fx-n1 rounded-pill">미선택</span>
                    <?php endif;?>
                </div>
                <div class="cell-40">
                    <p class="text-muted fx-n2"><?=nl2br(htmlentities($res->content))?></p>
                </div>
                <div class="cell-15">
                    <span class="fx-n1"><?=$res->user_name?></span>
                    <small class="text-gold"><?=$res->user_id?></small>
                </div>
                <div class="cell-15">
                    <span class="fx-n1"><?=date("Y년 m월 d일", strtotime($res->start_date))?></span>
                </div>
                <div class="cell-10">
                    <span class="fx-n1"><?=number_format($res->price)?></span>
                    <small class="text-muted">원</small>
                </div>
                <div class="cell-10">
                    -
                </div>
            </div>
            <?php endforeach;?>
        </div>
    </div>
</div>
<!-- /응답 영역 -->

<!-- 요청 모달 -->
<div id="request-modal" class="modal fade">
    <div class="modal-dialog">
        <form class="modal-content" action="/estimates/requests" method="post">
            <div class="modal-body px-4 py-5">
                <div class="title text-center mb-5">
                    REQUEST
                </div>
                <div class="form-group">
                    <label for="start_date">시공일</label>
                    <input type="date" id="start_date" name="start_date" class="form-control" required>
                </div>
                <div class="form-group">
                    <textarea name="content" id="content" cols="30" rows="10" class="form-control" placeholder="작업 내용을 구체적으로 기재해 주세요!" required></textarea>
                </div>
                <div class="form-group mt-4">
                    <button class="black-btn w-100 py-3">작성 완료</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- /요청 모달 -->

<!-- 응답 모달 -->
<div id="request-modal" class="modal fade">
    <div class="modal-dialog">
        <form class="modal-content" action="/estimates/responses" method="post">
            <input type="hidden" id="qid" name="qid">
            <div class="modal-body px-4 py-5">
                <div class="title text-center mb-5">
                    RESPONSE
                </div>
                <div class="form-group">
                    <label for="price">가격</label>
                    <input type="number" id="price" name="price" class="form-control" min="0" step="1000" required>
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
        $("[data-target='#response-modal']").on("click", function(){
            $("#qid").val(this.dataset.id);
        });
    });
</script>
<!-- /응답 모달 -->


<!-- 보기 모달 -->
<div id="view-modal" class="modal fade">
    <div class="modal-dialog">
        <form class="modal-content" method="post" action="/estimates/pick">
            <input type="hidden" id="pick-qid" name="qid">
            <input type="hidden" id="pick-sid" name="sid">
            <div class="modal-body px-4 py-5">
                <div class="title text-center mb-5">
                    ESTIMATE
                </div>
                <div class="table-head">
                    <div class="cell-30">전문가 정보</div>
                    <div class="cell-40">비용</div>
                    <div class="cell-30">+</div>
                </div>
                <div class="list">
                    
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    $(function(){
        $("[data-target='#view-modal']").on("click", function(){
            $("#pick-qid").val(this.dataset.id);
            $.getJSON("/estimates/viewer?id="+qid, function(res){
                if(res.result){
                    $("#view-modal .list").html("");
                    res.list.forEach(item => {
                        $("#view-modal").append(`<div class="table-row">
                            <div class="cell-30">
                                <span class="fx-n1">${item.user_name}</span>
                                <small class="text-gold">(${item.user_id})</small>
                            </div>
                            <div class="cell-40">
                                <span>${item.price.toLocaleString()}</span>
                                <small class="text-muted">원</small>
                            </div>
                            <div class="cell-30">
                                ${
                                    res.request.sid ?
                                    `` 
                                    : `<button class="black-btn" data-id=${item.id}>선택</button>`
                                }
                            </div>
                        </div>`);
                    });
                }
            });
        });

        $("#view-modal form").on("submit", function(e){
            e.preventDefault();
        });

        $("#view-modal .list").on("click", "button", function(){
            $("#pick-sid").val(this.dataset.id);
            $("#view-modal form")[0].submit();
        });
    });
</script>
<!-- /보기 모달 -->