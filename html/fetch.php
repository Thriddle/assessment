<?php

/**
 * The fetch bootstrap file
 *
 * @since      1.0.0
 * @package    Assessment
 * @author     Dirk Veefkind <dirk.veefkind@thriddle.nl>
 */

require 'class-assessment-db.php';
require 'class-assessment-form.php';

function run_fetch() {

  if ($_SERVER["REQUEST_METHOD"] == "GET") {

    // response code
    $response_code = 404;
    $response = array( "message"=> "Geen gebruiker gevonden." );

    // Check if id is set and numeric
    if ( isset( $_GET['id'] ) && is_numeric( $_GET['id'] ) ) {

      $id = intval( $_GET['id'] );

      if ( $id > 0 ) {

        $DB   = new Assessment_DB();
        $form = new Assessment_Form();

        $user = $DB->get_user_data( $id );

        if ( $user ) {

          $response = array(
            'title' => $form->get_title_options()[$user['title']],
            'first_name' => $user['firstname'],
            'middle_name' => $user['middlename'],
            'last_name' => $user['lastname'],
            'email' => $user['email'],
            'country' => $form->get_country_options()[$user['country']]
          );

          $response_code = 200;

        }
      }
    }

    // Out put user in JSON format

    // required headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

    // set response code
    http_response_code($response_code);

    // tell the user no products found
    echo json_encode( $response );
  }
}

run_fetch();



?>
