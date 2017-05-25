<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<title>NOdeadplants</title>
</head>
<body>
<div id="wrap">
    <a href="?"><img src="logo.png"/></a>
	<ul id="menu">
		<?php if(isUserLoggedIn()): ?>
			<li><a href="?page=plants">Plants</a></li>
			<li><a href="?page=add">Add plants</a></li>
			<li><a href="?page=logout">Logout</a></li>
		<?php else: ?>
			<li><a href="?page=register">Register</a></li>
		<?php endif; ?>
	</ul>
	<div id="content">