<?php

/**
 * The form class.
 *
 * This will handle the form when posted
 *
 * Validates the fields and inserts into the database
 *
 * @since      1.0.0
 * @package    Assessment
 * @author     Dirk Veefkind <dirk.veefkind@thriddle.nl>
 */

class Assessment_Form {

  /**
	 * The variable fields of the form
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      array    $fields    contains the form fields
	 */
	public  $fields;

  /**
	 * The default values of the fields
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      array    $default_values    contains the default values of the fields
	 */
	public  $default_values;

  /**
	 * The messages shown to the user
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      array    $messages    contains messages
	 */
	public  $messages;

  /**
   * Sets the default values of the fields
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

    $this->default_values = array(
      'title' => 0,
      'first_name' => '',
      'middle_name' => '',
      'last_name' => '',
      'email' => '',
      'country' => 'NL'
    );

	}


  /**
   * Collect the form fields
   *
   * Collects the form fields from the $_POST data
   * fills up the fields array
   *
   * @since   1.0.0
   * @access  public
   * @param   array   $post_data    array with $_POST data
   */
	public function get_form_data( $post_data ) {


    if ( isset( $post_data['title'] )) {
      $this->fields['title'] = intval( $post_data['title'] );
    } else {
      $this->fields['title'] = $this->default_values['title'];
    }

    if ( isset( $post_data['first_name'] )) {
      $this->fields['first_name'] = preg_replace( '/\s+/', ' ', strip_tags( trim( $post_data['first_name'] ) ) );
    } else {
      $this->fields['first_name'] = $this->default_values['first_name'];
    }

    if ( isset( $post_data['middle_name'] )) {
      $this->fields['middle_name'] = preg_replace( '/\s+/', ' ', strip_tags( trim( $post_data['middle_name'] ) ) );
    } else {
      $this->fields['middle_name'] = $this->default_values['middle_name'];
    }

    if ( isset( $post_data['last_name'] )) {
      $this->fields['last_name'] = preg_replace( '/\s+/', ' ', strip_tags( trim( $post_data['last_name'] ) ) );
    } else {
      $this->fields['last_name'] = $this->default_values['last_name'];
    }

    if ( isset( $post_data['email'] )) {
      $this->fields['email'] = preg_replace( '/\s+/', ' ', strip_tags( trim( $post_data['email'] ) ) );
    } else {
      $this->fields['email'] = $this->default_values['email'];
    }

    if ( isset( $post_data['country'] )) {
      $this->fields['country'] = preg_replace( '/\s+/', ' ', strip_tags( trim( $post_data['country'] ) ) );
    } else {
      $this->fields['country'] = $this->default_values['country'];
    }

  }


  /**
   * Validates the form data
   *
   * Validates every field of the form.
   * If not valid, an error message is created.
   * Returns true if valid or false in case of an error.
   *
   * @since   1.0.0
   * @access  public
   * @return  bool
   */
	public function validate_form_data() {

    // Validate the title field
    if ( ! array_key_exists( $this->fields['title'], $this->get_title_options() ) ) {
      // shouldn't be possible, user might be messing with the form
      $this->messages['errors'][] = "Sorry, er is een probleem met de aanhef.";
      $this->fields['title'] = $this->default_values['title'];
    }

    // Validate the first name field
    if ( ! $this->fields['first_name'] ) {
      $this->messages['errors'][] = "Voornaam is verplicht in te vullen.";
    } elseif ( strlen( $this->fields['first_name'] ) > 256 ) {
      $this->messages['errors'][] = "Voornaam is te lang. Geef een kortere naam op.";
    } else {
			preg_match( '/^[a-zA-Z\s\-\']*$/', $this->fields['first_name'], $matches );
			// Check if first name does consist of alphabetic characters of dash or single quote (to match names like Jay-Lyn O'Hara)
			if ( empty( $matches ) ) {
				$this->messages['errors'][] = "Voornaam bestaat uit niet toegestane karakters.";
			}
		}

    // Validate the middle name field
    if ( strlen( $this->fields['middle_name'] ) > 256 ) {
      $this->messages['errors'][] = "Tussenvoegsel is te lang. Geef een kortere naam op.";
    } else {
			preg_match( '/^[a-zA-Z\s\-\']*$/', $this->fields['first_name'], $matches );
			if ( empty( $matches ) ) {
				$this->messages['errors'][] = "Tussenvoegsel bestaat uit niet toegestane karakters.";
			}
		}

    // Validate the last name field
    if ( ! $this->fields['last_name'] ) {
      $this->messages['errors'][] = "Achternaam is verplicht in te vullen.";
    } elseif ( strlen( $this->fields['last_name'] ) > 256 ) {
      $this->messages['errors'][] = "Achternaam is te lang. Geef een kortere naam op.";
    } else {
			preg_match( '/^[a-zA-Z\s\-\']*$/', $this->fields['first_name'], $matches );
			if ( empty( $matches ) ) {
				$this->messages['errors'][] = "Achternaam bestaat uit niet toegestane karakters.";
			}
		}

    // Validate the email field
    if ( ! $this->fields['email'] ) {
      $this->messages['errors'][] = "Email adres is verplicht in te vullen.";
    } elseif ( ! filter_var($this->fields['email'], FILTER_VALIDATE_EMAIL) ) {
      $this->messages['errors'][] = "Vul een geldig email adres in.";
    }

    // Validate the country field
    if ( ! array_key_exists( $this->fields['country'], $this->get_country_options() ) ) {
			// shouldn't be possible, user might be messing with the form
      $this->messages['errors'][] = "Sorry, er is een probleem het veld 'land'.";
      $this->fields['country'] = $this->default_values['country'];
    }

    return ( ! isset( $this->messages['errors'] ) );

  }


  /**
   * Resets form data
   *
   * @since   1.0.0
   * @access  public
   * @return  array
   */
	public function reset_form_data() {

    $this->fields['title']       = $this->default_values['title'];
    $this->fields['first_name']  = $this->default_values['first_name'];
    $this->fields['middle_name'] = $this->default_values['middle_name'];
    $this->fields['last_name']   = $this->default_values['last_name'];
    $this->fields['email']       = $this->default_values['email'];
    $this->fields['country']     = $this->default_values['country'];

  }


  /**
   * Get all the options for the title field
   *
   * @since   1.0.0
   * @access  public
   * @return  array
   */
	public function get_title_options() {

    $title_options = array(
      'Heer',
      'Mevrouw'
    );

    return $title_options;
  }


  /**
   * Get all the options for the country field
   *
   * @since   1.0.0
   * @access  public
   * @return  array
   */
  function get_country_options() {

    $country_options = array(
      "AF" => "Afghanistan",
      "AX" => "Alandeilanden",
      "AL" => "Albanië",
      "DZ" => "Algerije",
      "AS" => "Amerikaans Samoa",
      "VI" => "Amerikaanse Maagdeneilanden",
      "UM" => "Amerikaanse kleinere afgelegen eilanden",
      "AD" => "Andorra",
      "AO" => "Angola",
      "AI" => "Anguilla",
      "AQ" => "Antarctica",
      "AG" => "Antigua en Barbuda",
      "AR" => "Argentinië",
      "AM" => "Armenië",
      "AW" => "Aruba",
      "AU" => "Australië",
      "AZ" => "Azerbeidzjan",
      "BS" => "Bahama’s",
      "BH" => "Bahrein",
      "BD" => "Bangladesh",
      "BB" => "Barbados",
      "BE" => "België",
      "BZ" => "Belize",
      "BJ" => "Benin",
      "BM" => "Bermuda",
      "BT" => "Bhutan",
      "BO" => "Bolivia",
      "BA" => "Bosnië en Herzegovina",
      "BW" => "Botswana",
      "BV" => "Bouveteiland",
      "BR" => "Brazilië",
      "IO" => "Britse Gebieden in de Indische Oceaan",
      "VG" => "Britse Maagdeneilanden",
      "BN" => "Brunei",
      "BG" => "Bulgarije",
      "BF" => "Burkina Faso",
      "BI" => "Burundi",
      "KH" => "Cambodja",
      "CA" => "Canada",
      "KY" => "Caymaneilanden",
      "CF" => "Centraal-Afrikaanse Republiek",
      "CL" => "Chili",
      "CN" => "China",
      "CX" => "Christmaseiland",
      "CC" => "Cocoseilanden",
      "CO" => "Colombia",
      "KM" => "Comoren",
      "CG" => "Congo",
      "CD" => "Congo-Kinshasa",
      "CK" => "Cookeilanden",
      "CR" => "Costa Rica",
      "CU" => "Cuba",
      "CY" => "Cyprus",
      "DK" => "Denemarken",
      "DJ" => "Djibouti",
      "DM" => "Dominica",
      "DO" => "Dominicaanse Republiek",
      "DE" => "Duitsland",
      "EC" => "Ecuador",
      "EG" => "Egypte",
      "SV" => "El Salvador",
      "GQ" => "Equatoriaal-Guinea",
      "ER" => "Eritrea",
      "EE" => "Estland",
      "ET" => "Ethiopië",
      "FO" => "Faeröer",
      "FK" => "Falklandeilanden",
      "FJ" => "Fiji",
      "PH" => "Filipijnen",
      "FI" => "Finland",
      "FR" => "Frankrijk",
      "GF" => "Frans-Guyana",
      "PF" => "Frans-Polynesië",
      "TF" => "Franse Gebieden in de zuidelijke Indische Oceaan",
      "GA" => "Gabon",
      "GM" => "Gambia",
      "GE" => "Georgië",
      "GH" => "Ghana",
      "GI" => "Gibraltar",
      "GD" => "Grenada",
      "GR" => "Griekenland",
      "GL" => "Groenland",
      "GP" => "Guadeloupe",
      "GU" => "Guam",
      "GT" => "Guatemala",
      "GG" => "Guernsey",
      "GN" => "Guinee",
      "GW" => "Guinee-Bissau",
      "GY" => "Guyana",
      "HT" => "Haïti",
      "HM" => "Heard- en McDonaldeilanden",
      "HN" => "Honduras",
      "HU" => "Hongarije",
      "HK" => "Hongkong SAR van China",
      "IS" => "IJsland",
      "IE" => "Ierland",
      "IN" => "India",
      "ID" => "Indonesië",
      "IQ" => "Irak",
      "IR" => "Iran",
      "IM" => "Isle of Man",
      "IL" => "Israël",
      "IT" => "Italië",
      "CI" => "Ivoorkust",
      "JM" => "Jamaica",
      "JP" => "Japan",
      "YE" => "Jemen",
      "JE" => "Jersey",
      "JO" => "Jordanië",
      "CV" => "Kaapverdië",
      "CM" => "Kameroen",
      "KZ" => "Kazachstan",
      "KE" => "Kenia",
      "KG" => "Kirgizië",
      "KI" => "Kiribati",
      "KW" => "Koeweit",
      "HR" => "Kroatië",
      "LA" => "Laos",
      "LS" => "Lesotho",
      "LV" => "Letland",
      "LB" => "Libanon",
      "LR" => "Liberia",
      "LY" => "Libië",
      "LI" => "Liechtenstein",
      "LT" => "Litouwen",
      "LU" => "Luxemburg",
      "MO" => "Macao SAR van China",
      "MK" => "Macedonië",
      "MG" => "Madagaskar",
      "MW" => "Malawi",
      "MV" => "Maldiven",
      "MY" => "Maleisië",
      "ML" => "Mali",
      "MT" => "Malta",
      "MA" => "Marokko",
      "MH" => "Marshalleilanden",
      "MQ" => "Martinique",
      "MR" => "Mauritanië",
      "MU" => "Mauritius",
      "YT" => "Mayotte",
      "MX" => "Mexico",
      "FM" => "Micronesië",
      "MD" => "Moldavië",
      "MC" => "Monaco",
      "MN" => "Mongolië",
      "ME" => "Montenegro",
      "MS" => "Montserrat",
      "MZ" => "Mozambique",
      "MM" => "Myanmar",
      "NA" => "Namibië",
      "NR" => "Nauru",
      "NL" => "Nederland",
      "AN" => "Nederlandse Antillen",
      "NP" => "Nepal",
      "NI" => "Nicaragua",
      "NC" => "Nieuw-Caledonië",
      "NZ" => "Nieuw-Zeeland",
      "NE" => "Niger",
      "NG" => "Nigeria",
      "NU" => "Niue",
      "KP" => "Noord-Korea",
      "MP" => "Noordelijke Marianeneilanden",
      "NO" => "Noorwegen",
      "NF" => "Norfolkeiland",
      "UG" => "Oeganda",
      "UA" => "Oekraïne",
      "UZ" => "Oezbekistan",
      "OM" => "Oman",
      "ZZ" => "Onbekend of onjuist gebied",
      "TL" => "Oost-Timor",
      "AT" => "Oostenrijk",
      "PK" => "Pakistan",
      "PW" => "Palau",
      "PS" => "Palestijns Gebied",
      "PA" => "Panama",
      "PG" => "Papoea-Nieuw-Guinea",
      "PY" => "Paraguay",
      "PE" => "Peru",
      "PN" => "Pitcairn",
      "PL" => "Polen",
      "PT" => "Portugal",
      "PR" => "Puerto Rico",
      "QA" => "Qatar",
      "RO" => "Roemenië",
      "RU" => "Rusland",
      "RW" => "Rwanda",
      "RE" => "Réunion",
      "BL" => "Saint Barthélemy",
      "KN" => "Saint Kitts en Nevis",
      "LC" => "Saint Lucia",
      "PM" => "Saint Pierre en Miquelon",
      "VC" => "Saint Vincent en de Grenadines",
      "SB" => "Salomonseilanden",
      "WS" => "Samoa",
      "SM" => "San Marino",
      "ST" => "Sao Tomé en Principe",
      "SA" => "Saoedi-Arabië",
      "SN" => "Senegal",
      "RS" => "Servië",
      "CS" => "Servië en Montenegro",
      "SC" => "Seychellen",
      "SL" => "Sierra Leone",
      "SG" => "Singapore",
      "SH" => "Sint-Helena",
      "MF" => "Sint-Maarten",
      "SI" => "Slovenië",
      "SK" => "Slowakije",
      "SD" => "Soedan",
      "SO" => "Somalië",
      "ES" => "Spanje",
      "LK" => "Sri Lanka",
      "SR" => "Suriname",
      "SJ" => "Svalbard en Jan Mayen",
      "SZ" => "Swaziland",
      "SY" => "Syrië",
      "TJ" => "Tadzjikistan",
      "TW" => "Taiwan",
      "TZ" => "Tanzania",
      "TH" => "Thailand",
      "TG" => "Togo",
      "TK" => "Tokelau",
      "TO" => "Tonga",
      "TT" => "Trinidad en Tobago",
      "TD" => "Tsjaad",
      "CZ" => "Tsjechië",
      "TN" => "Tunesië",
      "TR" => "Turkije",
      "TM" => "Turkmenistan",
      "TC" => "Turks- en Caicoseilanden",
      "TV" => "Tuvalu",
      "UY" => "Uruguay",
      "VU" => "Vanuatu",
      "VA" => "Vaticaanstad",
      "VE" => "Venezuela",
      "GB" => "Verenigd Koninkrijk",
      "AE" => "Verenigde Arabische Emiraten",
      "US" => "Verenigde Staten",
      "VN" => "Vietnam",
      "WF" => "Wallis en Futuna",
      "EH" => "Westelijke Sahara",
      "BY" => "Wit-Rusland",
      "ZM" => "Zambia",
      "ZW" => "Zimbabwe",
      "ZA" => "Zuid-Afrika",
      "GS" => "Zuid-Georgië en Zuidelijke Sandwicheilanden",
      "KR" => "Zuid-Korea",
      "SE" => "Zweden",
      "CH" => "Zwitserland"
    );

    return $country_options;

  }

}
