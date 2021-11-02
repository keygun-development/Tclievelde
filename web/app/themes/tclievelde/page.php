<div class="bg-blue">
    <div class="container section">
        <div class="row justify-content-between">
            <div class="col-10">
                <h1>
                    <?php echo get_the_title(); ?>
                </h1>
                <p>
                    <?php echo get_field('tekst'); ?>
                </p>
            </div>
            <div class="col-6 ml-4">
                <?php if (!empty(get_field('afbeelding'))) { ?>
                    <img src="<?php echo get_field('afbeelding')['url']; ?>" />
                <?php } ?>
            </div>
        </div>
    </div>
</div>