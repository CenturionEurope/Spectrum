
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../../../favicon.ico">

    <title>{{$Cole->Page->PageMeta->Title}}</title>

    <!-- Bootstrap core CSS -->
    <link href="https://getbootstrap.com/docs/4.1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="sticky-footer.css" rel="stylesheet">
  </head>

  <body>

    <!-- Begin page content -->
    <main role="main" class="container">
      <h1 class="mt-5">{{$Cole->Page->PageMeta->Title}}</h1>
      <p class="lead">Welcome to your Cole Website! 👋</p>
      <p>You can alter this file at resources/views/Site/index.blade.php</p>
      <p>Change attributes in the Pages module or in ColeMod_Pages</p>
      <p><strong>The content below is info to help you understand what Cole sees</strong></p>
      {!!ColeDebug($Cole)!!}
    </main>
  </body>
</html>
