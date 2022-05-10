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
    <script src="https://kit.fontawesome.com/819c0dbdc7.js" crossorigin="anonymous"></script>

    <?php
    do_action('mst_above_wp_head');
    ?>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <div class="wrapper">
        <div class="container-fluid px-0 header__margin-bottom">
            <header class="header header--hero d-flex justify-content-lg-center justify-content-between align-items-center">
                <a href="/">
                    <img class="c-header__hero-img" src="https://tclievelde.dev/app/uploads/2021/11/Nieuw-project-6.png" />
                </a>
                <div class="d-lg-flex d-none c-header__menu">
                    <?php
                    wp_nav_menu(['menu' => 'header_menu']);
                    ?>
                </div>
                <div class="header__hamburger d-block d-lg-none" onclick="toggleHamburger()">
                    <div class="one"></div>
                    <div class="two"></div>
                    <div class="three"></div>
                </div>
                <?php
                if ($loggedin) {
                    echo '<a class="c-button__primary d-none d-lg-block" href="/uitloggen">Uitloggen</a>';
                } else {
                    echo '<a class="c-button__primary d-none d-lg-block" href="/inloggen">Inloggen</a>';
                }
                ?>
            </header>
            <?php NavigationMobile::of()->show(); ?>
        </div>
<script defer type="text/javascript">
    let item = document.getElementsByClassName('menu-item');
    for(let i=0;i<item.length;i++) {
        if(window.location.href.split('/')[3] === item[i].querySelector('a').href.split('/')[3]) {
            item[i].classList.add('active');
        }
    }
</script>