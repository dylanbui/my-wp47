<h2>Venues 12312312312</h2>
<h2><?php echo $object->__name; ?> sadadasd</h2>

<?php foreach ($objects as $object): ?>

    <?php $this->render_view('_item', array('locals' => array('object' => $object))); ?>

<?php endforeach; ?>

<?php echo $this->pagination(); ?>