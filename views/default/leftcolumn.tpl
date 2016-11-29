{* левый столбец *}
<div id="leftColumn">
    <nav id="leftMenu">
        <div class="menuCaption">Категории:</div>
        <ul>
            {foreach $categories as $category}
                <li><a href="#">{$category['name']}</a></li>
                {*{if isset($category['children'])}*}
                    {*<ul>*}
                        {*{foreach $category['children'] as $child}*}
                            {*<li><a href="#">{$child['name']}</a></li>*}
                        {*{/foreach}*}
                    {*</ul>*}
                {*{/if}*}
            {/foreach}
        </ul>
    </nav>
</div> {*/leftColumn*}
