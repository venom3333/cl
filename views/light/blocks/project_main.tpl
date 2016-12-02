<div class="container">
    <ol class="breadcrumb">
        <li><a href="index.html">Home</a></li>
        <li class="active">Projects</li>
    </ol>
    {*Левое меню*}
    {include file="blocks/leftnav.tpl"}
    {*/Левое меню*}

    <div class="col-md-10 project-model-sec">
        <h2>{$project['name']}</h2>
        <hr>
        <p>{$project['short_description']}</p>
        <hr>

        {* слайдер-плейсхолдер *}
        <script src="{$templateWebPath}js/unslider-min.js"></script>
        <script src="{$templateWebPath}js/product_slider.js"></script>

        <div class="productGallery">
            <ul>
                {foreach $project['images'] as $image}
                    <li style="background:url({$image['image']}) no-repeat 0 0; background-size:cover; min-height:300px;">
                        <h2>TEST</h2>
                    </li>
                {/foreach}
            </ul>
        </div>
        {* слайдер-плейсхолдер *}

        <p>{$project['description']}</p>

    </div>
</div>

