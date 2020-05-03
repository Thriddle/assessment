<?php

/**
 * The form html template.
 *
 * This file will output the html form
 *
 * @since      1.0.0
 * @package    Assessment
 * @author     Dirk Veefkind <dirk.veefkind@thriddle.nl>
 */

?>


<!doctype html>
<html class="no-js" lang="nl">
  <head>
    <meta charset="utf-8">
    <title>Formulier</title>
    <meta name="description" content="assignment">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/main.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

  </head>

  <body>
    <div class="contact-form">
      <form id="ajax-contact" class="form" action="index.php" method="post">
        <h2>Gegevens formulier</h2>
        <div class="col-messages" id="form-messages">
          <?php if ( isset( $form->messages['errors'] )) {
            foreach( $form->messages['errors'] as $error ) {
              echo '<p class="error">' . $error . '</p>';
            }
          }
          if ( isset( $form->messages['notifications'] )) {
            foreach( $form->messages['notifications'] as $notification ) {
              echo '<p class="notification">' . $notification . '</p>';
            }
          }
          if ( isset( $form->messages['warnings'] )) {
            foreach( $form->messages['warnings'] as $notification ) {
              echo '<p class="warning">' . $notification . '</p>';
            }
          } ?>
        </div>
        <div class="form-radio">
          <div class="label">
            <label for="title">Aanhef</label>
          </div>
          <div class="form-radio-group">
            <?php foreach( $form->get_title_options() as $titleIndex => $titleValue ) : ?>
              <div class="form-radio-item">
                <input type="radio" id="title_<?php echo $titleIndex; ?>" name="title" value="<?php echo $titleIndex; ?>" <?php if ( $titleIndex === $form->fields['title']) echo "checked"; ?> />
                <label for="title_0"><?php echo $titleValue; ?></label>
              </div>
            <?php endforeach ?>
          </div>
        </div>
        <div class="form-input">
          <label>Naam<span class="required">*</span></label>
          <div class="form-input-group">
            <div class="form-input-item w40">
              <input type="text" name="first_name" placeholder="Voornaam" value="<?php echo $form->fields['first_name']; ?>" />
            </div>
            <div class="form-input-item w20">
              <input type="text" name="middle_name" placeholder="Tussenvoegsel" value="<?php echo $form->fields['middle_name']; ?>" />
            </div>
            <div class="form-input-item w40">
              <input type="text" name="last_name" placeholder="Achternaam" value="<?php echo $form->fields['last_name']; ?>" />
            </div>
          </div>
        </div>
        <div class="form-email">
          <label>Email adres<span class="required">*</span></label>
          <input type="text" name="email" class="field-long" value="<?php echo $form->fields['email']; ?>" />
        </div>
        <div class="form-select">
          <label>Land</label>
          <select name="country" class="field-select">
            <?php foreach ( $form->get_country_options() as $countryIndex => $countryname) : ?>
              <option value="<?php echo $countryIndex; ?>" <?php if ( $countryIndex === $form->fields['country'] ) echo "selected"; ?>><?php echo $countryname; ?></option>
            <?php endforeach ?>
          </select>
        </div>
        <div class="form-submit">
          <input type="submit" value="Submit" />
        </div>
      </form>
    </div>
  </body>
</html>
