<li class="c-card">
	<div class="c-card__simple-container">
		<article class="c-card u-text-center">
            <?php if ($image_url) {?>
			<figure class="c-card__figure">
				<img class="c-card__image o-avatar" src="<?php echo esc_attr($image_url);?>">
			</figure>
            <?php } ?>
			<div class="c-card__body">
				<h3 class="c-card__heading"><?php echo esc_html($attributes['heading']);?></h3>
				<p class="c-card__subheading"><?php echo esc_html($attributes['subheading']);?></p>
			</div>
		</article>
	</div>
</li>