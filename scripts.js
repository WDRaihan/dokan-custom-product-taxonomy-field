jQuery(document).ready(function(){
    
    //jQuery('#old_cat').parent().css('display', 'none');
    
    jQuery('.dcdc-sub-categories').parent().prepend('<span class="cata-expand"></span>');
    
    jQuery('.cata-expand').addClass('cata-expand-plus');
    
    jQuery('.cata-expand').on('click', function(){
        
        jQuery( this ).parent('li').find('.dcdc-sub-categories:first').slideToggle();
        
        jQuery( this ).toggleClass('cata-expand-minus cata-expand-plus');
    });
});


jQuery(document).on('click', '.dokan-add-new-product', function(){
    
    //jQuery('#old_cat').parent().css('display', 'none');
    
    jQuery('.dcdc-sub-categories').parent().prepend('<span class="cata-expand"></span>');
    
    jQuery('.cata-expand').addClass('cata-expand-plus');
    
    jQuery('.cata-expand').on('click', function(){
        
        jQuery( this ).parent('li').find('.dcdc-sub-categories:first').slideToggle();
        
        jQuery( this ).toggleClass('cata-expand-minus cata-expand-plus');
    });
});
