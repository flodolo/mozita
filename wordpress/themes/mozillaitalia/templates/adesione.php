<?php
  // View -> visualizza il form
  // Insert -> ha compilato il form, invio email
  $status = !empty($_REQUEST['status']) ? $_REQUEST['status'] : 'view';
  $nome = !empty($_POST['nome']) ? strip_tags(stripslashes($_POST['nome'])) : '';
  $cognome = !empty($_POST['cognome']) ? strip_tags(stripslashes($_POST['cognome'])) : '';
  $email1 = !empty($_POST['email1']) ? strip_tags(stripslashes($_POST['email1'])) : '';
  $email2 = !empty($_POST['email2']) ? strip_tags(stripslashes($_POST['email2'])) : '';
  $azienda = !empty($_POST['azienda']) ? strip_tags(stripslashes($_POST['azienda'])) : '';
  $indirizzo = !empty($_POST['indirizzo']) ? strip_tags(stripslashes($_POST['indirizzo'])) : '';
  $cap = !empty($_POST['cap']) ? strip_tags(stripslashes($_POST['cap'])) : '';
  $citta = !empty($_POST['citta']) ? strip_tags(stripslashes($_POST['citta'])) : '';
  $provincia = !empty($_POST['provincia']) ? strip_tags(stripslashes($_POST['provincia'])) : '';
  $livello = !empty($_POST['livello']) ? strip_tags(stripslashes($_POST['livello'])) : '0';
  $privacy = !empty($_POST['privacy']) ? strip_tags(stripslashes($_POST['privacy'])) : '0';
  $pubblicazione = !empty($_POST['pubblicazione']) ? strip_tags(stripslashes($_POST['pubblicazione'])) : '1';

  $errori = '';
  if ($status == 'send' || $status == 'confirm') {
    if ($nome == '') $errori .= "<li>Specificare il nome</li>\n";
    if ($cognome == '') $errori .= "<li>Specificare il cognome</li>\n";
    if ($email1 == '' || $email2 == '' ) $errori .= "<li>Specificare il proprio indirizzo email</li>\n";
    if ($email1 != $email2) $errori .= "<li>Le mail inserite non corrispondono</li>\n";
    if ($privacy == '0') $errori .= "<li>È necessario accettare l'informativa sulla privacy</li>\n";
  }

  // Dati per il calcolo delle quote
  // Dal 31/08 quota al 50%, dal 15/11 la quota vale per l'anno successivo
  $adesso = time();
  $anno = date("Y", $adesso);
  $limitesconto = mktime(23, 59, 59, 8, 31, $anno);
  $limiteanno = mktime(23, 59, 59, 11, 15, $anno);

  $quotelivelli = array('Godzilla', 'Sauro', 'Gecko', 'Lucertola', 'Girino');

  $quotestandard = array(80,80,40,20,10);
  $quotestandardtxt = array('contributo maggiore di 80 €','80 €','40 €','20 €','10 €');
  $quotescontate = array(40,40,20,10,5);
  $quotescontatetxt = array('contributo maggiore di <strike>80 €</strike> <strong>40 €</strong>','<strike>80 €</strike> <strong>40 €</strong>',
                            '<strike>40 €</strike> <strong>20 €</strong>','<strike>20 €</strike> <strong>10 €</strong>','<strike>10 €</strike> <strong>5 €</strong>');
  $quotaassociativa = 5;

  $quote = $quotestandard;
  $quotetxt = $quotestandardtxt;
  $annotxt = $anno;

  if ($adesso > $limitesconto && $adesso <= $limiteanno) {
     $quote = $quotescontate;
     $quotetxt = $quotescontatetxt;
  } elseif ($adesso > $limiteanno) {
     $annotxt = '<strike>' . $anno . '</strike> ';
     $anno = $anno+1;
     $annotxt .= '<strong>' . $anno . '</strong>';
  }

  $totalequota = $quotaassociativa + $quote[$livello];

  $codice_livelli = '';
  for ($i=0; $i<count($quotelivelli); $i++) {

    $codice_livelli .= '
    <label class="radio">
      <input type="radio" name="livello" id="livello" value="' . $i . '" ';

    if ($livello == $i) { $codice_livelli .= 'checked'; }

    $codice_livelli .= '>
      <strong>' . $quotelivelli[$i] . '</strong>: ' .
      $quotaassociativa . ' € (quota associativa) + ' .  $quotetxt[$i] . ' (quota annuale) per l\'anno ' . $annotxt . '
    </label>';
  }


?>

<article <?php post_class(); ?>>
  <div class="entry-content">
    <h2>Domanda di adesione</h2>
    <p>Per diventare socio sostenitore dell’Associazione Italiana Supporto e Traduzione Mozilla</p>
    <?php
    if ($errori != '') {
        echo '<div class="alert alert-error">
                <p>Si sono verificati degli errori:</p>
                    <ul>
                    ' . $errori . '
                    </ul>
                   </div>';
        $status = 'view';
      }

    if ($status == 'view') { ?>
      <form id="frmadesione" class="form-horizontal" method="post" action="">
        <input type="hidden" name="status" id="status" value="confirm" />
        <fieldset>
          <legend>Dati obbligatori</legend>
          <div class="control-group">
            <label class="control-label" for="nome">Nominativo</label>
            <div class="controls form-inline">
              <input type="text" class="input-large" name="nome" id="nome" required="required" value="<?php echo $nome; ?>" placeholder="Nome"/>
              <input type="text" class="input-large" name="cognome" id="cognome" required="required" value="<?php echo $cognome; ?>" placeholder="Cognome"/>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="email1">Email</label>
            <div class="controls">
              <input type="email" class="input-xxlarge" name="email1" required="required" id="email1" value="<?php echo $email1; ?>" placeholder="La tua email"/>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="email2">Conferma email</label>
            <div class="controls">
              <input type="email" class="input-xxlarge" name="email2" required="required" id="email2" value="<?php echo $email2; ?>" placeholder="Conferma la tua email"/>
            </div>
          </div>
        </fieldset>

        <fieldset>
          <legend>Dati facoltativi</legend>
          <div class="control-group">
            <label class="control-label" for="azienda">Ragione sociale</label>
            <div class="controls">
              <input type="text" class="input-xxlarge" name="azienda" id="azienda" value="<?php echo $azienda; ?>" placeholder="Ragione sociale (per le aziende)"/>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="indirizzo">Indirizzo</label>
            <div class="controls">
              <input type="text" class="input-xxlarge" name="indirizzo" id="indirizzo" value="<?php echo $indirizzo; ?>" placeholder="Indirizzo completo di numero civico" />
            </div>
          </div>
          <div class="control-group">
            <label class="control-label">Località</label>
            <div class="controls form-inline">
              <input type="text" class="span2" maxlength="5" name="cap" id="cap" value="<?php echo $cap; ?>" placeholder="CAP" />
              <input type="text" class="span8" name="citta" id="citta" value="<?php echo $citta; ?>" placeholder="Città" />
              <input type="text" class="span2" maxlength="4" name="provincia" id="provincia" value="<?php echo $provincia; ?>" placeholder="Provincia" />
            </div>
          </div>
        </fieldset>

        <fieldset>
          <legend>Associazione</legend>
          <div class="control-group">
            <?php echo $codice_livelli; ?>
          </div>
          <p>Con l’invio della richiesta di adesione l’aspirante Socio Sostenitore dichiara di riconoscersi nelle
            <a href="/associazione/statuto/">finalità e nei principi dell’Associazione</a> e di aver letto e approvato
            il <a href="/associazione/regolamento-per-ladesione/">regolamento di adesione</a>.</p>
          <p>Dà inoltre approvazione esplicita ai seguenti punti:</p>
          <?php
            $statoprivacy = ($privacy==1) ? 'checked' : '';
            $statopubblicazione = ($pubblicazione==1) ? 'checked' : '';
          ?>
          <label class="checkbox">
            <input type="checkbox" id="privacy" name="privacy" value="1" <?php echo $statoprivacy; ?>>
            Dichiara di aver letto e approvato l’<a href="/associazione/informativa-sulla-privacy/">informativa sul trattamento dei dati personali</a> dell’associazione.
          </label>
          <label class="checkbox">
            <input type="checkbox" id="pubblicazione" name="pubblicazione" value="1" <?php echo $statopubblicazione; ?>>
            Permette l’inserimento del proprio nominativo nell’elenco pubblico dei soci sostenitori dell’associazione (facoltativo).
          </label>
        </fieldset>

        <div class="control-group">
          <div class="controls">
            <button class="btn btn-large btn-primary" type="submit">Invia richiesta di adesione</button>
          </div>
        </div>
      </form>
    <?php
    }

    if ($status == 'confirm') {
      // Visualizzo il modulo per conferma
      var_dump($_POST);

      $output = "
      <p><strong>$nome $cognome". (!empty($azienda) ? " - $azienda" : "") ."</strong> ($email1) " .
      (!empty($indirizzo) && !empty($citta) ? ", residente in $indirizzo, $cap $citta ($provincia)," : '') .
      " richiede di aderire all'Associazione Italiana Supporto e Traduzione Mozilla come socio sostenitore.</p> " .
      "<p>Fascia di associazione: <strong>" . $quotelivelli[$livello] . "</strong></p>
      <p><strong>Quota da versare</strong>: $totalequota € ($quotaassociativa € quota associativa + $quotetxt[$i] quota annuale per l'anno $annotxt)</p>
      <p>Dichiara inoltre di:
      <ul>
        <li>riconoscersi nei <a href=\"/associazione\">principi e nelle finalità</a> dell'associazione.</li>
        <li>aver letto e approvare il <a href=\"/associazione/regolamento-per-ladesione#socisostenitori\" >regolamento di adesione</a> all'associazione.</li>
        <li>approvare esplicitamente l'informativa sulla privacy dell'associazione riportata all'indirizzo
            <a href=\"/associazione/informativa-sulla-privacy\">http://www.mozillaitalia.org/associazione/informativaprivacy/</a>.</li>
        <li>" . ($statopubblicazione ? "permettere" : "<strong>NON permettere</strong>" ) .
      " la pubblicazione del proprio nominativo nell'<a href=\"/associazione/regolamento-per-ladesione/\">elenco pubblico dei soci sostenitori</a> dell'associazione.</li>
      </ul> ";
      ?>
      <h3>Conferma domanda di adesione</h3>
      <p><strong>Attenzione: la domanda di adesione non è ancora stata inviata.</strong> Verificare la correttezza dei dati
      inseriti e confermare con il pulsante <em>Conferma richiesta di adesione</em>. Per correggere un dato fare clic sul
      pulsante <em>Indietro</em> del proprio browser.</p>
      <form id="frmadesione" class="form-horizontal" method="post" action="">
        <?php echo $output; ?>
        <input type="hidden" name="nome" id="nome" value="<?php echo $nome; ?>" />
        <input type="hidden" name="cognome" id="cognome" required="required" value="<?php echo $cognome; ?>" />
        <input type="hidden" name="email1" required="required" id="email1" value="<?php echo $email1; ?>" />
        <input type="hidden" name="email2" required="required" id="email2" value="<?php echo $email2; ?>" />
        <input type="hidden" name="azienda" id="azienda" value="<?php echo $azienda; ?>" />
        <input type="hidden" name="indirizzo" id="indirizzo" value="<?php echo $indirizzo; ?>" />
        <input type="hidden" name="cap" id="cap" value="<?php echo $cap; ?>" />
        <input type="hidden" name="citta" id="citta" value="<?php echo $citta; ?>" />
        <input type="hidden" name="provincia" id="provincia" value="<?php echo $provincia; ?>" />
        <input type="hidden" name="privacy" id="privacy" value="<?php echo $statopubblicazione; ?>" />
        <input type="hidden" name="pubblicazione" id="pubblicazione" value="<?php echo $pubblicazione; ?>" />
        <input type="hidden" name="privacy" id="privacy" value="<?php echo $privacy; ?>" />
        <input type="hidden" name="status" id="status" value="send" />
        <div class="control-group">
          <div class="controls">
            <button class="btn btn-large btn-primary" type="submit">Conferma richiesta di adesione</button>
          </div>
        </div>
      </form>
    <?php
    }

    if ($status == 'send') {
      $to = 'adesioni' . '@mozillaitalia.org';
      $subject = "$cognome, $nome - " . ($pubblicazione ? "" : "NON PUB - ") . " richiesta di adesione";
      $body = "<p>Richiesta da IP " . $_SERVER['REMOTE_ADDR'] . " effettuata il " . date("d/m/y H:i") . "</p>\n";
      $body .= "<p><strong>Nominativo:</strong> $nome $cognome</p>\n";
      $body .= "<p><strong>Indirizzo email:</strong> $email1</p>\n";
      $body .= "<p><strong>Ragione sociale:</strong> $azienda</p>\n";
      $body .= "<p><strong>Indirizzo:</strong> $cap $citta ($provincia)</p>\n";
      $body .= "<p><strong>Fascia</strong> $quotelivelli[$livello]</p>\n";
      $body .= "<p><strong>Quota da versare</strong>: $totalequota € ($quotaassociativa € quota associativa + $quotetxt[$i] quota annuale per l'anno $annotxt)</p>\n";
      $body .= "<p>Dichiara inoltre di:
      <ul>
        <li>riconoscersi nei <a href=\"/associazione\">principi e nelle finalità</a> dell'associazione.</li>
        <li>aver letto e approvare il <a href=\"/associazione/regolamento-per-ladesione#socisostenitori\" >regolamento di adesione</a> all'associazione.</li>
        <li>approvare esplicitamente l'informativa sulla privacy dell'associazione riportata all'indirizzo
            <a href=\"/associazione/informativa-sulla-privacy\">http://www.mozillaitalia.org/associazione/informativaprivacy/</a>.</li>
        <li>" . ($statopubblicazione ? "permettere" : "<strong>NON permettere</strong>" ) .
      " la pubblicazione del proprio nominativo nell'<a href=\"/associazione/regolamento-per-ladesione/\">elenco pubblico dei soci sostenitori</a> dell'associazione.</li>
      </ul> ";

      $extra_headers = "From: " .  $email1 . "\r\n";
      $extra_headers .= "Reply-to: ". $email1 ."\r\n";
      $extra_headers .= "MIME-Version: 1.0\r\n";
      $extra_headers .= "Content-Type: text/html; charset=UTF-8\r\n";

      if (mail($to, $subject, $body, $extra_headers)) {?>
        <div class="alert alert-success">
          <button type="button" class="close" data-dismiss="alert">×</button>
          <p>Grazie, la richiesta di adesione è stata inoltrata correttamente. Nei prossimi giorni riceverai all'indirizzo email
             specificato informazioni dettagliate sulle modalità di pagamento della quota.</p>
          <p>Per ogni dubbio relativo alla procedura di adesione puoi contattarci dalla <a href="/associazione/contatti">pagina dei contatti</a>.</p>
          <p>Ti ringraziamo per il contributo che stai dando alla nostra Associazione!</p>
        </div>
      <?php
      } else { ?>
        <div class="alert alert-block alert-error fade in">
          <button type="button" class="close" data-dismiss="alert">×</button>
          <p>Si è verificato un errore durante l'invio del messaggio. Tornare indietro e riprovare.</p>
        </div>
      <?php
      }

      echo '<h4>Conferma richiesta di adesione</h4>
            <p></p>
            <div>
            ' . $body .
            '</div>';
    }
    ?>
  </div>
</article>