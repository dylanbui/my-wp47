<p style="text-align: <?= $args['align']; ?>;">
    <iframe id="youtube-<?= absint($args['counter']); ?>" type="text/html"
            src="<?= $args['src']; ?>" style="border:0; height:<?= esc_attr(absint($args['height'] )); ?>px; width:<?= esc_attr(absint($args['width'] )); ?>px">

    </iframe>
</p>

