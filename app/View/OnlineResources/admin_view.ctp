<div class="services view">
<?php
pr($newestRevision);
pr($previousRevision);
?>
</div>

<div class="services view">
<h2><?php  echo __('Online Service'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($online_service['OnlineService']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($online_service['OnlineService']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Url'); ?></dt>
		<dd>
			<?php echo h($online_service['OnlineService']['url']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($online_service['OnlineService']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($online_service['OnlineService']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($online_service['OnlineService']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Deleted'); ?></dt>
		<dd>
			<?php echo h($online_service['OnlineService']['deleted']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
