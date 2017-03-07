<?php
/**
 * File used for homepage hero content module
 *
 * @package alphabootstrap
 */
?>


<div class="jumbotron">
    <div class="row">
        <div class="col-lg-6">
            <?php if(alphabootstrap_option('featured_heading') != '') { ?>
                <h1> <?php echo alphabootstrap_option('featured_heading'); ?> </h1>
            <?php } ?>

            <?php if(alphabootstrap_option('featured_content') != '') { ?>
                <p><?php echo alphabootstrap_option('featured_content'); ?> </p>
            <?php } ?>

            <?php
            $btn_text = alphabootstrap_option('featured_btn_text', '');
            $btn_size = 'btn-'.alphabootstrap_option('featured_btn_size', '');
            $btn_color = 'btn-'.alphabootstrap_option('featured_btn_color', '');
            $btn_url = alphabootstrap_option('featured_btn_url', '');

            if (alphabootstrap_option('featured_btn_block') == '1' ){
                $btn_block = "btn-block";
            }

            ?>

            <?php if (alphabootstrap_option('featured_btn') == '1' ){	?>
                <p><a href="<?php echo $btn_url; ?>" target="_self" class="btn <?php echo $btn_color .' '. $btn_size .' '. $btn_block; ?>" role="button"><?php echo $btn_text; ?></a></p>
            <?php } ?>

        </div>
        <div class="col-lg-6">
            <?php if(alphabootstrap_option('right_featured') != '') {
                echo alphabootstrap_option('right_featured');
            } ?>
        </div>
    </div>
</div>