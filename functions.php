<?php

$cur_page = explode('?', $_SERVER['REQUEST_URI'], 2);
$cur_page = $cur_page[0];

session_start();
$errors = '';

$logged = false;
if (isset($_SESSION['user_id']) and $_SESSION['user_id'] == 777) {
	$logged = true;
}

if ($_POST) {
	if (isset($_POST['action'])) {
		switch (trim($_POST['action'])) {
			
			case 'login':

				if (!$logged) {
					require_once 'config/admin.php';
					if (isset($admin_creds)) {
						$login = 'admin';
						$pwd = isset($_POST['pwd']) ? $_POST['pwd'] : '';

						if ($admin_creds[$login] == md5($pwd)) {
							$_SESSION['user_id'] = 777;
							header('Location: ' . $cur_page);
						} else {
							$errors .= 'Некорректная пара логин/пароль!<br/>';
						}
					}
				}

				break;

			case 'change_pwd':

				if ($logged) {

					$login = 'admin';
					$pwd = isset($_POST['pwd']) ? $_POST['pwd'] : '';
					$pwd_new = isset($_POST['pwd_new']) ? $_POST['pwd_new'] : '';
					
					if (strlen($pwd_new) < 6) {
						$errors .= 'Новый пароль должен быть длиной минимум 6 символов!<br/>';
					} else {
						require_once 'config/admin.php';
						if (!isset($admin_creds))
							$admin_creds = array();

						if (array_key_exists($login, $admin_creds) !== false) {
							if ($admin_creds[$login] === md5($pwd)) {
								$admin_creds[$login] = md5($pwd_new);
								file_put_contents('config/admin.php', '<?php' . PHP_EOL . '$admin_creds = ' . var_export($admin_creds, true) . ';');
								header('Location: ' . $cur_page);
							} else {
								$errors .= 'Некорректная пара логин/пароль!<br/>';
							}
						} else {
							$errors .= 'Некорректная пара логин/пароль!<br/>';
						}
					}
				} else {
					$errors .= 'Необходимо авторизоваться!<br/>';
				}

				break;
		}
	}
}

if (isset($_GET['logout'])) {
	session_unset();
	session_destroy();
	$_SESSION = array();
	header('Location: ' . $cur_page);
}