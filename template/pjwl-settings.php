<?php
    $pjwl_icon  = get_option('pjwl-icon');  // Button Icon
    $pjwl_text  = get_option('pjwl-text');  // Button Text
    $pjwl_pp    = get_option('pjwl-pp');    // Show or Hide The Button in Product Page
    $pjwl_cp    = get_option('pjwl-cp');    // Show or Hide The Button in Card Product
    $pjwl_popup = get_option('pjwl-popup'); // Show or Hide The Popup
    $pjwl_pst   = get_option('pjwl-pst');   // Popup Success Title
    $pjwl_psm   = get_option('pjwl-psm');   // Popup Success Message
    $pjwl_pet   = get_option('pjwl-pet');   // Popup Error Title
    $pjwl_pem   = get_option('pjwl-pem');   // Popup Error Message

    function pjwl_check_value ($check,$value) {
        if($check == $value) {
            echo "checked";
        }
    }
?>
<div class="wrap">
    <h1><?php esc_html_e('PJ WishList Settings', 'pjwl') ?></h1>
    <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
        <?php wp_nonce_field('pjwl_settings', 'wp_nonce_check') ?>
        <input type="hidden" name="action" value="pjwl_settings_process">
        <table class="form-table pjwl-settings">
            <tbody>
            <tr>
                <th scope="row">
                    <?php esc_html_e('Use The Shortcode To display The WishList Button : ', 'pjwl'); ?>
                </th>
                <td>
                    <p>[pj-wish-list-btn]</p>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <?php esc_html_e('Use The Shortcode To display The WishList Page : ', 'pjwl'); ?>
                </th>
                <td>
                    <p>[pj-wish-list]</p>
                </td>
            </tr>
            <tr>
                <th scope="row"><?php esc_html_e('Choose Icon : ', 'pjwl'); ?></th>
                <td>
                    <div class="pjwl-group pjwl-check">
                        <input type="radio" class="pjwl-heart-input" name="pjwl-icon" id="pjwl-heart"
                               value="pjwl-heart-empty" <?php pjwl_check_value($pjwl_icon, "pjwl-heart-empty"); ?>>
                        <label class="pjwl-heart-label" for="pjwl-heart">
                            <i class="pjwl-heart-empty"></i>
                        </label>
                    </div>
                    <div class="pjwl-group pjwl-check">
                        <input type="radio" class="pjwl-like-input" name="pjwl-icon" id="pjwl-thumbs-up"
                               value="pjwl-thumbs-up" <?php pjwl_check_value($pjwl_icon, "pjwl-thumbs-up"); ?>>
                        <label class="pjwl-thumbs-up-label" for="pjwl-thumbs-up">
                            <i class="pjwl-thumbs-up"></i>
                        </label>
                    </div>
                    <div class="pjwl-group pjwl-check">
                        <input type="radio" class="pjwl-star-input" name="pjwl-icon" id="pjwl-star"
                               value="pjwl-star-empty" <?php pjwl_check_value($pjwl_icon, "pjwl-star-empty"); ?>>
                        <label class="pjwl-star-label" for="pjwl-star">
                            <i class="pjwl-star-empty"></i>
                        </label>
                    </div>
                    <div class="pjwl-group pjwl-check">
                        <input type="radio" class="pjwl-dis-input" name="pjwl-icon" id="pjwl-dis"
                               value="pjwl-dis" <?php pjwl_check_value($pjwl_icon, "pjwl-dis"); ?>>
                        <label class="pjwl-dis-label" for="pjwl-dis">
                            <?php esc_html_e('Disable', 'pjwl') ?>
                        </label>
                    </div>
                </td>
            </tr>
            <tr>
                <th scope="row"><?php esc_html_e('Text on Button : ', 'pjwl'); ?></th>
                <td>
                    <div class="pjwl-group pjwl-text">
                        <input type="text" name="pjwl-text" value="<?php echo esc_attr($pjwl_text); ?>"
                               placeholder="Text on Button">
                    </div>
                </td>
            </tr>
            <?php if(class_exists('woocommerce')) : ?>
                <tr>
                    <th scope="row"><?php esc_html_e('Show Button in Product Page : ', 'pjwl'); ?></th>
                    <td>
                        <div class="pjwl-group pjwl-check">
                            <input type="radio" class="pjwl-epp-input" name="pjwl-pp" id="pjwl-btn-epp"
                                   value="0" <?php pjwl_check_value($pjwl_pp, 0); ?>>
                            <label class="pjwl-epp-label" for="pjwl-btn-epp">
                                <?php esc_html_e('Enable', 'pjwl') ?>
                            </label>
                        </div>
                        <div class="pjwl-group pjwl-check">
                            <input type="radio" class="pjwl-dpp-input" name="pjwl-pp" id="pjwl-btn-dpp"
                                   value="1" <?php pjwl_check_value($pjwl_pp, 1); ?>>
                            <label class="pjwl-dpp-label" for="pjwl-btn-dpp">
                                <?php esc_html_e('Disable', 'pjwl') ?>
                            </label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php esc_html_e('Show Button in Card Product : ', 'pjwl'); ?></th>
                    <td>
                        <div class="pjwl-group pjwl-check">
                            <input type="radio" class="pjwl-ecp-input" name="pjwl-cp" id="pjwl-btn-ecp"
                                   value="0" <?php pjwl_check_value($pjwl_cp, 0); ?>>
                            <label class="pjwl-ecp-label" for="pjwl-btn-ecp">
                                <?php esc_html_e('Enable', 'pjwl') ?>
                            </label>
                        </div>
                        <div class="pjwl-group pjwl-check">
                            <input type="radio" class="pjwl-dcp-input" name="pjwl-cp" id="pjwl-btn-dcp"
                                   value="1" <?php pjwl_check_value($pjwl_cp, 1); ?>>
                            <label class="pjwl-dcp-label" for="pjwl-btn-dcp">
                                <?php esc_html_e('Disable', 'pjwl') ?>
                            </label>
                        </div>
                    </td>
                </tr>
            <?php endif; ?>
            <tr>
                <th scope="row"><?php esc_html_e('Show Popup : ', 'pjwl'); ?></th>
                <td>
                    <div class="pjwl-group pjwl-check">
                        <input type="radio" class="pjwl-ep-input" name="pjwl-popup" id="pjwl-disable-popup"
                               value="0" <?php pjwl_check_value($pjwl_popup, 0); ?>>
                        <label class="pjwl-ep-label" for="pjwl-disable-popup">
                            <?php esc_html_e('Enable', 'pjwl') ?>
                        </label>
                    </div>
                    <div class="pjwl-group pjwl-check">
                        <input type="radio" class="pjwl-dp-input" name="pjwl-popup" id="pjwl-enable-popup"
                               value="1" <?php pjwl_check_value($pjwl_popup, 1); ?>>
                        <label class="pjwl-dp-label" for="pjwl-enable-popup">
                            <?php esc_html_e('Disable', 'pjwl') ?>
                        </label>
                    </div>
                </td>
            </tr>
            <tr>
                <th scope="row"><?php esc_html_e('Popup Success : ', 'pjwl'); ?></th>
                <td>
                    <div class="pjwl-group pjwl-text">
                        <label for="pjwl-pst">Title</label>
                        <input type="text" class="pjwl-pst" name="pjwl-pst" id="pjwl-pst"
                               value="<?php echo $pjwl_pst ?>" placeholder="Popup Success Title">
                    </div>
                    <div class="pjwl-group pjwl-text">
                        <label for="pjwl-psm">Message</label>
                        <input type="text" class="pjwl-psm" name="pjwl-psm" id="pjwl-psm"
                               value="<?php echo $pjwl_psm ?>" placeholder="Popup Success Message">
                    </div>
                </td>
            </tr>
            <tr>
                <th scope="row"><?php esc_html_e('Popup Error : ', 'pjwl'); ?></th>
                <td>
                    <div class="pjwl-group pjwl-text">
                        <label for="pjwl-pet">Title</label>
                        <input type="text" class="pjwl-pet" name="pjwl-pet" id="pjwl-pet"
                               value="<?php echo $pjwl_pst ?>" placeholder="Popup Error Title">
                    </div>
                    <div class="pjwl-group pjwl-text">
                        <label for="pjwl-pem">Message</label>
                        <input type="text" class="pjwl-pem" name="pjwl-pem" id="pjwl-pem"
                               value="<?php echo $pjwl_psm ?>" placeholder="Popup Error Message">
                    </div>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <button type="submit" class="button button-primary">
                        <?php esc_html_e('Save', 'pjwl') ?>
                    </button>
                </th>
                <td>
                </td>
            </tr>
            </tbody>
        </table>
    </form>
</div>