<section role="important">
  <div class="row-fluid" id="hometop">
    <div class="span8" id="introhome">
      <h2>Associazione Italiana Supporto e Traduzione Mozilla</h2>
      <p>Siamo un'associazione senza fini di lucro che si dedica alla traduzione italiana, al supporto e alla promozione 
      dei prodotti della <a href="http://www.mozilla.org/">Mozilla Foundation</a> e derivati.</p>
      <p>In questo sito è raccolto il nostro lavoro: software, traduzioni, articoli e guide.</p>
      <p>Vi raccomandiamo di consultare i <a href="http://forum.mozillaitalia.org/">nostri forum</a>, per chiedere informazioni 
      o segnalare problemi su tutto ciò che pubblichiamo e, ovviamente, anche per offrire aiuto.</p>
    </div>
    <div class="span4">
      <div id="boxcollabora">
        <h2>Collabora con noi</h2>      
        <p>Entra a far parte della nostra comunità in modo attivo!</p>
        <p>Scopri <a href="/come-iniziare/">in che modo puoi collaborare</a> 
           oppure diventa <a href="/associazione/domanda-adesione/">socio sostenitore</a>, 
           aiutandoci a portare avanti le nostre attività di <strong>traduzione e supporto</strong>.</p>
      </div>
    </div>
  </div>
  <div class="row-fluid">
    <div class="span8">
      <?php
        $sticky = get_option('sticky_posts');
        rsort($sticky);
        $sticky = array_slice( $sticky, 0, 5);
        query_posts(array( 'post__in' => $sticky, 'caller_get_posts' => 1));
        
        $titoli = array();
        $link = array();
        $immagini = array();
        
        if (have_posts()) :
            while (have_posts()) : 
                the_post();
                $titoli[] = get_the_title();
                $sommari[] = get_the_excerpt();
                $link[] = get_permalink();
                $immagini[] = get_the_post_thumbnail($post_id, 'full', array('class' => ''));
            endwhile;
        endif;    

        $numerostickypost = count($titoli);
        if ($numerostickypost>0) {
          echo '<div id="myCarousel" class="carousel slide">
          <ol class="carousel-indicators">
          ';
          for ($i=0; $i < count($titoli); $i++) {
            if ($i==0) {
              echo '  <li data-target="#myCarousel" data-slide-to="' . $i . '" class="active"></li>
              ';  
            } else {
              echo '  <li data-target="#myCarousel" data-slide-to="' . $i . '"></li>';  
            }        
          }
          echo '
          </ol>
          <div class="carousel-inner">
          ';
          for ($i=0; $i < count($titoli); $i++) {
            if ($i==0) {
              echo '  <div class="item active">';
            } else {
              echo '<div class="item">';
            }

            echo '
              ' . $immagini[$i] . '
              <div class="carousel-caption">
                <h4>' . $titoli[$i] . '</h4>
                <p>' . $sommari[$i] . '</p>
              </div>
            </div>';
          }
          echo '                  
          </div>
          <a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
          <a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>
        </div>
        ';      
        }    
      ?>
    </div>
    <div class="span4">
      <h2>Download?</h2>
      <p>Studiare pulsanti mozilla.org per Firefox</p>
    </div>
  </div>
</section>