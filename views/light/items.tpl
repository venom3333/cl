<div class="items">
    <div class="container">
        <div class="items-sec">
            {foreach $items as $item}
                <div class="col-md-3 feature-grid">
                    <a href="product.html"><img src="{$item['icon']}" alt="Изображение товара">
                        <div class="arrival-info">
                            <h4>{$item['name']}</h4>
                            <p>{$item['brand']}</p>
                            <div class="enum">
                                <p>Цвета:</p>
                                {foreach $item['colors'] as $color}
                                    <p>
                                        {$color['color']}
                                    </p>
                                {/foreach}
                            </div>
                            <div class="clear"></div>
                            <div class="enum">
                                <p>Категории:</p>
                                {foreach $item['categories'] as $category}
                                    <p>
                                        {$category['category']}
                                    </p>
                                {/foreach}
                            </div>
                            <div class="clear"></div>
                            <span>Rs 18000</span>
                            <span class="disc">[12% Off]</span>
                        </div>
                        <div class="viw">
                            <a href="product.html"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>View</a>
                        </div>
                    </a>
                </div>
            {/foreach}
            <div class="clearfix"></div>
        </div>
    </div>
</div>