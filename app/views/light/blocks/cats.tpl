<div class="container">
    <div class="col-md-12 product-model-sec">
        {foreach $categories as $category}
            <div class="product-grid">
                <a href="/category/{$category['id']}">
                <h4>{$category['name']}</h4>
                <div class="product-img b-link-stripe b-animate-go  thickbox">
                    <img src="{$category['icon']}" class="img-responsive" alt="">
                    <div class="b-wrapper">
                        <h4 class="b-animate b-from-left  b-delay03">
                            <button><span class="glyphicon glyphicon-zoom-in" aria-hidden="true"></span>Просмотр
                            </button>
                        </h4>
                    </div>
                </div>
                <div class="product-info simpleCart_shelfItem">
                    <div class="product-info-cust prt_name">
                        <p>{$category['short_description']}</p>
                        <div class="clearfix"></div>
                    </div>
                </div>
                </a>
            </div>
        {/foreach}
    </div>
</div>
