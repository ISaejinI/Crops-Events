<?php
    $event_register_actions = new \CropsEvents\RenderDatas();

    the_post();
?>

<!-- wp:template-part {"slug":"header","theme":"crops","area":"header"} /-->

<!-- wp:group {"style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"var:preset|spacing|xl","bottom":"var:preset|spacing|xl"}}},"layout":{"type":"constrained","wideSize":"1400px"}} -->
<div class="wp-block-group" style="margin-top:0;margin-bottom:0;padding-top:var(--wp--preset--spacing--xl);padding-bottom:var(--wp--preset--spacing--xl)"><!-- wp:group {"align":"wide","style":{"spacing":{"padding":{"top":"var:preset|spacing|l","bottom":"var:preset|spacing|l","left":"var:preset|spacing|l","right":"var:preset|spacing|l"}},"border":{"width":"0px","style":"none","radius":{"topLeft":"16px","topRight":"16px","bottomLeft":"16px","bottomRight":"16px"}}},"backgroundColor":"primary","layout":{"type":"default"}} -->
<div class="wp-block-group alignwide has-primary-background-color has-background" style="border-style:none;border-width:0px;border-top-left-radius:16px;border-top-right-radius:16px;border-bottom-left-radius:16px;border-bottom-right-radius:16px;padding-top:var(--wp--preset--spacing--l);padding-right:var(--wp--preset--spacing--l);padding-bottom:var(--wp--preset--spacing--l);padding-left:var(--wp--preset--spacing--l)"><!-- wp:columns {"style":{"spacing":{"blockGap":{"left":"var:preset|spacing|l"}}}} -->
<div class="wp-block-columns"><!-- wp:column {"width":"33.33%"} -->
<div class="wp-block-column" style="flex-basis:33.33%"><!-- wp:post-featured-image {"aspectRatio":"9/16"} /--></div>
<!-- /wp:column -->

<!-- wp:column {"width":"66.66%"} -->
<div class="wp-block-column" style="flex-basis:66.66%"><!-- wp:post-title {"level":1,"style":{"elements":{"link":{"color":{"text":"var:preset|color|black"}}}},"textColor":"black"} /-->

<!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group"><!-- wp:paragraph -->
<p>Du</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"core/post-meta","args":{"key":"event_global_informations_event_begin_date"}}}}} -->
<p></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>Au</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"core/post-meta","args":{"key":"event_global_informations_event_end_date"}}}}} -->
<p></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group"><!-- wp:html -->
<span class="dashicons dashicons-location"></span>
<!-- /wp:html -->

<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"core/post-meta","args":{"key":"event_global_informations_event_location"}}}}} -->
<p></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:separator -->
<hr class="wp-block-separator has-alpha-channel-opacity"/>
<!-- /wp:separator -->

<!-- wp:heading {"style":{"elements":{"link":{"color":{"text":"var:preset|color|black"}}}},"textColor":"black"} -->
<h2 class="wp-block-heading has-black-color has-text-color has-link-color">Description</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"core/post-meta","args":{"key":"event_global_informations_event_description"}}}}} -->
<p></p>
<!-- /wp:paragraph -->

<!-- wp:separator -->
<hr class="wp-block-separator has-alpha-channel-opacity"/>
<!-- /wp:separator -->

<!-- wp:heading {"style":{"elements":{"link":{"color":{"text":"var:preset|color|black"}}}},"textColor":"black"} -->
<h2 class="wp-block-heading has-black-color has-text-color has-link-color">Inscription</h2>
<!-- /wp:heading -->

<!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group"><!-- wp:paragraph -->
<p>Date limite des inscriptions</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"core/post-meta","args":{"key":"event_register_informations_event_register_limit_date"}}}}} -->
<p></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:paragraph  -->
<p><?php echo $event_register_actions->renderRemainingSeats(get_the_ID()); ?></p>
<!-- /wp:paragraph -->

<!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group"><!-- wp:paragraph -->
<p>Prix :</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"core/post-meta","args":{"key":"event_register_informations_event_price"}}}}} -->
<p></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>€</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button">Je participe !</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:template-part {"slug":"footer","theme":"crops","area":"footer"} /-->