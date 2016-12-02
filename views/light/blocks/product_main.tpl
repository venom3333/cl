<div class="container">
    <ol class="breadcrumb">
        <li><a href="index.html">Home</a></li>
        <li class="active">Products</li>
    </ol>
    {*Левое меню*}
    {include file="blocks/leftnav.tpl"}
    {*/Левое меню*}

    <div class="col-md-10 product-model-sec">
        <h2>{$product['name']}</h2>
        <hr>
        <p>{$product['short_description']}</p>
        <hr>

        {* слайдер-плейсхолдер *}
        <script src="{$templateWebPath}js/unslider-min.js"></script>
        <script src="{$templateWebPath}js/product_slider.js"></script>

        <div class="productGallery">
            <ul>
                {foreach $product['images'] as $image}
                    <li style="background:url({$image['image']}) no-repeat 0 0; background-size:cover; min-height:300px;">
                        <h2>TEST</h2>
                    </li>
                {/foreach}
            </ul>
        </div>
        {* слайдер-плейсхолдер *}

        <p>{$product['description']}</p>

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                <tr>
                    <th>Диаметр</th>
                    <th>Длина</th>
                    <th>Ширина</th>
                    <th>Высота</th>
                    <th>Мощность</th>
                    <th>Сила света</th>
                    <th>Цена</th>
                </tr>
                </thead>
                <tbody>
                {foreach $product['specifications'] as $specification}
                    <tr>
                        <td>{$specification['diameter']}</td>
                        <td>{$specification['length']}</td>
                        <td>{$specification['width']}</td>
                        <td>{$specification['height']}</td>
                        <td>{$specification['power']}</td>
                        <td>{$specification['light_output']}</td>
                        <td>{$specification['price']}</td>
                    </tr>
                {/foreach}
                </tbody>
            </table>
        </div>

    </div>
</div>

