<?php 
  get_template_part('templates/header', 'header');
?>
<div class="row-fluid">
  <div class="span8">
    <section role="main">
      <h2>Errore 404 - Pagina non trovata</h2>
      <p class="text-center"><img src="<?php bloginfo('template_directory'); ?>/img/404.png" title="Pagina non trovata" alt="Pagina non trovata"></p>
      <p>Siamo spiacenti, la pagina che stai cercando non è disponibile su questo server.<p>
      <p>Torna alla <a href="/">pagina iniziale</a> del sito oppure vai al <a href="http://forum.mozillaitalia.org">forum di supporto</a>.</p>
    </section>
  </div>
    <?php 
    	get_template_part('templates/sidebar', 'sidebar'); 
    ?>
  </div> <!-- class="row-fluid" -->
  <?php
  	get_template_part('templates/footer', 'footer'); 
  ?>