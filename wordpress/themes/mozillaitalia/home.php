<?php 
  get_template_part('templates/header', 'header');
  // I want the carousel+collaborate box only on the first page
  if (!is_paged()) get_template_part('templates/hometop', 'home'); 
?>
<div class="row-fluid">
  <div class="span8">
    <section role="main">
      <?php
        // Exclude sticky posts
        $paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
        $sticky = get_option( 'sticky_posts' );
        $args = array(
          'ignore_sticky_posts' => 1,
          'post__not_in' => $sticky,
          'paged' => $paged
        );
        query_posts( $args );
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