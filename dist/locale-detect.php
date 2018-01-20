<?php

use Gettext\Translator;
use Gettext\Translations;
use Site\Service\Config;
use Site\Service\Session;



$locale=Session::get("current-locale");
$textdomain=Config::get("textdomain");


//gestion multilangue
$localeFilePO='../src/locales/LC_MESSAGES/'.$locale.'/'.$textdomain.'.po';
$localeFilePOPublic='../dist/locales/LC_MESSAGES/'.$locale.'/'.$textdomain.'.po';
$localeFilePhp='../dist/locales/LC_MESSAGES/'.$locale.'/'.$textdomain.'.php';
$localeFileMo='../dist/locales/LC_MESSAGES/'.$locale.'/'.$textdomain.'.mo';

$bPhpFileIsUpToDate=false;
if(file_exists($localeFilePhp)){
    if(filemtime($localeFilePO)<filemtime($localeFilePhp)){
        $bPhpFileIsUpToDate=true;
    }
}else{
    if(!is_dir('../dist/locales/LC_MESSAGES/'.$locale.'/')){
        mkdir('../dist/locales/LC_MESSAGES/'.$locale.'/',0777,true);
    }
}
if( !$bPhpFileIsUpToDate ){
    $translations = Translations::fromPoFile($localeFilePO);
    $translations->toPhpArrayFile($localeFilePhp);
    $translations->toMoFile($localeFileMo);
    copy($localeFilePO,$localeFilePOPublic);
}
$t = new Translator();

//Load your translations (exported as PhpArray):
$t->loadTranslations($localeFilePhp);

$t->register();