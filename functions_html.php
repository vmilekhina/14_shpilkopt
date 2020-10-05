<?php if ($logged) { ?>
	<!-- editor -->
	<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
	<script type="text/javascript" src="ckfinder/ckfinder.js"></script>
	<script type="text/javascript" src="js/editor.js"></script>
	<!-- /editor -->
	<a href='?logout=1' class="logout-link">Выйти</a>
	<a href='?change_password=1' class="change-pwd-link">Сменить пароль</a>
	<style type="text/css">
		.logout-link { position: fixed; right: 10px; top: 10px; z-index: 100; }
		.change-pwd-link { position: fixed; right: 10px; top: 30px; z-index: 100; }
		.modal-change-pwd{
			color: #000000;
			width: 200px;
			padding: 10px;
			height: 100px;
			background: #ffffff;
			border: 1px solid;
		}
		.modal-change-pwd .pwd,
		.modal-change-pwd .pwd_new{
			border: 1px solid;
			padding: 2px 4px;
			margin: 5px 0;
		}
		.modal-change-pwd .close-btn{
			font-size: 14px;
			color: #000000;
			top: 10px;
			right: 10px;
			display: block;
			position: absolute;
		}
	</style>
<?php } else { ?>
	<script type="text/javascript">
		$('*').each(function() {
			if (!!$(this).attr('contenteditable'))
				$(this).attr('contenteditable', false);
		});
	</script>
	<style type="text/css">
		.modal-login{
			color: #000000;
			width: 200px;
			padding: 10px;
			height: 100px;
			background: #ffffff;
			border: 1px solid;
		}
		.modal-login .pwd{
			border: 1px solid;
			padding: 2px 4px;
			margin: 5px 0;
		}
		.modal-login .close-btn{
			font-size: 14px;
			color: #000000;
			top: 10px;
			right: 10px;
			display: block;
			position: absolute;
		}
	</style>
<?php } ?>
<div class="modals">
	<?php if (isset($_GET['login']) and !$logged) { ?>
		<div class="modal modal-login">
			<a class="close-btn" href="#" onclick="document.location.search='';">x</a>
			<form method="post" class="form-login">
				<input type="hidden" name="action" value="login" />
				<div class="form-title">Вход в систему</div>
				<?php if (!empty($errors)) { ?><div class='form-error'><?php echo $errors; ?></div><?php } ?>
				<div class="form-fields">
					<input type="password" name="pwd" value="" class="pwd" placeholder="Пароль" />
				</div>
				<div class="form-btn">
					<input type="submit" class="red-btn big-btn submit-login" name="submit_login" value="Войти" />
				</div>
			</form>
		</div>
		<script type="text/javascript">
			jQuery(function($) {
				$(".overlay").show();
				$(".modal-login").css({'position': 'fixed', 'z-index': '10000', 'left': '50%', 'top': '100px'}).show().css({'margin-left': '-' + $(".modal-login").outerWidth() / 2 + 'px'});
			});
		</script>
	<?php } ?>
	<?php if (isset($_GET['change_password']) and $logged) { ?>
		<div class="modal modal-change-pwd">
			<a class="close-btn" href="javascript:;"></a>
			<form method="post" class="form-change-pwd">
				<a class="close-btn" href="#" onclick="document.location.search='';">x</a>
				<input type="hidden" name="action" value="change_pwd" />
				<div class="form-title">Смена пароля</div>
				<?php if (!empty($errors)) { ?><div class='form-error'><?php echo $errors; ?></div><?php } ?>
				<div class="form-fields">
					<input type="password" name="pwd" value="" class="pwd" placeholder="Пароль" />
					<input type="password" name="pwd_new" value="" class="pwd_new" placeholder="Новый пароль" />
				</div>
				<div class="form-btn">
					<input type="submit" class="red-btn big-btn submit-login" name="submit_change_pwd" value="Сменить" />
				</div>
			</form>
		</div>
		<script type="text/javascript">
			jQuery(function($) {
				$(".overlay").show();
				$(".modal-change-pwd").css({'position': 'fixed', 'z-index': '10000', 'left': '50%', 'top': '100px', 'width': '220px'}).show().css({'margin-left': '-' + $(".modal-change-pwd").outerWidth() / 2 + 'px'});
			});
		</script>
	<?php } ?>
</div>