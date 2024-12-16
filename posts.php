<?php 
// This script will print any page NOT in category 'News' except if it's a single post



foreach ($content as $page): 
	$scrollClass="";
		if ($WHERE_AM_I == "home") {$scrollClass="js-scroll";}
	//echo '<br>'.$page->category().'<br>'.$page->type().'<br>';
	// rules:
	// if page is of type 'published' display as 3 column layout otherwise display single columm
	
	if ($page->type() == "published" && $page->category() != "News") {   
        if ($page->category() != "What's On") { ?>
	<article>
		<h3 class="<? php echo $scrollClass; ?> slide-left"><a href="<?php echo $page->permalink(); ?>"><?php echo $page->title() ?></a></h3>
		<div class="article-col">
		<div class="firstcol">
			<a href="<?php echo $page->permalink() ?>" class="image"><img class="<?php echo $scrollClass; ?> slide-right articlecoverimage firstcol" src="<?php echo $page->coverImage() ?>" alt="" /></a>
			</div>
			<div class="middlecol pagetext <? php echo $scrollClass; ?> fade-in">
			<?php echo $page->contentBreak() ?>

			<!-- Read more button -->
			<?php if($page->readMore()): ?>
			<ul class="actions">
				<li><a href="<?php echo $page->permalink() ?>" class="button"><?php $language->p('More') ?></a></li>
			</ul>
			
			<?php endif; ?>
			</div>
			
			<div class="articleinfo lastcol">
					<ul class="articleinfotext">
						<li><?php echo $page->date(); ?></li>
						<li><?php echo $page->username(); ?></li>
					</ul>
					<div class="articletags">
						<ul class="articletaglist">
						<?php 
							$returnsArray = true;
							$items = $page->tags($returnsArray);
							foreach ($items as $tagKey=>$tagName) {
								$tag = new Tag($tagKey);
								echo '<li class="articletag"><a href="'.$tag->permalink().'">'.$tag->name().'</a></li>';
							}
						?>
						</ul>
					</div>
			</div>
		</div>
	</article>
	<?php } ?>
	<?php if ($page->category() != "What's On") { ?>
	<article>
		<h3 class="<? php echo $scrollClass; ?> slide-left"><a href="<?php echo $page->permalink(); ?>"><?php echo $page->title() ?></a></h3>
		<div class="article">
			
			<a href="<?php echo $page->permalink() ?>" class="image"><img class="<?php echo $scrollClass; ?> slide-right coverimage" src="<?php echo $page->coverImage() ?>" alt="" /></a>
			
			<div class="singlepagetext <? php echo $scrollClass; ?> fade-in">
			<?php echo $page->contentBreak() ?>

			<!-- Read more button -->
			<?php if($page->readMore()) {?>
			<ul class="actions">
				<li><a href="<?php echo $page->permalink() ?>" class="button"><?php $language->p('More') ?></a></li>
			</ul>
			
			<?php } ?>
			</div>
			
			<div class="articleinfo">
					<ul class="articleinfotext">
						<li><?php echo $page->date().' by '.$page->username(); ?></li>
					</ul>
					<div class="articletags">
						<ul class="articletaglist">
						<?php 
							$returnsArray = true;
							$items = $page->tags($returnsArray);
							foreach ($items as $tagKey=>$tagName) {
								$tag = new Tag($tagKey);
								echo '<li class="articletag"><a href="'.$tag->permalink().'">'.$tag->name().'</a></li>';
							}
						?>
						</ul>
					</div>
			</div>
		</div>
	</article>
	
	<?php }  }?>
<?php endforeach ?>