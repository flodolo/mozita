<?php
  // View -> visualizza il form
  // Insert -> ha compilato il form, invio email
  $status = !empty($_REQUEST['status']) ? $_REQUEST['status'] : 'view';

  $nome = !empty($_POST['nome']) ? strip_tags(stripslashes($_POST['nome'])) : '';
  $email1 = !empty($_POST['email1']) ? strip_tags(stripslashes($_POST['email1'])) : '';
  $email2 = !empty($_POST['email2']) ? strip_tags(stripslashes($_POST['email2'])) : '';
  $codiceconferma = !empty($_POST['codiceconferma']) ? strip_tags(stripslashes($_POST['codiceconferma'])) : '';
  $destinatario = !empty($_POST['destinatario']) ? $_POST['destinatario'] : '';
  $richiesta = !empty($_POST['richiesta']) ? nl2br(strip_tags(stripslashes($_POST['richiesta']))) : '';

  $errori = '';
  if ($status == 'send') {
    if ($nome == '') $errori .= "<li>Specificare il nome</li>\n";
    if ($email1 == '' || $email2 == '' ) $errori .= "<li>Specificare il proprio indirizzo email</li>\n";
    if ($email1 != $email2) $errori .= "<li>Le mail inserite non corrispondono</li>\n";
    if ($destinatario == 0) $errori .= "<li>Selezionare un destinatario</li>\n";
    if ($codiceconferma != 'gatto') $errori .= "<li>Il codice di conferma è errato (scrivere <strong>gatto</strong>, minuscolo)</li>\n";
    if ($richiesta == '') $errori .= "<li>Inserire una richiesta</li>\n";
  }

  $destinatari = array('---',
    'Associazione',
    'Adesioni',
    'Francesco Lodolo, presidente',
    'Iacopo Benesperi, vicepresidente',
    'Giovanni Francesco Solone, segretario',
    'Luca Casali, consigliere',
    'Simone Lando, consigliere',
    'Roberto Principiano, consigliere',
    'Michele Rodaro, consigliere',
    'Stefano Tintorini, consigliere'
  );

  # Nota: il dominio @mozillaitalia.org viene aggiunto al momento dell'invio
  $indirizzi = array('---',
    'associazione',
    'adesioni',
    'francesco.lodolo',
    'iacopo.benesperi',
    'giovanni.solone',
    'luca.casali',
    'simone.lando',
    'roberto.principiano',
    'michele.rodaro',
    'stefano.tintorini'
  );
?>

<div class="row-fluid" id="hometop">
  <div class="span8" id="introhome">
    <h2>Contatti associazione</h2>
    <p>Attraverso questa pagina è possibile contattare l'associazione o uno dei suoi membri.</p>
    <h3>Non scrivere se…</h3>
    <p>Non utilizzare questo modulo per inviare richieste di aiuto relative ai prodotti Mozilla:
        tutte le domande di questo tipo verranno <strong>sistematicamente cestinate</strong>.
        Per ottenere supporto utilizzare l'apposito <a href="http://forum.mozillaitalia.org">forum</a>.</p>
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
<article <?php post_class(); ?>>
  <div class="entry-content">
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
      <form id="frmcontatti" class="form-horizontal" method="post" action="">
        <input type="hidden" name="status" id="status" value="send" />
        <div class="control-group">
          <label class="control-label" for="nome">Nome</label>
          <div class="controls">
            <input type="text" class="input-xxlarge" name="nome" id="nome" required="required" value="<?php echo $nome; ?>" />
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="email1">Email mittente</label>
          <div class="controls">
            <input type="email" class="input-xxlarge" name="email1" required="required" id="email1" value="<?php echo $email1; ?>" />
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="email2">Conferma email</label>
          <div class="controls">
            <input type="email" class="input-xxlarge" name="email2" required="required" id="email2" value="<?php echo $email2; ?>" />
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="codiceconferma">Che animale era il gatto con gli stivali?</label>
          <div class="controls">
            <input type="text" class="input-xxlarge" name="codiceconferma" required="required" id="codiceconferma" value="<?php echo $codiceconferma; ?>" />
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="destinatario">Destinatario</label>
          <div class="controls">
            <select class="input-xlarge" name="destinatario" id="destinatario">
              <?php
                echo "<optgroup label='Indirizzi istituzionali'>\n";
                for($i=0; $i<3; $i++) {
                  if ($destinatario == $i) {
                    echo "  <option value='$i' selected='selected'>$destinatari[$i]</option>\n";
                  } else {
                    echo "  <option value='$i'>$destinatari[$i]</option>\n";
                  }
                }
                echo "</optgroup>\n";
                echo "<optgroup label='Membri del consiglio'>\n";
                for($i=3; $i<count($destinatari); $i++) {
                  if ($destinatario == $i) {
                    echo "  <option value='$i' selected='selected'>$destinatari[$i]</option>\n";
                  } else {
                    echo "  <option value='$i'>$destinatari[$i]</option>\n";
                  }
                }
                echo "</optgroup>\n";
              ?>
            </select>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="richiesta">Richiesta:</label>
          <div class="controls">
            <textarea rows="6" required="required" class="input-xxlarge" name="richiesta" id="richiesta"><?php echo $richiesta; ?></textarea>
          </div>
        </div>
        <div class="control-group">
          <div class="controls">
            <button class="btn btn-large btn-primary" type="submit">Invia richiesta</button>
          </div>
        </div>
      </form>
      <p>Con l'invio di questo messaggio il mittente dichiara di approvare
        l'<a href="/associazione/informativa-sulla-privacy/">informativa sul trattamento dei dati personali</a> dell'associazione.</p>
    <?php
    }

    if ($status == 'send') {
      $to = $indirizzi[$destinatario] . '@mozillaitalia.org';
      $subject = 'Richiesta informazioni dal sito di mozillaitalia.org';
      $body = "<p><strong>$nome</strong> ($email1)</p>\n";
      $body .= "<p>Richiesta da IP " . $_SERVER['REMOTE_ADDR'] . " effettuata il " . date("d/m/y H:i") . "</p>\n";
      $body .= "<p><strong>Testo messaggio</strong></p>\n<div>$richiesta<div>\n";

      $extra_headers = "From: " .  $email1 . "\r\n";
      $extra_headers .= "Reply-to: ". $email1 ."\r\n";
      $extra_headers .= "MIME-Version: 1.0\r\n";
      $extra_headers .= "Content-Type: text/html; charset=UTF-8\r\n";

      if (mail($to, $subject, $body, $extra_headers)) {?>
        <div class="alert alert-success">
          <button type="button" class="close" data-dismiss="alert">×</button>
          <p>Messaggio inviato correttamente</p>
        </div>
      <?php
      } else { ?>
        <div class="alert alert-block alert-error fade in">
          <button type="button" class="close" data-dismiss="alert">×</button>
          <p>Si è verificato un errore durante l'invio del messaggio. Tornare indietro e riprovare.</p>
        </div>
      <?php
      }

      echo '<h4>Contenuto del messaggio</h4>
            <div>
            ' . $body .
            '</div>';
    }
    ?>
  </div>
</article>