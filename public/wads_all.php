<?php
	include dirname(dirname(__FILE__)) . '/common/pages.php';
	include dirname(dirname(__FILE__)) . '/config/config.php';
?>

<?php sn_page_header('All WADs'); ?>
	<?php sn_page_start_container(); ?>
		<script src='/assets/wadshared.js'></script>
		<h3>All WADs</h3>
		<?php display_wad_table(); ?>
		<?php sn_page_cfooter(); ?>
	<?php sn_page_end_container(); ?>
<?php sn_page_footer(); ?>
