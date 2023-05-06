<html>
    <head>
    <?php require('head.php'); ?>
    </head>

<body>

    <?php 
    if (isset($_SESSION['user'])) {
        require('navbar.php');
    }    
    ?>

    <main>
   
        {{content}}

    </main>

    <?php require('footer.php'); ?>
</body>
</html>

