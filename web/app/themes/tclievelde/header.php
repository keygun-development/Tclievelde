<?php
    use Tclievelde\Theme\TemplateParts\Nav\NavigationDesktop;
    use Tclievelde\Theme\TemplateParts\Nav\NavigationMobile;
    use Tclievelde\Theme\TemplateParts\Nav\SearchBar\ShortSearchBar;
    use Tclievelde\Tclievelde;

    $loggedin = false;
if (isset($_COOKIE['user'])) {
    $loggedin = true;
} else {
    if (get_page_uri() == 'reserveren') {
        header('location: /inloggen');
    }
}

    $shortHeader = true;
?>
<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <title><?php wp_title(''); ?></title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php
    do_action('mst_above_wp_head');
    ?>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <div class="wrapper">
        <div class="container-fluid px-0 header__margin-bottom">
            <header class="header header--hero d-flex justify-content-center align-items-center">
                <a href="/" class="mr-5">
                    <img class="c-header__hero-img" src="https://tclievelde.dev/app/uploads/2021/11/Nieuw-project-6.png" />
                </a>
                <?php
                NavigationDesktop::of()->show();
                NavigationMobile::of()->show();
                ?>
                <?php
                if ($loggedin) {
                    echo '<a class="c-button__primary" href="/uitloggen">Uitloggen</a>';
                } else {
                    echo '<a class="c-button__primary" href="/inloggen">Inloggen</a>';
                }
                ?>
            </header>
        </div>
<script defer type="text/javascript">
    let url = document.getElementsByClassName('header__nav-item');
    for(let i=0;i<url.length;i++) {
        if(window.location.href.split('/')[3] === url[i].href.split('/')[3]) {
            url[i].classList.add('active');
        }
    }
</script>