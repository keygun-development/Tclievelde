 <div class="c-footer__background">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7 col-20">
                        <h3 class="title--footer">
                            Handige links
                        </h3>
                        <?php
                            wp_nav_menu([
                                    'menu_id' => 'footer-nav-1'
                            ]);
                            ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

<?php wp_footer(); ?>
