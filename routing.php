<?php

$ROUTES=[];
$ROUTES[]=[['GET', 'POST'],'/{locale:en-us|fr-fr}[/]','Home'];

$ROUTES[]=[['GET', 'POST'],'/{locale:en-us|fr-fr}/message[/]','Message'];
$ROUTES[]=[['GET', 'POST'],'/{locale:en-us|fr-fr}/all-messages[/]','AllMessages'];

$ROUTES[]=[['GET', 'POST'],'/{locale:fr-fr}/debats[/]','Debats'];
$ROUTES[]=[['GET', 'POST'],'/{locale:en-us}/debates[/]','Debats'];

$ROUTES[]=[['GET', 'POST'],'/{locale:fr-fr}/debatons/{id:\d+}/{name}[/]','Debat'];
$ROUTES[]=[['GET', 'POST'],'/{locale:en-us}/debate/{id:\d+}/{name}[/]','Debat'];

$ROUTES[]=[['GET', 'POST'],'/{locale:fr-fr}/utilisateurs[/]','Users'];
$ROUTES[]=[['GET', 'POST'],'/{locale:en-us}/users[/]','Users'];

$ROUTES[]=[['GET', 'POST'],'/{locale:fr-fr}/utilisateur/{id:\d+}/{name}[/]','User'];
$ROUTES[]=[['GET', 'POST'],'/{locale:en-us}/user/{id:\d+}/{name}[/]','User'];



$ROUTES[]=[['GET', 'POST'],'/{locale:en-us|fr-fr}/user/select.{extension:json}','UserSelect'];
$ROUTES[]=[['GET', 'POST'],'/{locale:en-us|fr-fr}/user/save.{extension:json}','UserSave'];