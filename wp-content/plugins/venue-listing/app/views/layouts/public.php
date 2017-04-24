<?php get_header(); ?>

<div class="page">

    <h2>layout cua tui ne</h2>

	<div id="single-body" class="post-body">


		
		<div id="documentation_container">
		
			<?php $this->render_main_view(); ?>
		
		</div>
		
		<div style="clear:both"></div>
	
	</div>

	<?php if (mvc_setting('DocumentationSettings', 'show_version_list')): ?>
		<?php $this->render_view('documentation_nodes/_version_list', array('locals' => array('current_version' => $current_version, 'versions' => $versions))); ?>
	<?php endif; ?>

</div>

<?php get_footer(); ?>