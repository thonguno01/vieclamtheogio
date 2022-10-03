<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php if (isset($robot) && $robot == 1) { ?>
        <meta name="robots" content="index,follow" />
    <?php } else { ?>
        <meta name="robots" content="noindex,nofollow" />
    <?php } ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Vieclam123.vn" />

    <title><?=  (isset($title)) ? $title : '' ?></title>
    <meta name="keywords" content="<?= (isset($keyword)) ? $keyword : "" ?>" />
    <meta name="description" content="<?= (isset($description)) ? $description : "" ?>" />

    <!-- <meta property="og:url" content="<?= (isset($canonical)) ? $canonical : "" ?>">
    <meta property="og:title" content="<?= (isset($title)) ? $title : '' ?>" />
    <meta property="og:description" content="<?= (isset($description)) ? $description : "" ?>" />
    <meta property="og:type" content="website" />
    <meta property="og:locale" content="vi_VN" />
    <?php
    if (isset($ogImage)) {
    ?>
        <meta property="og:image:secure_url" content="<?php $ogImage ?> " />
        <meta property="og:image" content="<?php $ogImage ?> " />
    <?php }; ?> -->

    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="@vieclam123">
    <meta name="twitter:description" content="<?= (isset($description)) ? $description : "" ?>" />
    <meta name="twitter:title" content="<?= (isset($title)) ? $title : '' ?>" />
    <link href="/images/favicon-vieclam123.png" rel="shortcut icon" type="image/x-icon" />
    <link rel="canonical" href="<?= (isset($canonical)) ? $canonical : "" ?>" />
    <link rel="stylesheet" href="<?= base_url(); ?>css/select2.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>css/chung/header.css">
    <link rel="stylesheet" href="<?= base_url(); ?>css/chung/footer.css">
    
</head>

<body>
    <?php
     $this->load->view("includes/header.php");
    ?>
    <?php
    if (isset($content)) {
        $this->load->view($content);
    }
    ?>
    <?php
    $this->load->view("includes/footer");
    ?>
    <script type="text/javascript" src="<?= base_url(); ?>js/jquery.min.js"></script>
    <script type="text/javascript" src="<?= base_url();?>js/jquery.validate.min.js"></script>
    <script type="text/javascript" src="<?= base_url(); ?>js/select2.min.js"></script>
    <script type="text/javascript" src="<?= base_url(); ?>js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?= base_url(); ?>js/chung/header.js"></script>
   
  
</body>

</html>