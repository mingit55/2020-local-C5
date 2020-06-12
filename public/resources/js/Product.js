class Product {
    buyCount = 0;

    constructor(app, json){
        json.price = parseInt(json.price.replace(/[^0-9]/, ""));
        this.json = json;

        this.init();
        this.app = app;
        
        this.storeUpdate();
        this.cartUpdate();
    }

    init(){
        const {id, price, product_name, brand, photo} = this.json;
        this.id = id;
        this.price = price;
        this.product_name = product_name;
        this.brand = brand;
        this.photo = photo;
        return this;
    }

    storeUpdate(){
        const {id, price, product_name, brand, photo} = this;       
        
        if(!this.$storeElem){
            this.$storeElem = $(`<div class="col-lg-4 col-md-2 mb-5">
                                    <div class="store-item">
                                        <div class="image" draggable="draggable" data-id="${id}">
                                            <img src="/resources/images/store/${photo}" alt="상품 이미지" class="fit-cover">
                                        </div>
                                        <div class="mt-3 px-3">
                                            <div class="d-between align-items-end">
                                                <div class="w-50">
                                                    <div class="fx-n3 text-muted text-ellipsis brand" title="${brand}">${brand}</div>
                                                    <div class="fx-2 font-weight-bold text-ellipsis product_name" title="${product_name}">${product_name}</div>
                                                </div>
                                                <div class="w-50 text-right">
                                                    <strong class="text-gold fx-3">${price.toLocaleString()}</strong>
                                                    <small class="text-muted">원</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>`);
        } else {
            this.$storeElem.find(".product_name").html(product_name);
            this.$storeElem.find(".brand").html(brand);
        }
    }   

    cartUpdate(){
        const {price, product_name} = this.json;
        const {id, brand, photo} = this;              
        const total = this.buyCount * price;       
        
        if(!this.$cartElem){
            this.$cartElem = $(`<div class="table-row">
                                    <div class="cell-50">
                                        <div class="text-left d-flex align-items-center">
                                            <img src="./resources/images/store/${photo}" alt="상품 이미지" class="table-image">
                                            <div class="table-data px-4">
                                                <div class="fx-n3 text-muted text-ellipsis" title="${brand}">${brand}</div>
                                                <div class="fx-2 text-ellipsis" title="${product_name}">${product_name}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="cell-15">
                                        <span>${price.toLocaleString()}</span>
                                        <small class="text-muted">원</small>
                                    </div>
                                    <div class="cell-10">
                                        <input type="number" class="buy-count" min="1" value="${this.buyCount.toLocaleString()}" data-id="${id}">
                                    </div>
                                    <div class="cell-15">
                                        <span class="total fx-2 text-gold">${total.toLocaleString()}</span>
                                        <small class="text-muted">원</small>
                                    </div>
                                    <div class="cell-10">
                                        <button class="remove-btn" data-id="${id}">&times;</button>
                                    </div>
                                </div>`);                      
        } else {
            this.$cartElem.find(".buy-count").val(this.buyCount);
            this.$cartElem.find(".total").text(total.toLocaleString());
        }
    }
}