<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="robots" content="noindex,nofollow" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Vieclam123.vn" />

    <title><?= (isset($title)) ? $title : '' ?></title>
    <meta name="keywords" content="<?= (isset($keyword)) ? $keyword : "" ?>" />
    <meta name="description" content="<?= (isset($description)) ? $description : "" ?>" />

    <meta property="og:url" content="<?= (isset($canonical)) ? $canonical : "" ?>">
    <meta property="og:title" content="<?= (isset($title)) ? $title : '' ?>" />
    <meta property="og:description" content="<?= (isset($description)) ? $description : "" ?>" />
    <meta property="og:type" content="website" />
    <meta property="og:locale" content="vi_VN" />
    <?php
    if (isset($ogImage)) {
    ?>
        <meta property="og:image:secure_url" content="<?= $ogImage ?> " />
        <meta property="og:image" content="<?= $ogImage ?> " />
    <?php } ?>

    <meta name="twitter:card" content="summary" />
    <meta name="twitter:description" content="<?= (isset($description)) ? $description : "" ?>" />
    <meta name="twitter:title" content="<?= (isset($title)) ? $title : '' ?>" />


    <link rel="canonical" href="<?= (isset($canonical)) ? $canonical : "" ?>" />
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/select2.min.css">
    <link rel="stylesheet" href="/css/font-awesome.min.css">
    <? for($i=0 ; $i < count($css) ; $i++): ?>
    <link rel="stylesheet" href="/css/<?= (isset($css[$i])) ? $css[$i] : "" ?>.css">
    <?php endfor; ?>

</head>

<body>
    <?php
        //$this->load->view("includes/header.php");
    ?>
    <?php
    if (isset($content)) {
        $this->load->view($content);
    }
    //$this->load->view("includes/v_footer");
    ?>
    <script type="text/javascript" src="/js/jquery.min.js"></script> 
    <script type="text/javascript" src="/js/select2.min.js"></script>
    <script type="text/javascript" src="/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/js/select2.js"></script>
    <? for($i=0 ; $i < count($js) ; $i++): ?>
    <link rel="stylesheet" href="/js/<?= (isset($js[$i])) ? $js[$i] : "" ?>.js">
    <?php endfor; ?>
</body>

</html>