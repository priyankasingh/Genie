<div class="content-box <?php if( !empty( $favourites ) ) echo 'favourites '; ?>">
	<div id="category-description">
		<div id="parent-helper" <?php if(isset($active_nav) && $active_nav == 'my_plans') echo "class='serviceParent'"; ?>></div>
		<?php
		//if(isset($active_nav) && $active_nav == 'my_plans') echo "<h2>HOLLA</h2>";
		?>
	<?php
	if( !empty( $parent_category )) echo $parent_category['Category']['description'];
	echo $parent_category['Category']['id'];
        ?>
	</div>
        <?php
		echo $this->element('category_filter',
			array(
				'sub_category_list' => isset($sub_category_list)?$sub_category_list:null,
				'categories' => isset($categories)?$categories:null,
				'selected_parent_id' => isset($selected_parent_id)?$selected_parent_id:null,
				'selected_parent_slug' => isset($selected_parent_slug)?$selected_parent_slug:null,
			)
		);
	?>

<div class="aside">
    <a class="print" href="#"><?php echo __('Print Your results'); ?></a>
    <div class="link-holder">
        <a class="results" href="#"><?php echo __('My Results'); ?></a>
        <a class="favourites" href="#"><?php echo __('My Favourites'); ?></a>
    </div>

        <?php echo $this->element('results_box', array(
                                'parents' => isset($parents)?$parents:null,
                                'categories' => isset($categories)?$categories:null,
                                'paginator' => isset($this->Paginator)?$this->Paginator:null,
                                'service' => isset($service)?$service:null,
        ));?>
    <?php echo $this->element('results_box', array(
                            'parents' => isset($parents)?$parents:null,
                            'categories' => isset($categories)?$categories:null,
                            'paginator' => isset($this->Paginator)?$this->Paginator:null,
                            'category' => isset($category)?$category:null,
                            'service' => isset($service)?$service:null,
    ));?>	
    <?php echo $this->element('results_pager', array(
                    'paginator' => $this->Paginator,
    ));?>
    <div id="parent-id"><?php echo $selected_parent_id;?></div>
</div>

<h2><?php echo __('Online Resources'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	
	<?php foreach ($onlineResources as $online_resource): ?>

		<td><?php echo h($online_resource['OnlineResource']['id']); ?>&nbsp;</td>
		<td><?php echo h($online_resource['OnlineResource']['name']); ?>&nbsp;</td>
		<td><?php echo h($online_resource['OnlineResource']['url']); ?>&nbsp;</td>
		<td><?php echo h($online_resource['OnlineResource']['created']); ?>&nbsp;</td>
		<td><?php echo h($online_resource['OnlineResource']['modified']); ?>&nbsp;</td>
                
<?php endforeach; ?>
	</table>