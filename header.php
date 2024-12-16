<?php

?>
<div class="navclose" id="navclose">
	<div id="navclosebtn">close&nbsp;<i class="fa-solid fa-xmark"></i></div>
</div>
<header class="mainheader">


<div class="siteheader" id="siteheader">
	<div class="container">
	<a href="/web">	<img class="sitelogo" style="view-transition-name:logotransZ;" src="<?php echo $site->logo() ?>" alt="LFF Logo"> </a>
	<div class="headerlinkbox">
		<ul class="headerlinks">
			<li class="headerlink" id="navopenbtn"><i class="fa-solid fa-bars"></i></li>
		</ul>
	</div>
	</div>
</div>
	
<div class="navigation" id="navarea">
	<div class="navcontainer" id="navcon">
		<div class="navcatcontainer">
			<ul class="">
				<li class="navitem"><a href="/web">Home</a></li>
			</ul>
		</div>
<?php
    $items = getCategories();
	$order = array("About","Useful Info","What's On", "Services","News");
	usort($items, function ($a, $b) use ($order) {
    $pos_a = array_search($a->name(), $order);
    $pos_b = array_search($b->name(), $order);
    return $pos_a - $pos_b;
});
    foreach ($items as $category) {
	if ($category->name() == "Venues") { continue; }  ?>
		<div class="navcatcontainer">
		
		<?php
		
        // Each category is an Category-Object

        // The method $category->pages() returns all the pages keys releated to the category
        if (count($category->pages())>0) { 
			
			echo '<div class="navcattitle">';
			echo $category->name().'</div>';
			echo '<ul class="navcategory">';
			foreach ($category->pages() as $pageKey) {
				$page = new Page($pageKey);
				if ( $page->category() == "Venues") { continue; }
				echo '<li class="navitem"><a href="';
				echo $page->permalink();
				echo '">';
				echo $page->title().'</a></li>';
			}
		echo '</ul>'; 
		} ?>

		</div>
    <?php } ?>
	<div class="navcatcontainer">
		<div class="navcattitle">Our Social Media</div>
			<ul class="navcategory">
			<?php 
			 $socialNetworks = array(
                    // Key => Label
                    'facebook'=>'Facebook',
                    'instagram'=>'Instagram',
                    'discord'=>'Discord',
					'bluesky'=>'Bluesky',
					'mixcloud'=>'Mixcloud'
                );
			foreach ($socialNetworks as $key=>$label): ?>
                    <?php if ($site->{$key}()): ?>
                        <li class="navitem"><a href="<?php echo $site->{$key}() ?>"><i class="fa-brands fa-<?php echo $key ?>"></i>&nbsp<?php echo $label ?><i class="fortyfivedeg fa-solid fa-arrow-up"></i></a></li>
                    <?php endif; ?>
                <?php endforeach; ?>
			</ul>
		</div>
	</div>
</div>

</header>

