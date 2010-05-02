<p class="pagination">
        <?php
            $first_disabled = html::image('media/img/first_disabled.png');
            $first_enabled = html::image('media/img/first_enabled.png');
            $last_disabled = html::image('media/img/last_disabled.png');
            $last_enabled = html::image('media/img/last_enabled.png');
            $next_enabled = html::image('media/img/next_enabled.png');
            $next_disabled = html::image('media/img/next_disabled.png');
            $prev_disabled = html::image('media/img/prev_disabled.png');
            $prev_enabled = html::image('media/img/prev_enabled.png');
        ?>
	<?php if ($first_page !== FALSE): ?>
		<a title="Pierwsza" href="<?php echo $page->url($first_page) ?>"><?php echo $first_enabled ?></a>
	<?php else: ?>
		<?php echo $first_disabled ?>
	<?php endif ?>

	<?php if ($previous_page !== FALSE): ?>
		<a title="Poprzednia" href="<?php echo $page->url($previous_page) ?>"><?php echo $prev_enabled ?></a>
	<?php else: ?>
		<?php echo $prev_disabled ?>
	<?php endif ?>

	<?php for ($i = 1; $i <= $total_pages; $i++): ?>

		<?php if ($i == $current_page): ?>
			<strong>[<?php echo $i ?>]</strong>
		<?php else: ?>
			<a href="<?php echo $page->url($i) ?>"><?php echo $i ?></a>
		<?php endif ?>

	<?php endfor ?>

	<?php if ($next_page !== FALSE): ?>
		<a title="Następna" href="<?php echo $page->url($next_page) ?>"><?php echo $next_enabled ?></a>
	<?php else: ?>
		<?php echo $next_disabled ?>
	<?php endif ?>

	<?php if ($last_page !== FALSE): ?>
		<a title="Ostatnia" href="<?php echo $page->url($last_page) ?>"><?php echo $last_enabled ?></a>
	<?php else: ?>
		<?php echo $last_disabled ?>
	<?php endif; ?>

</p><!-- .pagination -->