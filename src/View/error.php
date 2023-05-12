
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/mvc/public/assets/css/bootstrap.min.css" rel="stylesheet" />
<script src="/mvc/public/assets/js/bootstrap.bundle.min.js" defer=""></script>
    <title><?php echo $exception->getCode();?></title>
</head>
<body>
<div class="container my-5">
    <div class="row justify-content-center">
      <div class="col-md-6 text-center">
        <h1 class="display-1 text-danger"><i class="fas fa-exclamation-triangle"></i></h1>
        <h2>Oops! <?php echo $exception->getCode()." " ?><?php echo $exception->getMessage(); ?>.</h2>
        <p class="lead">We're sorry, but resource you are trying to access is not available</p>
        <a href="/mvc/login" class="btn btn-primary mt-3"><i class="fas fa-home"></i> Go to Login</a>
      </div>
    </div>
  </div>
</body>
</html>