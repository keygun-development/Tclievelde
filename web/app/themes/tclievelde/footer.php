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
                    <div class="col-lg-6 col-20 mx-lg-4">
                        <h3 class="title--footer">
                            Geheimhouding
                        </h3>
                        <p class="text-white">
                            Deze website is gemaakt voor tao te lichtenvoorde. Het is een beveiligde website zodat niet iedereen bij deze gegevens kan. Het is dus ook niet de bedoeling om inloggegevens te lekken of data te lekken.
                        </p>
                    </div>
                    <div class="col-lg-6 col-20">
                        <h3 class="title--footer">
                            Suggesties
                        </h3>
                        <form method="post">
                            <p class="required text-white m-0">
                                Email:
                            </p>
                            <input type="email" name="email" required />
                            <p class="text-white mt-2 mb-0">
                                Suggesties hier:
                            </p>
                            <textarea class="col-20" name="textarea"></textarea>
                            <input class="c-button__primary" type="submit" name="submit" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

<?php wp_footer(); ?>
