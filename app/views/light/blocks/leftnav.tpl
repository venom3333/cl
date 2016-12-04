{*Левое меню*}
<div class="rsidebar span_1_of_left">
    <section class="sky-form">
        <div class="product_right">
            <h4 class="m_2">Категории</h4>
            <div class="tab1">
                {foreach $categories as $category}
                    <a href="/category/{$category['id']}"><p>{$category['name']}</p></a>
                {/foreach}
            </div>
    </section>
</div>
{*/Левое меню*}