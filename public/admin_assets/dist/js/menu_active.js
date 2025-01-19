function menu_make_active(menu){
    $('a[data-active='+menu+']').addClass("active");
    $('a[data-active='+menu+']').parent().parent().siblings( ".nav-link" ).addClass("active");
    $('a[data-active='+menu+']').parent().parent().parent().addClass('menu-open')
}
function menu_parent_active(menu){
    $('a[data-active='+menu+']').addClass("active");
    $('a[data-active='+menu+']').parent().addClass('menu-open')
}