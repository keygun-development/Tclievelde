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
                    <div class="col-lg-13 col-20">
                        <h3 class="title--footer">
                            Adressen
                        </h3>
                        <div class="col-20 d-flex justify-content-between">
                            <p>
                                Adres tennispark: Tennispark De Bonkelaer Lievelderweg 120 A 7137NB Lievelde
                            </p>
                            <p class="mx-4">
                                Secretariaat eigenaar tennispark: Stichting De Bonkelaer P/a De Wijn 6 7137MG Lievelde
                            </p>
                            <p>
                                Secretariaat gebruiker tennispark: Tennisclub Lievelde P/a Martin Rots Lauwersdijk 12 7137ME Lievelde
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

<?php wp_footer(); ?>
