<?php

return FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
	// MainController
	$r->addRoute('GET', '/', ['app\controllers\MainController','indexAction']);
	$r->addRoute('POST', '/', ['app\controllers\MainController','sendCommentAction']);
	$r->addRoute('GET', '/register', ['app\controllers\MainController','registerAction']);
	$r->addRoute('POST', '/register', ['app\controllers\MainController','registerAction']);
	$r->addRoute('GET', '/login', ['app\controllers\MainController','loginAction']);
	$r->addRoute('POST', '/login', ['app\controllers\MainController','loginAction']);
	$r->addRoute('GET', '/verification', ['app\controllers\MainController','verificationEmailAction']);
	$r->addRoute('GET', '/logout', ['app\controllers\MainController','logoutAction']);
	
	// AccountController
	$r->addRoute('GET', '/profile', ['app\controllers\AccountController','profileAction']);
	$r->addRoute('POST', '/profile', ['app\controllers\AccountController','profileAction']);

	// // AdminController
	$r->addRoute('GET', '/admin', ['app\controllers\AdminController','adminAction']);
	$r->addRoute('POST', '/admin', ['app\controllers\AdminController','editAdminAction']);	
});