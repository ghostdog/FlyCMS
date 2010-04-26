<p class="pagination">

	<?php if ($first_page !== FALSE): ?>
		<a href="<?php echo $page->url($first_page) ?>"><?php echo 'First' ?></a>
	<?php else: ?>
		<?php echo 'First' ?>
	<?php endif ?>

	<?php if ($previous_page !== FALSE): ?>
		<a href="<?php echo $page->url($previous_page) ?>"><?php echo 'Previous' ?></a>
	<?php else: ?>
		<?php echo 'Previous' ?>
	<?php endif ?>

	<?php for ($i = 1; $i <= $total_pages; $i++): ?>

		<?php if ($i == $current_page): ?>
			<strong>[<?php echo $i ?>]</strong>
		<?php else: ?>
			<a href="<?php echo $page->url($i) ?>"><?php echo $i ?></a>
		<?php endif ?>

	<?php endfor ?>

	<?php if ($next_page !== FALSE): ?>
		<a href="<?php echo $page->url($next_page) ?>"><?php echo 'Next' ?></a>
	<?php else: ?>
		<?php echo 'Next' ?>
	<?php endif ?>

	<?php if ($last_page !== FALSE): ?>
		<a href="<?php echo $page->url($last_page) ?>"><?php echo 'Last' ?></a>
	<?php else: ?>
		<?php echo 'Last' ?>
	<?php endif ?>

</p><!-- .pagination -->