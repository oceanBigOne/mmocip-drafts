<?php

$ROUTES=[];
$ROUTES[]=['GET','/{locale:en_US|fr_FR}[/]','home'];

$ROUTES[]=['GET','/{locale:fr_FR}/debats[/]','debats'];
$ROUTES[]=['GET','/{locale:en_US}/debates[/]','debats'];

$ROUTES[]=['GET','/{locale:fr_FR}/debatons/{id:\d+}/{name}[/]','debat'];
$ROUTES[]=['GET','/{locale:en_US}/debate/{id:\d+}/{name}[/]','debat'];

$ROUTES[]=['GET','/{locale:fr_FR}/utilisateurs[/]','users'];
$ROUTES[]=['GET','/{locale:en_US}/users[/]','users'];

$ROUTES[]=['GET','/{locale:fr_FR}/utilisateur/{id:\d+}/{name}[/]','user'];
$ROUTES[]=['GET','/{locale:en_US}/user/{id:\d+}/{name}[/]','user'];

$ROUTES[]=[['GET', 'POST'],'/{locale:fr_FR}/{extension:json}/utilisateur/sauvegarde[/]','userSave'];
$ROUTES[]=[['GET', 'POST'],'/{locale:en_US}/{extension:json}/user/save[/]','userSave'];