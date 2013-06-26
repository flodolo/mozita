<?php 
  get_template_part('templates/header', 'header');
?>
<div class="row-fluid">
  <div class="span8">
    <section role="main">
      <?php
        if (have_posts()) {
          while (have_posts()) : 
            the_post();
            get_template_part('templates/article', 'article');        
          endwhile; 
      ?>
          <nav id="navposts">            
            <?php if (get_next_posts_link()<>'') { ?>
            <span class="alignleft"><?php next_posts_link('&laquo; Articoli precedenti') ?></span>
            <?php }; ?>
            <?php if (get_previous_posts_link()<>'') { ?>
            <span class="alignright"><?php previous_posts_link('Articoli successivi &raquo;') ?></span>
            <?php }; ?>
          </nav>
      <?php
        } else {
      ?>
          <header class="entry-header">
            <h1 class="entry-title">Nessun post disponibile</h1>
          </header>
      <?php
        }
      ?>
    </section>
  </div>
    <?php 
    	get_template_part('templates/sidebar', 'sidebar'); 
    ?>
  </div> <!-- class="row-fluid" -->
  <?php
  	get_template_part('templates/footer', 'footer'); 
  ?>