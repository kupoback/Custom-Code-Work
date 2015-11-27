<?php
/*
    This is my example of a custom grid like layout using ACF.
    Requirements: 
    Title Field
    Image Field
    Description (Can be Text Editor or WYSIWYG)
    URL Field - can be the URL ACF or a text input
    Text Field - Used for the CSS input to style each one specificially.

    This is a simple version I made for myself as I know I will be filling everything in.

*/
if ( have_rows('website_repeater') ) :
    $x = 1;
    while ( have_rows('website_repeater') ) : the_row();
        $name = get_sub_field('title');
        $image = get_sub_field('image');
        $text = get_sub_field('text');
        $css = get_sub_field('css');
        $link = get_sub_field('link');
        if ($x == 1 ) {
            if ( $name || $image || $text || $css || $link ) :
                ?>
                <div class="<?php echo $css; ?>">
                    <a target="_blank" rel="nofollow" href="<?php echo $link; ?>">
                        <div class="img-container"><img src="<?php echo $image; ?>" alt="<?php echo $name; ?>"></div>
                        <div class="text-container">
                            <h4><?php echo $name; ?></h4>
                            <?php echo $text; ?>
                        </div>
                    </a>
                </div>
                <?php
            endif;
        }
        elseif ($x == 2){
            if ( $name || $image || $text || $css || $link ) :
                ?>
                <div class="<?php echo $css; ?>">
                    <a target="_blank" rel="nofollow" href="<?php echo $link; ?>">
                        <div class="img-container"><img src="<?php echo $image; ?>" alt="<?php echo $name; ?>"></div>
                        <div class="text-container">
                            <h4><?php echo $name; ?></h4>
                            <?php echo $text; ?>
                        </div>
                    </a>
                </div>
                <?php
            endif;
        }
        elseif ($x == 3){
            if ( $name || $image || $text || $css || $link ) :
                ?>
                <div class="<?php echo $css; ?>">
                    <a target="_blank" rel="nofollow" href="<?php echo $link; ?>">
                        <div class="img-container"><img src="<?php echo $image; ?>" alt="<?php echo $name; ?>"></div>
                        <div class="text-container">
                            <h4><?php echo $name; ?></h4>
                            <?php echo $text; ?>
                        </div>
                    </a>
                </div>
                <?php
            endif;
            $x = 1;
        }
        $x++;
    endwhile;

else :
    // no rows found
    ?>
    <p>Enter a website</p>
    <?php
endif;
?>