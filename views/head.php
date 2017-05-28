<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<title>NOdeadplants</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div id="wrap">
        <a href="?" id="logo"><img src="logo.png"/></a>
        <div id="menu">
            <ul>
                <?php if(isUserLoggedIn()): ?>
                    <li><a href="?page=addPlants">Add plants</a></li>
                    <li><a href="?page=logout">Logout</a></li>
                <?php else: ?>
                    <li><a href="?page=register">Register</a></li>
                <?php endif; ?>
            </ul>
        </div>
	<div id="content">

