<?php

return [
	'host' => 'localhost',
	'name' => 'marlincomp',
	'user' => 'root',
	'password' => '',
	'charset' => 'utf8',
	'opt' => [
		PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		PDO::ATTR_EMULATE_PREPARES   => false,
	],
];