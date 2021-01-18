<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.9.1/css/bulma.min.css">
  <link rel="stylesheet" href="../../public/style.css">
  <script src="../../public/dnd.js"></script>
  <script src="../../public/addItem.js" defer></script>
  <title><?= $title ?></title>
</head>
<body>
  <?php require("nav.php"); ?>
  <?= $content ?>
</body>
</html>