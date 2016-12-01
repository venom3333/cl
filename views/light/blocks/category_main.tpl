<div class="container">
    <ol class="breadcrumb">
        <li><a href="index.html">Home</a></li>
        <li class="active">Products</li>
    </ol>


    {*Левое меню*}
    <div class="rsidebar span_1_of_left">
        <section class="sky-form">
            <div class="product_right">
                <h4 class="m_2">Категории</h4>
                <div class="tab1">
                    {foreach $categories as $category}
                        <a href="#"><p>{$category['name']}</p></a>
                    {/foreach}
                </div>
        </section>
    </div>
    {*/Левое меню*}

    {*Список товаров категории*}
    <div class="col-md-10 product-model-sec">
        <h2>{$categoryHeader['name']}</h2>
        <hr>
        <p>{$categoryHeader['short_description']}</p>
        <hr>
        {foreach $products as $product}
        <div class="product-grid">
            <h4>{$product['name']}</h4>
            <div class="product-img b-link-stripe b-animate-go  thickbox">
                <img src="{$product['icon']}" class="img-responsive" alt="">
                <div class="b-wrapper">
                    <h4 class="b-animate b-from-left  b-delay03">
                        <button><span class="glyphicon glyphicon-zoom-in" aria-hidden="true"></span>Просмотр
                        </button>
                    </h4>
                </div>
            </div>
            <div class="product-info simpleCart_shelfItem">
                <div class="product-info-cust prt_name">
                    <p>{$product['short_description']}</p>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        {/foreach}
    </div>
    {*/Список товаров категории*}

    {*Список относящихся к категории проектов*}
    <div class="col-md-10 product-model-sec">
        <h3>Проекты с данной категорией</h3>
        <hr>
        <div class="product-grid">
            <h4>Освещение лужайки Путина</h4>
            <div class="product-img b-link-stripe b-animate-go  thickbox">
                <img src="http://placehold.it/200x200" class="img-responsive" alt="">
                <div class="b-wrapper">
                    <h4 class="b-animate b-from-left  b-delay03">
                        <button><span class="glyphicon glyphicon-zoom-in" aria-hidden="true"></span>Просмотр
                        </button>
                    </h4>
                </div>
            </div>
            <div class="product-info simpleCart_shelfItem">
                <div class="product-info-cust prt_name">
                    <p>Пара слов (абзацев) о проекте.</p>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>

    {*/Список относящихся к категории проектов*}

</div> {*/container*}