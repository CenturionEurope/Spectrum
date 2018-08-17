<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Cole is a CMS Developed by Peter Day that allows quick and pain free management of your website.">
        <meta name="author" content="Peter Day">
		<meta name="csrf-token" content="{!! csrf_token() !!}"/> 
        <link rel="shortcut icon" href="/Cole/Brand/Cole.png" />
        <title>Cole</title>
        <link href="/Cole/Javascript/Plugins/RichText/ui/trumbowyg.min.css" rel="stylesheet" media="screen">
        @isset($Cole->PageReference)
            @if($Cole->PageReference=='install')
                <link href="/Cole/Javascript/Plugins/Slick/slick.css" rel="stylesheet" media="screen">
            @endif
        @endisset
        <link href="/Cole/Engines/LESS/MakeLESS.php" rel="stylesheet" media="screen">        
    </head>
    <style>
        .content-page[data-module=today],
        .content-page[data-module=500]{
            background-image: url('{!! $Cole->Unsplash->Url or '' !!}');
        }
    </style>
    <body class="fixed-left Loading @isset($Cole->User->NightMode) @if($Cole->User->NightMode==1) NightMode @endif @endif" data-pagereference="{{ $Cole->PageReference or '' }}">
    
    <!-- Begin page -->
    <div class="LoadingElement"></div>
    <div id="wrapper">
