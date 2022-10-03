<!DOCTYPE html>
<html lang="vi">
<?php $ver = 1; ?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php if (isset($robot) && $robot == 1) : ?>
        <meta name="robots" content="index,follow" />
    <?php else : ?>
        <meta name="robots" content="noindex,nofollow" />
    <?php endif; ?>
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
        <meta property="og:image:secure_url" content="<?php $ogImage ?> " />
    <?php }; ?>
    <meta property="og:image" content="https://vieclamtheogio.vieclam123.vn/images/n_kham_pha.png" />

    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="@vieclam123">
    <meta name="twitter:description" content="<?= (isset($description)) ? $description : "" ?>" />
    <meta name="twitter:title" content="<?= (isset($title)) ? $title : '' ?>" />
    <link href="/images/favicon-vieclam123.png" rel="shortcut icon" type="image/x-icon" />
    <link rel="canonical" href="<?= (isset($canonical)) ? $canonical : "" ?>" />
    <link rel="stylesheet" href="/css/select2.min.css">
    <link rel="stylesheet" href="/css/slick-theme.css">
    <link rel="stylesheet" href="/css/slick.css">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/includes/header.css?v=<?= $ver ?>">
    <link rel="stylesheet" href="/css/includes/log_out.css?v=<?= $ver ?>">
    <link rel="stylesheet" href="/css/includes/footer.css?v=<?= $ver ?>">
    <?php if (isset($css)) : for ($i = 0; $i < count($css); $i++) : ?>
            <link rel="stylesheet" href="/css/<?= (isset($css[$i])) ? $css[$i] : "" ?>.css?v=<?= $ver ?>">
    <?php endfor;
    endif; ?>

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
    <script type="text/javascript" src="/js/jquery.min.js"></script>
    <script type="text/javascript" src="/js/jquery.validate.min.js"></script>
    <script type="text/javascript" src="/js/slick.min.js"></script>
    <script type="text/javascript" src="/js/select2.min.js"></script>
    <script type="text/javascript" src="/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/js/includes/header.js?v=<?= $ver ?>"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/27.1.0/classic/ckeditor.js"></script>
    <?php if (isset($js)) : for ($i = 0; $i < count($js); $i++) : ?>
            <script type="text/javascript" src="/js/<?= (isset($js[$i])) ? $js[$i] : "" ?>.js?v=<?= $ver ?>"></script>
    <?php endfor;
    endif; ?>


</body>

</html>