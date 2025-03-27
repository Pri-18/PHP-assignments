<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form result</title>
    <link rel="stylesheet" href="form.css">
</head>
<body>
    <?php
/**
 * Class User
 * 
 * Provides an user's first and last name.
 */
class User {
  /**
   * First name of the user.
   *
   * @var string
   */
  public $firstName;

  /**
   * Last name of the user.
   *
   * @var string
   */
  public $lastName;

  /**
   * Constructs a new User object.
   *
   * @param string $firstName
   * @param string $lastName
   */
  public function __construct($firstName, $lastName) {
    // Remove extra whitespace.
    $this->firstName = trim($firstName);
    $this->lastName = trim($lastName);
  }

  /**
   * Returns the full name of the user.
   *
   * @return string
   */
  public function getFullName() {
    return "$this->firstName $this->lastName";
  }
}

// Check the request method (POST).
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  /**
   * Create a new User object.
   *
   * @var User $user
   */
  $user = new User($_POST['fname'], $_POST['lname']);

  // Display the message.
  echo "<h1>Hello {$user->getFullName()}</h1>";
}
?>
</body>
</html>

</body>
</html>
