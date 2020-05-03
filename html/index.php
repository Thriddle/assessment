<?php

/**
 * The form bootstrap file
 *
 * @since      1.0.0
 * @package    Assessment
 * @author     Dirk Veefkind <dirk.veefkind@thriddle.nl>
 */

require 'class-assessment-db.php';
require 'class-assessment-form.php';

function run_form() {

  // Using a template, start output buffer
  ob_start();

  // Need a form object to validate the form, but also for outputting the form
 	$form = new Assessment_Form();

  // If the form is posted, do something with it
  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // get the form data
    $form->get_form_data( $_POST );

    // validate the form data
    if ( $form->validate_form_data() ) {

      $DB = new Assessment_DB();

      // store the form data
      $form->messages = $DB->save_form_data( $form->fields );
      if ( ! isset( $form->messages['errors'] ) ) {
        $form->reset_form_data();
      }
    }
  } else{

    // Form isn't posted, set the field with the default values
    $form->reset_form_data();
  }

  include('form-template.php');

}
run_form();
