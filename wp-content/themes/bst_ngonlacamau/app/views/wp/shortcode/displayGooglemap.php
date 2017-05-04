
<style>
    .responsive-map{
        overflow:hidden;
        padding-bottom:56.25%;
        position:relative;
        height:0;
    }
    .responsive-map iframe{
        left:0;
        top:0;
        height:100%;
        width:100%;
        position:absolute;
    }
</style>

<div>
    <iframe src="<?= $args['src']; ?>" frameborder="0" marginwidth="0" marginheight="0" scrolling="no"
            width="<?= $args['width']; ?>" height="<?= $args['height']; ?>" allowfullscreen></iframe>
</div>

