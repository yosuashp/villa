<?php
header("Content-Type:text/css");
$color = "#f0f"; // Change your Color Here
$secondColor = "#ff8"; // Change your Color Here

function checkhexcolor($color){
    return preg_match('/^#[a-f0-9]{6}$/i', $color);
}

if (isset($_GET['color']) AND $_GET['color'] != '') {
    $color = "#" . $_GET['color'];
}

if (!$color OR !checkhexcolor($color)) {
    $color = "#336699";
}


function checkhexcolor2($secondColor){
    return preg_match('/^#[a-f0-9]{6}$/i', $secondColor);
}

if (isset($_GET['secondColor']) AND $_GET['secondColor'] != '') {
    $secondColor = "#" . $_GET['secondColor'];
}

if (!$secondColor OR !checkhexcolor2($secondColor)) {
    $secondColor = "#336699";
}
?>

.btn--base, .testimonial-slider .slick-arrow, .best-trip-card__badge, .property-slider .slick-dots li.slick-active button, .preloader .preloader-container .animated-preloader, .preloader .preloader-container .animated-preloader:before, .btn--base:hover, .select2-container--default .select2-results__option--highlighted[aria-selected], .bg--base, .location-slider .slick-arrow:hover, .best-trip-slider .slick-arrow:hover, .d-widget:hover .d-widget__icon, .user-menu li.active a, .user-menu li.active:hover a, .social-media-list li a:hover, .hotel-card__offer-badge, .reserve-widget .top .hotel-details-offer-badge, .pagination .page-item.active .page-link, .pagination .page-item .page-link:hover, .blog-post__date, .list--primary .list__item::before, .btn-outline--base:hover, .sidebar-toggler-icon, .custom--table thead, .switch-button .switch-button__checkbox:checked + .switch-button__label, .switch-button .switch-button__label:before, .back-to-top, .hotel-nav__btn.active {
    background-color: <?php echo $color; ?> !important;
}

.location-card .location-badge i, .testimonial-item .content::before, .d-widget__icon, .user-info-list li i, .user-menu li:hover a, .footer-menu-list li a:hover, .footer-contact-list > li .content a:hover, .social-media-list li a:hover, .contact-card__header .icon i, .contact-card a:hover, .text--base, .header .main-menu li a:hover, .header .main-menu li a:focus, .location-card .location-badge i, .testimonial-item .content::before, .d-widget__icon, .user-info-list li i, .user-menu li:hover a, .footer-menu-list li a:hover, .footer-contact-list > li .content a:hover, .social-media-list li a:hover, .contact-card__header .icon i, .contact-card a:hover, .custom--checkbox input:checked ~ label::before, a:hover, .features-list li::before, .btn-outline--base, .cookies-card.cookies--dark .cookies-card__icon, .blog-post__link, .blog-post__meta-icon, .hotel-details-box .aminities-list li::before, .amenity__icon{
    color: <?php echo $color; ?> !important;
}

.testimonial-item::after, .pagination .page-item .page-link:hover, .form--control:focus, .btn-outline--base, .newsletter{
    border-color: <?php echo $color; ?> !important;
}

.user-menu li:hover a, .d-widget__icon{
    background-color: <?php echo $color; ?>26;
}

.form--control:focus{
    box-shadow: 0 0 5px <?php echo $color; ?>59;
}

.pagination .page-item .page-link{
    border: 1px solid<?php echo $color; ?>40 !important;
}

.pre_loader{
    border-top: 15px solid<?php echo $color; ?> !important;
}