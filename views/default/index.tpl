{* центральный столбец *}
<div id="centerColumn">

    {foreach $items as $item}
    <div>
        {$item['name']}
    </div>
    <div>
        {$item['brand']}
    </div>
        {foreach $item['images'] as $image}
            <div>
                <img src="{$image['image']}" alt="">
            </div>
        {/foreach}
        {foreach $item['colors'] as $color}
            <div>
                {$color['color']}
            </div>
        {/foreach}
        {foreach $item['categories'] as $category}
            <div>
                {$category['category']}
            </div>
        {/foreach}
    {/foreach}