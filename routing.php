<?php

$ROUTES=[];

//Home
$ROUTES[]=[['GET', 'POST'],'/{locale:en-us|fr-fr}[/]','Home'];

//Test/test
$ROUTES[]=[['GET', 'POST'],'/{locale:en-us|fr-fr}/test[/]','Test\Test'];

//Messages
$ROUTES[]=[['GET', 'POST'],'/{locale:en-us|fr-fr}/message[/]','Message'];
$ROUTES[]=[['GET', 'POST'],'/{locale:en-us|fr-fr}/all-messages[/]','AllMessages'];

//Debats
// -- Liste des débats
$ROUTES[]=[['GET', 'POST'],'/{locale:fr-fr}/debats[/]','Debats'];
$ROUTES[]=[['GET', 'POST'],'/{locale:en-us}/debates[/]','Debats'];
// -- Page d'édition d'un débat
$ROUTES[]=[['GET', 'POST'],'/{locale:fr-fr}/debat/{id:\d+}/{title}[/]','Debat'];
$ROUTES[]=[['GET', 'POST'],'/{locale:en-us}/debate/{id:\d+}/{title}[/]','Debat'];
// -- sauvegarde d'un debat
$ROUTES[]=[['GET', 'POST'],'/{locale:en-us|fr-fr}/debat/save.{extension:json}','DebatSave'];
// -- Page de lecture d'un débat
$ROUTES[]=[['GET', 'POST'],'/{locale:fr-fr}/lecture-debat/{id:\d+}/{title}[/]','DebatViewer'];
$ROUTES[]=[['GET', 'POST'],'/{locale:en-us}/debateViewer/{id:\d+}/{title}[/]','DebatViewer'];


//Utilisateurs
// -- Liste des utilisateur
$ROUTES[]=[['GET', 'POST'],'/{locale:fr-fr}/utilisateurs[/]','Users'];
$ROUTES[]=[['GET', 'POST'],'/{locale:en-us}/users[/]','Users'];
// -- Page d'édition d'un utilisateur
$ROUTES[]=[['GET', 'POST'],'/{locale:fr-fr}/utilisateur/{id:\d+}/{name}[/]','User'];
$ROUTES[]=[['GET', 'POST'],'/{locale:en-us}/user/{id:\d+}/{name}[/]','User'];
// -- selection d'un utilisateur
$ROUTES[]=[['GET', 'POST'],'/{locale:en-us|fr-fr}/user/select.{extension:json}','UserSelect'];
// -- sauvegarde d'un utilisateur
$ROUTES[]=[['GET', 'POST'],'/{locale:en-us|fr-fr}/user/save.{extension:json}','UserSave'];