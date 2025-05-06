<?php
/*
 * This is BasePress template to show the list of Knowledge Bases
 * It is called from the shortcode
 */


//Get the Knowledge Base objects
$bpkb_knowledge_bases = basepress_kbs();

?>
<div class="bpress-wrap">
	<div class="bpress-grid">
	<?php foreach ( $bpkb_knowledge_bases as $bpkb_knowledge_base ) : ?>
		<div class="bpress-col bpress-col-<?php basepress_kb_cols(); ?>">
			<div class="bpress-card bpress-product bpress-kb fix-height">
				<a class="bpress-product-link bpress-kb-link" href="<?php echo esc_url( $bpkb_knowledge_base->permalink ) ; ?>">
					<img class="bpress-card-top-image" src="<?php echo esc_url( $bpkb_knowledge_base->image->url ) ; ?>">
					<h3 class="bpress-card-title"><?php echo esc_html( $bpkb_knowledge_base->name ); ?></h3>
					<span class="bpress-card-footer"><?php echo esc_html( basepress_choose_kb_btn_text() ) ; ?></span>
				</a>
			</div>
		</div>
	<?php endforeach; ?>
	</div>
</div>
