<div class="header">
	<div class="col-md-2 logo">
		<a href="/"><img src="/images/сustomlight-logo.svg" alt="Логотип"></a>
	</div>

	<!-- Навбар -->
	<div class="col-lg-8 nav-line">
		<? include_once APP . "/views/" . TEMPLATE . "/common/navbar.php" ?>
	</div>
	<!-- /Навбар -->
	<div class="col-md-2">
		<!--Виджет корзины-->
		<? include_once APP . "/views/" . TEMPLATE . "/common/carticon.php" ?>
		<!--/Виджет корзины-->
		<div class="h-line clearfix"></div>
		<div class="phone-number">
			<a href="#callback">8(495)773 71 59</a>
		</div>
	</div>
	<div class="clearfix"></div>

	<!--	Заказать звонок-->
	<div class="line-block col-md-12">
		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse col-md-2 col-md-offset-10 col-sm-12" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">Заказать звонок<b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li>
							<form class="callback" id="callback">
								<div class="form-group">
									<label for="inputName"></label>
									<input type="email" class="form-control" id="inputName" placeholder="Ваше имя"
									       required>
								</div>
								<div class="form-group">
									<label for="inputPhoneNumber"></label>
									<input type="text" class="form-control" id="inputPhoneNumber"
									       placeholder="Ваш телефон"
									       required>
								</div>
								<div class="form-group">
									<label for="inputText"></label>
									<textarea class="form-control" id="inputText" placeholder="Примечание"></textarea>
								</div>
								<button type="button" class="btn btn-default callback-mail-button">Заказать звонок
								</button>
							</form>
						</li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
	<!--	/Заказать звонок-->

	<div class="clearfix"></div>
</div>

