{* центральный столбец *}
<div id="centerColumn">

    {foreach $items as $item}
        <div id="item">
            <p>
                Наименование: {$item['name']}
            </p>
            <p>
                Бренд: {$item['brand']}
            </p>
            {foreach $item['images'] as $image}
                <div>
                    <img src="{$image['image']}" alt="Изображение товара">
                </div>
            {/foreach}
            <div class="list">
                <p>Цвета: </p>
                {foreach $item['colors'] as $color}
                    <p>
                        {$color['color']}
                    </p>
                {/foreach}
            </div>
            <div class="clear"></div>
            <div class="list">
                <p>Категории:</p>
                {foreach $item['categories'] as $category}
                    <p>
                        {$category['category']}
                    </p>
                {/foreach}
            </div>
        </div>
    {/foreach}
