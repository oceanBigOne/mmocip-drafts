<?php

$ROUTES=[];
$ROUTES[]=[['GET', 'POST'],'/{locale:en-us|fr-fr}[/]','home'];

$ROUTES[]=[['GET', 'POST'],'/{locale:en-us|fr-fr}/message[/]','message'];
$ROUTES[]=[['GET', 'POST'],'/{locale:en-us|fr-fr}/all-messages[/]','allMessages'];

$ROUTES[]=[['GET', 'POST'],'/{locale:fr-fr}/debats[/]','debats'];
$ROUTES[]=[['GET', 'POST'],'/{locale:en-us}/debates[/]','debats'];

$ROUTES[]=[['GET', 'POST'],'/{locale:fr-fr}/debatons/{id:\d+}/{name}[/]','debat'];
$ROUTES[]=[['GET', 'POST'],'/{locale:en-us}/debate/{id:\d+}/{name}[/]','debat'];

$ROUTES[]=[['GET', 'POST'],'/{locale:fr-fr}/utilisateurs[/]','users'];
$ROUTES[]=[['GET', 'POST'],'/{locale:en-us}/users[/]','users'];

$ROUTES[]=[['GET', 'POST'],'/{locale:fr-fr}/utilisateur/{id:\d+}/{name}[/]','user'];
$ROUTES[]=[['GET', 'POST'],'/{locale:en-us}/user/{id:\d+}/{name}[/]','user'];

$ROUTES[]=[['GET', 'POST'],'/{locale:fr-fr}/{extension:json}/utilisateur/sauvegarde[/]','userSave'];
$ROUTES[]=[['GET', 'POST'],'/{locale:en-us}/{extension:json}/user/save[/]','userSave'];

$ROUTES[]=[['GET', 'POST'],'/{locale:fr-fr}/{extension:json}/utilisateur/selectionne[/]','userSelect'];
$ROUTES[]=[['GET', 'POST'],'/{locale:en-us}/{extension:json}/user/select[/]','userSelect'];