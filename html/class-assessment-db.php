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

class Assessment_DB {

  /**
	 * The name of the database
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $db_name    database name
	 */
	private  $db_name;

  /**
   * The host where the database is located
   *
   * @since    1.0.0
   * @access   private
   * @var      string    $db_host    database host
   */
  private  $db_host;

  /**
   * The username needed for the database
   *
   * @since    1.0.0
   * @access   private
   * @var      string    $db_user    username
   */
  private  $db_user;

  /**
   * The password of the user
   *
   * @since    1.0.0
   * @access   private
   * @var      string    $db_password    password for user
   */
  private  $db_password;


  /**
	 * The messages shown to the user
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      array    $messages    contains messages
	 */
	public  $messages;

  /**
	 * The user fetched from the database
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      array    $user    user data
	 */
	private  $user;


  /**
   * Sets the database settings
   *
   * The database settings are stored in the environment variables
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

    $this->db_name      = getenv( 'DB_NAME' );
    $this->db_user      = getenv( 'DB_USER' );
    $this->db_password  = getenv( 'DB_PASSWORD' );
    $this->db_host      = getenv( 'DB_HOST' );

  }


  /**
   * Save the form data in the database
   *
   * Connects to the database, creates a query to insert data in database.
   * Returns true if the data is stored. false if there's an error with the database.
   *
   * @since   1.0.0
   * @access  public
   * @return  bool
   */
  public function save_form_data( $fields ) {

    // Connect to database and insert data
    try {

      $connection = new PDO("mysql:host=$this->db_host;dbname=$this->db_name", $this->db_user, $this->db_password);

      // Set the PDO error mode to exception
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      // Construct the query
      $query = "INSERT INTO `user_records` (`firstname`, `middlename`, `lastname`, `email`, `title`, `country`)
        VALUES (:firstname, :middlename, :lastname, :email, :title, :country)";

      // prepare statement
      $statement = $connection->prepare($query);

      // Bind values to parameters
      $statement->bindValue(':firstname', $fields['first_name']);
      $statement->bindValue(':middlename', $fields['middle_name']);
      $statement->bindValue(':lastname', $fields['last_name']);
      $statement->bindValue(':email', $fields['email']);
      $statement->bindValue(':title', $fields['title']);
      $statement->bindValue(':country', $fields['country']);

      // execute statement
      $statement->execute();
      $this->messages['notifications'][] = "Dank u, de data is opgeslagen.";
    }
    catch( PDOException $e )
    {
      $this->messages['errors'][] = "Sorry, er is een probleem met de database: Foutcode " . $e->getCode() . ".";
    }

    $connection = null;

    return ( $this->messages );

  }

  public function get_user_data( $user_id ) {

    // Connect to database and fetch the user data
    try {

      $connection = new PDO("mysql:host=$this->db_host;dbname=$this->db_name", $this->db_user, $this->db_password);

      // Set the PDO error mode to exception
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      // Construct the query
      $query = "SELECT * FROM `user_records` WHERE id=?";

      // select a particular user by id
      $statement = $connection->prepare($query);
      $statement->execute([$user_id]);
      $this->user = $statement->fetch();

    }
    catch(PDOException $e)
    {
      $this->messages['errors'][] = "Sorry, er is een probleem met de database: Foutcode " . $e->getCode() . ".";
    }

    $connection = null;

    return $this->user;

  }


}


?>
