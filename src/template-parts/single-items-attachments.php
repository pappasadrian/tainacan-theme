<?php
    if (function_exists('tainacan_get_the_attachments')) {
        $attachments = tainacan_get_the_attachments();
    } else {
        // compatibility with pre 0.11 tainacan plugin
        $attachments = array_values(
            get_children(
                array(
                    'post_parent' => $post->ID,
                    'post_type' => 'attachment',
                    'post_mime_type' => 'image',
                    'order' => 'ASC',
                    'numberposts'  => -1,
                )
            )
        );
    }
?>

<?php if ( !empty( $attachments )  || ( get_theme_mod( 'tainacan_single_item_gallery_mode', false) && tainacan_has_document() )) : ?>

    <div class="mt-3 tainacan-single-post">
    
        <h2 class="title-content-items">
            <?php 
                if (get_theme_mod( 'tainacan_single_item_gallery_mode', false )) {
                    _e( 'Documents', 'tainacan-interface' ); 
                } else {
                    _e( 'Attachments', 'tainacan-interface' ); 
                }
            ?>
        </h2>
        <section class="tainacan-content single-item-collection margin-two-column">
            <?php if (get_theme_mod( 'tainacan_single_item_gallery_mode', false )): ?>
                <div class="single-item-collection--gallery">
                    <?php if ( tainacan_has_document() ) : ?>
                        <section class="tainacan-content single-item-collection margin-two-column">
                            <div class="single-item-collection--document">
                                <?php tainacan_the_document(); ?>
                            </div>
                        </section>
                    <?php endif; ?>
                    <?php foreach ( $attachments as $attachment ) { ?>
                        <section class="tainacan-content single-item-collection margin-two-column">
                            <div class="single-item-collection--document">
                                <?php 
                                    if ( function_exists('tainacan_get_single_attachment_as_html') ) {
                                        tainacan_get_single_attachment_as_html($attachment->ID);
                                    }
                                ?>
                            </div>
                        </section>	
                    <?php } ?>
                </div>
                <?php if ( (tainacan_has_document() && $attachments && sizeof($attachments) > 0 ) || (!tainacan_has_document() && $attachments && sizeof($attachments) > 1 ) ) : ?>	
                    <div class="single-item-collection--gallery-items">
                        <?php if ( tainacan_has_document() ) : ?>
                            <div class="single-item-collection--attachments-file">
                                <?php
                                    the_post_thumbnail('tainacan-medium-full', array('class' => 'item-card--thumbnail mt-2'));
                                    echo '<br>';
                                    echo __( 'Document', 'tainacan-interface' );
                                ?>
                            </div>
                        <?php endif; ?>
                        <?php foreach ( $attachments as $attachment ) { ?>
                            <div class="single-item-collection--attachments-file">
                                <div class="<?php if (!wp_get_attachment_image( $attachment->ID, 'tainacan-interface-item-attachments')) echo'attachment-without-image'; ?>">
                                    <?php
                                        echo wp_get_attachment_image( $attachment->ID, 'tainacan-interface-item-attachments', true );
                                        echo '<br>';
                                        echo get_the_title( $attachment->ID );
                                    ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                <?php endif; ?>
            <?php else : ?>
                <div class="single-item-collection--attachments">
                    <?php foreach ( $attachments as $attachment ) { ?>
                        <?php
                        if ( function_exists('tainacan_get_attachment_html_url') ) {
                            $href = tainacan_get_attachment_html_url($attachment->ID);
                        } else {
                            $href = wp_get_attachment_url($attachment->ID, 'large');
                        }
                        ?>
                        <div class="single-item-collection--attachments-file">
                            <a 
                                class="<?php if (!wp_get_attachment_image( $attachment->ID, 'tainacan-interface-item-attachments')) echo'attachment-without-image'; ?>"
                                href="<?php echo $href; ?>"
                                data-toggle="lightbox"
                                data-gallery="example-gallery">
                                <?php
                                    echo wp_get_attachment_image( $attachment->ID, 'tainacan-interface-item-attachments', true );
                                    echo '<br>';
                                    echo get_the_title( $attachment->ID );
                                ?>
                            </a>
                        </div>
                    <?php }
                    ?>
                </div>
            <?php endif; ?>
        </section>
    </div>

    <div class="tainacan-title my-5">
        <div class="border-bottom border-silver tainacan-title-page" style="border-width: 1px !important;">
        </div>
    </div>

<?php endif; ?>