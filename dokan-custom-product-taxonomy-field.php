<?php
/*
* Plugin name: Dokan Category Dropdown to Checkbox
*/

add_action( 'wp_enqueue_scripts', 'dcdc_scripts' );
function dcdc_scripts() {
    wp_enqueue_style( 'dcdc-style', plugin_dir_url( __FILE__ ) . 'styles.css' );
    wp_enqueue_script( 'dcdc-script', plugin_dir_url( __FILE__ ) . 'scripts.js', array('jquery'), null, true );
}

add_action( 'dokan_product_edit_after_pricing', 'dokan_cat_dropdown_to_checkbox' );
add_action( 'dokan_new_product_after_product_tags', 'dokan_cat_dropdown_to_checkbox_new' );

add_action( 'dokan_new_product_added', 'wd_save_new_cata' );
add_action( 'dokan_product_updated', 'wd_save_new_cata' );


//Add new product
function dokan_cat_dropdown_to_checkbox_new() {
    //global $product;
    ?>
    <div class="dokan-form-group">
      <label for="" class="control-label"><?php echo esc_html('Select categories'); ?></label>
        <?php 
        $taxonomies = get_terms( array(
            'taxonomy' => 'city_cat',
            'hide_empty' => false,
            'parent'     => '0',
        ) );

        if ( !empty($taxonomies) ) :

            //$termsids = $product->get_category_ids();
            ?>
            <ul class="first-label-categories product-cat-steps">
            <?php
            foreach( $taxonomies as $category ) {

                // the id of the top-level-term, we need this further down
                $top_term_id = $category->term_id;
                // the name of the top-level-term
                $top_term_name = $category->name;
                // the current used taxonomy
                $top_term_tax = $category->taxonomy;

                $term_children = get_term_children($category->term_id, 'city_cat');
                ?>
          <li>
            <input type="checkbox" name="city_cat[]" id="fpde-category-<?php echo esc_attr( $category->term_id ) ?>" class="fpde-catageory" value="<?php echo esc_attr( $category->term_id ) ?>"> <label for="fpde-category-<?php echo esc_attr( $category->term_id ) ?>"><?php echo esc_html( $category->name ); ?></label>

            <?php
            $second_level_terms = get_terms( array(
            'taxonomy' => $top_term_tax,
            'child_of' => $top_term_id,
            'parent' => $top_term_id, 
            'hide_empty' => false,
            ) );

            // start a second list element if we have second level terms
            if ($second_level_terms) {
                ?>
                <ul class="second-level-terms product-cat-steps dcdc-sub-categories">
                <?php

                foreach ($second_level_terms as $second_level_term) {

                    //Making third label category
                    $sec_term_id = $second_level_term->term_id;
                    $sec_term_name = $second_level_term->name;
                    $sec_term_tax = $second_level_term->taxonomy;
                    ?>
                    <li>
                    <input type="checkbox" id="fpde-category-<?php echo esc_attr( $second_level_term->term_id ) ?>" name="city_cat[]" class="fpde-catageory fpde-child" value="<?php echo esc_html( $second_level_term->term_id ) ?>"> <label for="fpde-category-<?php echo esc_attr( $second_level_term->term_id ) ?>"><?php echo esc_html( $second_level_term->name ); ?></label>
                    
                    <?php
                    /*
                    * third label
                    */
                    $third_level_terms = get_terms( array(
                        'taxonomy' => $sec_term_tax,
                        'child_of' => $sec_term_id,
                        'parent' => $sec_term_id, 
                        'hide_empty' => false,
                    ) );
                    
                if ($third_level_terms) {
                ?>
                <ul class="third-level-terms product-cat-steps dcdc-sub-categories">
                <?php
                foreach ($third_level_terms as $third_level_term) {

                    //Child category label 4
                    $third_term_id = $third_level_term->term_id;
                    $third_term_name = $third_level_term->name;
                    $third_term_tax = $third_level_term->taxonomy;
                    ?>
                    <li>
                    
                    <input type="checkbox" id="fpde-category-<?php echo esc_attr( $third_level_term->term_id ) ?>" name="city_cat[]" class="fpde-catageory fpde-child" value="<?php echo esc_html( $third_level_term->term_id ) ?>"> <label for="fpde-category-<?php echo esc_attr( $third_level_term->term_id ) ?>"><?php echo esc_html( $third_level_term->name ); ?></label>
                    
                    <?php
                    /*
                    * Four label
                    */
                    $four_level_terms = get_terms( array(
                        'taxonomy' => $third_term_tax,
                        'child_of' => $third_term_id,
                        'parent' => $third_term_id, 
                        'hide_empty' => false,
                    ) );
                    
                    if ($four_level_terms) {
                    ?>
                    <ul class="four-level-terms product-cat-steps dcdc-sub-categories">
                    <?php
                    foreach ($four_level_terms as $four_level_term) {
                    ?>
                    <li>
                        <input type="checkbox" id="fpde-category-<?php echo esc_attr( $four_level_term->term_id ) ?>" name="city_cat[]" class="fpde-catageory fpde-child" value="<?php echo esc_html( $four_level_term->term_id ) ?>"> <label for="fpde-category-<?php echo esc_attr( $four_level_term->term_id ) ?>"><?php echo esc_html( $four_level_term->name ); ?></label>
                    </li>
                    <?php
                    }
                    ?>
                    </ul>
                    <?php

                    }// END if 
                    ?>
                    </li>
                    <?php

                    }// END foreach
                    ?>
                    </ul>
                    <?php

                    }// END if 
                    
                    ?>
                    
                    </li>
                    <?php

                }// END foreach
                ?>
                </ul>
              <?php

            }// END if   

            ?>
          </li>
          <?php
            }
    ?>
            </ul>
            <?php
        endif;

        ?>
    </div>
    <?php
}

//Update product
function dokan_cat_dropdown_to_checkbox() {
    
    $product = wc_get_product( get_the_id() );
    ?>
    <div class="dokan-form-group">
      <label class="control-label"><?php echo esc_html('Select categories'); ?></label>
        <?php 
        $taxonomies = get_terms( array(
            'taxonomy' => 'city_cat',
            'hide_empty' => false,
            'parent'     => '0',
        ) );

        if ( !empty($taxonomies) ) :
    
            $termsids = [];
            $terms = get_the_terms(get_the_id(), 'city_cat');
            foreach ($terms as $term) {
                $termsids[] = $term->term_id;
            }
            //$termsids = $product->get_category_ids();
            ?>
            <ul class="first-label-categories product-cat-steps">
            <?php
            foreach( $taxonomies as $category ) {

                // the id of the top-level-term, we need this further down
                $top_term_id = $category->term_id;
                // the name of the top-level-term
                $top_term_name = $category->name;
                // the current used taxonomy
                $top_term_tax = $category->taxonomy;

                $term_children = get_term_children($category->term_id, 'city_cat');
                ?>
          <li>
            <input type="checkbox" name="city_cat[]" id="fpde-category-<?php echo esc_attr( $category->term_id ) ?>" class="fpde-catageory" value="<?php echo esc_attr( $category->term_id ) ?>" <?php if( in_array($category->term_id, $termsids) ){ echo 'checked'; } ?>> <label for="fpde-category-<?php echo esc_attr( $category->term_id ) ?>"><?php echo esc_html( $category->name ); ?></label>

            <?php
            $second_level_terms = get_terms( array(
            'taxonomy' => $top_term_tax,
            'child_of' => $top_term_id,
            'parent' => $top_term_id, 
            'hide_empty' => false,
            ) );

            // start a second list element if we have second level terms
            if ($second_level_terms) {
                ?>
                <ul class="second-level-terms product-cat-steps dcdc-sub-categories">
                <?php

                foreach ($second_level_terms as $second_level_term) {

                    //Making third label category
                    $sec_term_id = $second_level_term->term_id;
                    $sec_term_name = $second_level_term->name;
                    $sec_term_tax = $second_level_term->taxonomy;
                    ?>
                    <li>
                    <input type="checkbox" id="fpde-category-<?php echo esc_attr( $second_level_term->term_id ) ?>" name="city_cat[]" class="fpde-catageory fpde-child" value="<?php echo esc_html( $second_level_term->term_id ) ?>" <?php if( in_array($second_level_term->term_id, $termsids) ){ echo 'checked'; } ?>> <label for="fpde-category-<?php echo esc_attr( $second_level_term->term_id ) ?>"><?php echo esc_html( $second_level_term->name ); ?></label>
                    
                    <?php
                    /*
                    * third label
                    */
                    $third_level_terms = get_terms( array(
                        'taxonomy' => $sec_term_tax,
                        'child_of' => $sec_term_id,
                        'parent' => $sec_term_id, 
                        'hide_empty' => false,
                    ) );
                    
                if ($third_level_terms) {
                ?>
                <ul class="second-level-terms product-cat-steps dcdc-sub-categories">
                <?php

                foreach ($third_level_terms as $third_level_term) {

                    //Child category label 4
                    $third_term_id = $third_level_term->term_id;
                    $third_term_name = $third_level_term->name;
                    $third_term_tax = $third_level_term->taxonomy;
                    ?>
                    <li>
                    
                    <input type="checkbox" id="fpde-category-<?php echo esc_attr( $third_level_term->term_id ) ?>" name="city_cat[]" class="fpde-catageory fpde-child" value="<?php echo esc_html( $third_level_term->term_id ) ?>" <?php if( in_array($third_level_term->term_id, $termsids) ){ echo 'checked'; } ?>> <label for="fpde-category-<?php echo esc_attr( $third_level_term->term_id ) ?>"><?php echo esc_html( $third_level_term->name ); ?></label>
                    
                    <?php
                    /*
                    * Four label
                    */
                    $four_level_terms = get_terms( array(
                        'taxonomy' => $third_term_tax,
                        'child_of' => $third_term_id,
                        'parent' => $third_term_id, 
                        'hide_empty' => false,
                    ) );
                    
                    if ($four_level_terms) {
                    ?>
                    <ul class="four-level-terms product-cat-steps dcdc-sub-categories">
                    <?php
                    foreach ($four_level_terms as $four_level_term) {
                    ?>
                    <li>
                        <input type="checkbox" id="fpde-category-<?php echo esc_attr( $four_level_term->term_id ) ?>" name="city_cat[]" class="fpde-catageory fpde-child" value="<?php echo esc_html( $four_level_term->term_id ) ?>" <?php if( in_array($four_level_term->term_id, $termsids) ){ echo 'checked'; } ?>> <label for="fpde-category-<?php echo esc_attr( $four_level_term->term_id ) ?>"><?php echo esc_html( $four_level_term->name ); ?></label>
                    </li>
                    <?php
                    }
                    ?>
                    </ul>
                    <?php

                    }// END if 
                    ?>
                    
                    </li>
                    <?php

                    }// END foreach
                    ?>
                    </ul>
                    <?php

                }// END if 
                    
                    ?>
                    
                    </li>
                    <?php

                }// END foreach
                ?>
                </ul>
              <?php

            }// END if   

            ?>
          </li>
          <?php
            }
    ?>
            </ul>
            <?php
        endif;

        ?>
    </div>
    <?php
}

function wd_save_new_cata($product_id, $postdata){
    if ( isset( $_POST['city_cat'] ) && ! empty( $_POST['city_cat'] ) ) {
        $cat_ids = array_map( 'absint', (array) $_POST['city_cat'] );
        wp_set_object_terms( $product_id, $cat_ids, 'city_cat' );
    }
}
