<div class="top-nav">
    <ul class="memenu skyblue">
        <li class="active"><a href="/">Главная</a></li>
        <li class="grid"><a href="#">Наша продукция</a>
            <div class="mepanel">
                <div class="row">
                    <div class="col1 me-one">
                        <h4>По типу:</h4>
                        <ul>
                            {foreach $categories as $category}
                                <li><a href="product.html">{$category['name']}</a></li>
                            {/foreach}
                        </ul>
                    </div>
                    <div class="col1 me-one">
                        <h4>По брендам:</h4>
                        <ul>
                            {foreach $brands as $brand}
                                <li><a href="product.html">{$brand['brand']}</a></li>
                            {/foreach}
                        </ul>
                    </div>
                </div>
            </div>
        </li>
        <li class="grid"><a href="#">Реализованные проекты</a>
            <div class="mepanel">
                <div class="row">
                    <div class="col1 me-one">
                        <h4>Наши технологии:</h4>
                        <ul>
                            <li><a href="product.html">New Arrivals</a></li>
                            <li><a href="product.html">Home</a></li>
                            <li><a href="product.html">Decorates</a></li>
                            <li><a href="product.html">Accessories</a></li>
                            <li><a href="product.html">Kids</a></li>
                            <li><a href="product.html">Login</a></li>
                            <li><a href="product.html">Brands</a></li>
                            <li><a href="product.html">My Shopping Bag</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </li>
        <li class="grid"><a href="typo.html">О компании</a></li>
        <li class="grid"><a href="contact.html">Контакты</a></li>
    </ul>
</div>