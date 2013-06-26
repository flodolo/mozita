<article <?php post_class(); ?>>
  <header class="entry-header">
    <div class="date">
      <span class="month"><?php the_time('M'); ?></span> 
      <span class="day"><?php the_time('d'); ?></span>
      <span class="year"><?php the_time('Y'); ?></span>
    </div>
    <h1 class="entry-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="Link a <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>    
  </header>
  <div class="entry-content">
    <?php the_content(); ?>
  </div>
  <footer>
    <p>
      <i class="icon icon-tags"></i><?php the_tags('Etichette: ', ', ', ''); ?>&nbsp;
      <i class="icon icon-user"></i>Scritto da <?php the_author(); ?>           
    </p>    
  </footer>
</article>