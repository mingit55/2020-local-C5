class App {
    keyword = "";
    cartList = [];
    $storeList = $("#store-list");
    $cartList = $("#cart-list");
    $dropArea = $("#drop-area");

    constructor(){
        this.init();
        this.setEvent();
    }

    async init(){
        this.products = await this.getProducts();

        this.storeUpdate();
        this.cartUpdate();
    }

    storeUpdate(){
        let viewList = this.products.map(item => item.init());
        if(this.keyword.length > 0){
            let regex = new RegExp(this.keyword, "g");
            viewList = viewList.filter(item => regex.test(item.brand) || regex.test(item.product_name))
                .map(item => {
                    item.brand = item.brand.replace(regex, m1 => `<mark class="bg-gold">${m1}</mark>`);
                    item.product_name = item.product_name.replace(regex, m1 => `<mark class="bg-gold">${m1}</mark>`);
                    return item;
                });
        }

        this.$storeList.html("");
        if(viewList.length > 0){
            viewList.forEach(item => {
                item.storeUpdate();
                this.$storeList.append(item.$storeElem);
            });
        } else {
            this.$storeList.html("<div class='w-100 py-4 text-center fx-n1 text-muted'>일치하는 상품이 없습니다.</div>");
        }
    }

    cartUpdate(){
        let total = this.cartList.reduce((p, c) => p + c.buyCount * c.price, 0);
        
        this.$cartList.html("");
        if(this.cartList.length > 0){
            this.cartList.forEach(item => {
                item.cartUpdate();
                this.$cartList.append(item.$cartElem);
            });
        } else {
            this.$cartList.html("<div class='w-100 py-4 text-center fx-n1 text-muted'>장바구니에 담긴 상품이 없습니다.</div>");
        }

        $(".total-price").text(total.toLocaleString());
    }

    getProducts(){
        return fetch("/resources/json/store.json")
            .then(res => res.json())
            .then(jsonList => jsonList.map(json => new Product(this, json)));
    }

    setEvent(){
        // 장바구니에 물품 담기
        let target, startPoint;
        this.$storeList.on("dragstart", ".image", e => {
            e.preventDefault();
            target = e.currentTarget;
            startPoint = [e.pageX, e.pageY];

            target.style.zIndex = "1500";
            target.style.transition = "none";
        });

        $(window).on("mousemove", e => {
            if(!target || !startPoint || e.which !== 1) return;

            let x = e.pageX - startPoint[0];
            let y = e.pageY - startPoint[1];

            $(target).css({
                left: x + "px",
                top: y + "px"
            });
        });

        let timeout;
        $(window).on("mouseup", e => {
            if(!target || !startPoint || e.which !== 1) return;

            let width = this.$dropArea.width();
            let height = this.$dropArea.height();
            let {left, top} = this.$dropArea.offset();

            if(left <= e.pageX && e.pageX <= left + width && top <= e.pageY && e.pageY <= top + height) {
                // # 상품이 장바구니 위에 드롭됨
                if(timeout){
                    clearTimeout(timeout);
                }
                this.$dropArea.removeClass("success");
                this.$dropArea.removeClass("error");

                let _target = target;
                let id = _target.dataset.id;
                let product = this.products.find(item => item.id == id);
                let exist = this.cartList.some(item => item == product);

                if(exist){
                    // # 상품이 장바구니에 이미 담김
                    this.$dropArea.addClass("error");

                    $(target).animate({
                        left: 0,
                        top: 0,
                    }, 350, function(){
                        this.style.zIndex = "0";
                    });
                } else {
                    // # 상품을 장바구니에 담음
                    this.$dropArea.addClass("success");

                    $(_target).css({
                        left: 0,
                        top: 0,
                        zIndex: 0,
                        transform: "scale(0.1)",
                    });
                    setTimeout(() => {
                        _target.style.transition = "0.35s";
                        _target.style.transform = "scale(1)";
                    });

                    product.buyCount = 1;
                    this.cartList.push(product);
                    this.cartUpdate();
                }

                timeout = setTimeout(() => {
                    this.$dropArea.removeClass("success");
                    this.$dropArea.removeClass("error");
                }, 1500);

            } else {
                // # 원래 상태로 돌아감
                $(target).animate({
                    left: 0,
                    top: 0,
                }, 350, function(){
                    this.style.zIndex = "0";
                });
            }

            target = null;
            startPoint = null;
        });

        // 장바구니 아이템 삭제
        this.$cartList.on("click", ".remove-btn", e => {
            let id = e.currentTarget.dataset.id;
            let idx = this.cartList.findIndex(item => item.id == id);
            if(idx >= 0){
                let product = this.cartList[idx];
                product.buyCount = 0;

                this.cartList.splice(idx, 1);
                this.cartUpdate();
            }
        });

        // 장바구니 수량 변경
        this.$cartList.on("input", ".buy-count", e => {
            let value = parseInt(e.target.value);
            
            if(isNaN(value) || !value || value < 1) value = 1;
            
            let product = this.cartList.find(item => item.id == e.target.dataset.id);
            product.buyCount = value;

            this.cartUpdate();
            e.target.focus();
        });

        // 구매하기 버튼
        $("#buy-modal form").on("submit", e => {
            e.preventDefault();

            const PADDING = 40;
            const TEXT_SIZE = 15;
            const TEXT_GAP = 20;
            
            let canvas = document.createElement("canvas");
            let ctx = canvas.getContext("2d");
            ctx.font = `${TEXT_SIZE}px 나눔스퀘어, sans-serif`;

            let now = new Date()
            let total = this.cartList.reduce((p, c) => p + c.buyCount * c.price, 0);
            let text_time = `구매일시        ${now.getFullYear()}-${now.getMonth()}-${now.getDate()} ${now.getHours()}:${now.getMinutes()}:${now.getSeconds()}`;
            let text_price = `총 합계        ${total.toLocaleString()}원`;

            let viewList = [
                ... this.cartList.map(product => {
                    let text = `${product.json.product_name}        ${product.price.toLocaleString()}원 × ${product.buyCount.toLocaleString()}개 = ${(product.price * product.buyCount).toLocaleString()}원`;
                    let width = ctx.measureText(text).width;
                    return {text, width};
                }),
                { text: text_time, width: ctx.measureText(text_time).width },
                { text: text_price, width: ctx.measureText(text_price).width }
            ];

            let maxw = viewList.reduce((p, c) => Math.max(p, c.width), 0);
            canvas.width = PADDING * 2 + maxw;
            canvas.height = PADDING * 2 + (TEXT_GAP + TEXT_SIZE) * viewList.length
            
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            ctx.fillStyle = "#fff";
            ctx.fillRect(0, 0, canvas.width, canvas.height);

            ctx.font = `${TEXT_SIZE}px 나눔스퀘어, sans-serif`;
            ctx.fillStyle = "#333";

            viewList.forEach(({text}, i) => {
                let y = PADDING + (TEXT_GAP + TEXT_SIZE) * i;
                ctx.fillText(text, PADDING, y);
            });

            let url = canvas.toDataURL("image/jpeg");
            $("#view-modal img").attr("src", url);
            $("#view-modal").modal("show");
            $("#buy-modal").modal("hide");
            
            this.cartList.forEach(item => item.buyCount = 0);
            this.cartList = [];
            this.cartUpdate();

        });

        // 검색
        $(".search input").on("input", e => {
            this.keyword = e.target.value
                .replace(/([\^\$\(\)\[\]\.*+?\\\\\\/])/g, "\\$1")
                .replace(/(ㄱ)/g, "[가-깋]")
                .replace(/(ㄴ)/g, "[나-닣]")
                .replace(/(ㄷ)/g, "[다-딯]")
                .replace(/(ㄹ)/g, "[라-맇]")
                .replace(/(ㅁ)/g, "[마-밓]")
                .replace(/(ㅂ)/g, "[바-빟]")
                .replace(/(ㅅ)/g, "[사-싷]")
                .replace(/(ㅇ)/g, "[아-잏]")
                .replace(/(ㅈ)/g, "[자-짛]")
                .replace(/(ㅊ)/g, "[차-칳]")
                .replace(/(ㅋ)/g, "[카-킿]")
                .replace(/(ㅌ)/g, "[타-팋]")
                .replace(/(ㅍ)/g, "[파-핗]")
                .replace(/(ㅎ)/g, "[하-힣]");
            this.storeUpdate();
        });
    }
}

window.onload = function(){
    window.app = new App();
}