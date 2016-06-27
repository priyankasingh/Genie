<div class="content-box <?php if( !empty( $favourites ) ) echo 'favourites '; ?>">
	<div id="category-description">
	
            <?php
            if( !empty( $parent_category )) echo $parent_category['Category']['description'];
           // echo $parent_category['Category']['id'];
            ?>
	</div>
    
       <!--
        <? php
        echo $this->element('category_filter',
                array(
                        'sub_category_list' => isset($sub_category_list)?$sub_category_list:null,
                        'categories' => isset($categories)?$categories:null,
                        'selected_parent_id' => isset($selected_parent_id)?$selected_parent_id:null,
                        'selected_parent_slug' => isset($selected_parent_slug)?$selected_parent_slug:null,
                )
        );
        ?>  -->

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
    	
    <?php echo $this->element('results_pager', array(
                    'paginator' => $this->Paginator,
    ));?>
    <div id="parent-id"><? // php echo $selected_parent_id;?></div>
</div>


	<h2><?php echo __('Online Resources'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('url'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
	</tr>
	<?php foreach ($onlineResource as $on): ?>
	
            <?php foreach ($on['OnlineResource'] as $online_resource): ?>
        <tr>
            
		<td><?php echo h($online_resource['id']); ?>&nbsp;</td>
		<td><?php echo h($online_resource['name']); ?>&nbsp;</td>
		<td><?php echo h($online_resource['url']); ?>&nbsp;</td>
		<td><?php echo h($online_resource['created']); ?>&nbsp;</td>
		<td><?php echo h($online_resource['modified']); ?>&nbsp;</td>
	</tr>
            <?php endforeach; ?>
        <?php endforeach; ?>
	</table>

