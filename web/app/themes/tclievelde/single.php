<?php

get_header();
?>
<div class="bg-blue">
    <div class="container section">
        <h1>
            <?php echo get_the_title(); ?>
        </h1>
        <p>
            <?php echo get_the_content(); ?>
        </p>
    </div>
</div>
<?php
    get_footer();
?>
