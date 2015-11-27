<?php
/*
    This is my example of a custom grid like layout using ACF.

    This is a more conditional 3 column layout which helps to eliminate markup, though it does slow down render time by 150ms.


    Requirements:
    Title Field
    Image Field x2:
        - One Image Field is used for the the actual image that will show, so in this case, a sponsor
        - The other Image Field is used when a client wanted to use a background image instead of just a color
    Description (Can be Text Editor or WYSIWYG)
    URL Field - can be the URL ACF or a text input
    Text Field - Used for the CSS input to style each one specifically.
    Select Field - When setup with CSS, this field is used to set a background color via CSS. Avoids using inline styling.

    This is a simple version I made for myself as I know I will be filling everything in.

*/

if ( have_rows('partner') ) :
    $x = 1;
    while ( have_rows( 'partner' ) ) : the_row();
        $name = get_sub_field('partner_name');
        $logo = get_sub_field('partner_logo');
        $text = get_sub_field('partner_text');
        $bkgd = get_sub_field('background_image');
        $color = get_sub_field('background_color');
        $link = get_sub_field('partner_link');
        if ($x == 1 ) {
            ?>
            <?php if($name || $logo || $text || $color || $bkgd ):?>
                <div class="left <?php if ( $bkgd == ""): echo $color; endif; ?>" <?php if ($bkgd):?> style="background-image: url(<?php echo $bkgd;?>);" <?php endif;?>>
                    <?php if ($link):?>
                        <a target="_blank" rel="nofollow"  href="<?php echo $link; ?>">
                            <?php if ( $logo == ""):?>
                                <h4><?php echo $name; ?></h4>
                            <?php endif; ?>
                            <div class="img-container"><img src="<?php echo $logo; ?>" /></div>
                            <div class="text-container">
                                <h4>
                                    <?php
                                    if ($logo != "" ):
                                        echo $name;
                                    endif;
                                    ?>
                                </h4>
                                <p><?php echo $text; ?></p>
                            </div>
                        </a>
                    <?php else :?>


                        <?php if ( $logo == ""):?>
                            <h4><?php echo $name; ?></h4>
                        <?php endif; ?>
                        <div class="img-container"><img src="<?php echo $logo; ?>" /></div>
                        <div class="text-container">
                            <h4>
                                <?php
                                if ($logo != "" ):
                                    echo $name;
                                endif;
                                ?>
                            </h4>
                            <p><?php echo $text; ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <?php
        }
        elseif ($x == 2 ){

            ?>
            <?php if($name || $logo || $text || $bkgd || $color || $bkgd ):?>
                <div class="center <?php if ( $bkgd == ""): echo $color; endif; ?>" <?php if ($bkgd):?> style="background-image: url(<?php echo $bkgd;?>);" <?php endif;?>>
                    <?php if ($link):?>
                        <a target="_blank" rel="nofollow"  href="<?php echo $link; ?>">
                            <?php if ( $logo == ""):?>
                                <h4><?php echo $name; ?></h4>
                            <?php endif; ?>
                            <div class="img-container"><img src="<?php echo $logo; ?>" /></div>
                            <div class="text-container">
                                <h4>
                                    <?php
                                    if ($logo != "" ):
                                        echo $name;
                                    endif;
                                    ?>
                                </h4>
                                <p><?php echo $text; ?></p>
                            </div>
                        </a>
                    <?php else :?>


                        <?php if ( $logo == ""):?>
                            <h4><?php echo $name; ?></h4>
                        <?php endif; ?>
                        <div class="img-container"><img src="<?php echo $logo; ?>" /></div>
                        <div class="text-container">
                            <h4>
                                <?php
                                if ($logo != "" ):
                                    echo $name;
                                endif;
                                ?>
                            </h4>
                            <p><?php echo $text; ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <?php
        }

        elseif ($x == 3 ) {
            ?>
            <?php if($name || $logo || $text || $bkgd || $color || $bkgd ):?>
                <div class="right <?php if ( $bkgd == ""): echo $color; endif; ?>" <?php if ($bkgd):?> style="background-image: url(<?php echo $bkgd;?>);" <?php endif;?>>
                    <?php if ($link):?>
                        <a target="_blank" rel="nofollow"  href="<?php echo $link; ?>">
                            <?php if ( $logo == ""):?>
                                <h4><?php echo $name; ?></h4>
                            <?php endif; ?>
                            <div class="img-container"><img src="<?php echo $logo; ?>" /></div>
                            <div class="text-container">
                                <h4>
                                    <?php
                                    if ($logo != "" ):
                                        echo $name;
                                    endif;
                                    ?>
                                </h4>
                                <p><?php echo $text; ?></p>
                            </div>
                        </a>
                    <?php else :?>


                        <?php if ( $logo == ""):?>
                            <h4><?php echo $name; ?></h4>
                        <?php endif; ?>
                        <div class="img-container"><img src="<?php echo $logo; ?>" /></div>
                        <div class="text-container">
                            <h4>
                                <?php
                                if ($logo != "" ):
                                    echo $name;
                                endif;
                                ?>
                            </h4>
                            <p><?php echo $text; ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <?php
            $x = 0;
        }
        $x++;
    endwhile;

else :
    // no rows found
    ?>
    <p>Enter a sponsor</p>
    <?php
endif;

?>