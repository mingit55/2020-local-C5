<!-- 비주얼 영역 -->
<div id="visual" style="height: 400px;">
    <div class="design-line d-none d-lg-block"></div>
    <div class="design-line d-none d-lg-block"></div>
    <div class="images">
        <img src="/resources/images/slide/1.jpg" alt="슬라이드 이미지" title="슬라이드 이미지">
    </div>
    <div class="position-center text-center mt-4">
        <div class="fx-7 font-weight-bolder segoe text-white">STORE</div>
        <div class="text-gray">당신의 공간을 가득 채울 인테리어 아이템을 소개합니다</div>
    </div>
</div>
<!-- /비주얼 영역 -->

<!-- 장바구니 영역 -->
<div class="bg-gray">
    <div class="container py-5">
        <div class="sticky-top bg-gray pt-4">
            <div>
                <span class="text-muted">장바구니</span>
                <div class="title">CART</div>
            </div>
            <div class="table-head">
                <div class="cell-50">상품정보</div>
                <div class="cell-15">가격</div>
                <div class="cell-10">수량</div>
                <div class="cell-15">합계</div>
                <div class="cell-10">+</div>
            </div>
        </div>
        <div id="cart-list">
            <div class='w-100 py-4 text-center fx-n1 text-muted'>장바구니에 담긴 상품이 없습니다.</div>
        </div>
        <div class="d-between mt-4">
            <div>
                <span>총 합계</span>
                <span class="ml-3 text-gold fx-3 total-price">200,000</span>
                <span class="text-muted ml-1">원</span>
            </div>
            <div>
                <button class="border-btn fill-more px-5 py-2" data-toggle="modal" data-target="#buy-modal">
                    구매하기
                </button>
            </div>
        </div>
    </div>
</div>
<!-- /장바구니 영역 -->

<!-- 스토어 영역 -->
<div class="container py-5">
    <div class="sticky-top bg-white d-between align-items-end border-bottom pb-3">
        <div>
            <span class="text-muted">인테리어 스토어</span>
            <div class="title">STORE</div>
        </div>
        <div class="d-flex align-items-center">
            <input type="checkbox" id="open-cart" hidden checked>
            <div class="search">
                <span class="icon">
                    <i class="fa fa-search"></i>
                </span>
                <input type="text" placeholder="검색어를 입력하세요">
            </div>
            <label for="open-cart" class="cart-btn text-gold mr-5 ml-3">
                <i class="fa fa-shopping-cart fa-lg"></i>
            </label>
            <div id="drop-area">
                <div class="text-white text-center">
                    <div class="success position-center">
                        <i class="fa fa-check fa-3x"></i>
                    </div>
                    <div class="error position-center">
                        <i class="fa fa-times fa-3x"></i>
                        <p class="mt-3 fx-n2 text-nowrap">이미 장바구니에 담긴 상품입니다.</p>
                    </div>
                    <div class="normal position-center">
                        <i class="fa fa-shopping-cart fa-3x"></i>
                        <p class="mt-3 fx-n2 text-nowrap">이곳에 상품을 넣어주세요.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="store-list" class="row mt-5">
        <div class='w-100 py-4 text-center fx-n1 text-muted'>일치하는 상품이 없습니다.</div>
    </div>
</div>
<!-- /스토어 영역 -->

<!-- 구매하기 모달 -->
<div id="buy-modal" class="modal fade">
    <div class="modal-dialog">
        <form class="modal-content">
            <div class="modal-body px-4 py-5">
                <div class="title text-center mb-5">
                    PURCHASE
                </div>
                <div class="form-group">
                    <label for="username">구매자</label>
                    <input type="text" id="username" class="form-control" placeholder="이름을 입력해 주세요" required>
                </div>
                <div class="form-group">
                    <label for="address">주소</label>
                    <input type="text" id="address" class="form-control" placeholder="주소를 입력해 주세요" required>
                </div>
                <div class="form-group mt-4">
                    <button class="black-btn w-100 py-3">구매 완료</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- /구매하기 모달 -->

<!-- 구매내역 모달 -->
<div id="view-modal" class="modal fade">
    <div class="modal-dialog"></div>
    <img alt="구매내역" class="position-center" style="max-width: 100vw">
</div>
<!-- /구매내역 모달 -->

<script src="/resources/js/Product.js"></script>
<script src="/resources/js/App.js"></script>