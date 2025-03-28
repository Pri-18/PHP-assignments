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
  class User
  {

    /**
     * Constructs a new User object.
     *
     * @param string $firstName
     *      First name of the user
     * @param string $lastName
     *       Last name of the user     
     * @param string $phone
     *      Number of the user
     */

    public $firstName;
    public $lastName;
    public $phone;

    /**
     * Constructs a new User object.
     *
     * @param string $firstName
     * @param string $lastName
     */
    public function __construct($firstName, $lastName)
    {
      // Remove extra whitespace.
      $this->firstName = trim($firstName);
      $this->lastName = trim($lastName);
    }

    /**
     * Returns the full name of the user.
     *
     * @return string
     */
    public function getFullName()
    {
      return "$this->firstName $this->lastName";
    }

    /**
     * Returns the number of the user.
     *
     */
    public function getPhone()
    {
      return "$this->phone";
    }
  }

  /**
   * Class FileUploader
   * 
   * Provides functionalities of files.
   */
  class FileUploader
  {
    private $file;
    private $allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf'];
    private $maxFileSize = 500000; // 500 KB
    private $uploadDirectory = 'uploads/';

    /**
     * Constructor to initialize the file object.
     *
     * @param array $file
     *   The uploaded file information from $_FILES.
     */
    public function __construct($file)
    {
      $this->file = $file;
    }

    /**
     * Validate the file extension.
     *
     * @return bool
     */
    private function validateExtension()
    {
      $fileExt = strtolower(pathinfo($this->file['name'], PATHINFO_EXTENSION));
      return in_array($fileExt, $this->allowedExtensions);
    }

    /**
     * Validate the file size.
     *
     * @return bool
     */
    private function validateSize()
    {
      return $this->file['size'] <= $this->maxFileSize;
    }

    /**
     * Check for upload errors.
     *
     * @return bool
     *   TRUE if no errors occurred, FALSE otherwise.
     */
    private function validateError()
    {
      return $this->file['error'] === 0;
    }

    /**
     * Process the file upload.
     *
     * @return string
     *   The path to the uploaded file or an error message.
     */
    public function uploadFile()
    {
      if (!$this->validateExtension()) {
        return 'Extension not matched!';
      }

      if (!$this->validateError()) {
        return 'Something went wrong. Error occurred while uploading.';
      }

      if (!$this->validateSize()) {
        return 'File size is too big.';
      }

      $fileExt = strtolower(pathinfo($this->file['name'], PATHINFO_EXTENSION));
      $newFileName = uniqid('', true) . "." . $fileExt;
      $fileDest = $this->uploadDirectory . $newFileName;

      if (move_uploaded_file($this->file['tmp_name'], $fileDest)) {
        return "<div class='image'><img src='$fileDest' alt='Uploaded Image'></div>";
      }

      return 'Failed to upload the file.';
    }
  }

  /**
   * Class Marks
   * 
   * To create the table of marks.
   */
  class Marks
  {

    public $marksData = [];
    /**
     * Constructor to initialize the $marksInput.
     *
     * @param array $file
     *   The uploaded textarea info.
     */
    public function __construct($marksInput)
    {
      /** separate each line as an array to lines*/
      $lines = explode("\n", trim($marksInput));
      foreach ($lines as $line) {
        /** separate each marks and subject by '|' to data*/
        $data = explode('|', trim($line));
        //Storing the data(subject , marks) to marksData
        if (count($data) === 2) {
          $this->marksData[] = [
            'subject' => $data[0],
            'marks' => $data[1]
          ];
        }
      }
    }

    /**
     * Displaying the table of marks.
     *
     * @return array
     */

    public function displayMarks()
    {
      echo "<h2>Marks</h2>";
      echo "<table><tr><th>Subject</th><th>Marks</th></tr>";
      foreach ($this->marksData as $mark) {
        echo "<tr><td>{$mark['subject']}</td><td>{$mark['marks']}</td></tr>";
      }
      echo "</table>";
    }
  }

  /**
   * Class EmailValidator
   * 
   * To validate the email.
   */
  class EmailValidator
  {
    public $email;

    /**
     * Constructor to initialize the email.
     *
     * @param Bool 
     *   The returns true for valid email and false otherwise.
     */

    public function __construct($email)
    {
      $this->email = trim($email);
    }

    /**
     * Function to check the email syntax.
     *
     * @param Bool 
     *   The returns true for valid email syntax and false otherwise.
     */

    public function syntaxtMatch()
    {
      if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
        return false;
      }
      return true;
    }

    /**
     * Function to check the email.
     *
     * @param Bool 
     *   The returns true for valid email and false otherwise.
     */

    public function isValid()
    {
      $apiKey = "b4971c0f00578a70ca625cac386813a4";
      $url = "http://apilayer.net/api/check?access_key=$apiKey&email=$this->email";
      $apiRes =  file_get_contents($url);
      $result = json_decode($apiRes, true);

      if ($result["format_valid"] and $result["smtp_check"]) {
        return true;
      }
      return false;
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

    /**
     * Create a new uploader object.
     *
     * @var Fileuploader
     */
    $uploader = new FileUploader($_FILES['file']);

    /**
     * Create a new marks object.
     *
     * @var Marks
     */
    $marks = new Marks($_POST['marks']);

    /**
     * Create a new emailValidator object.
     *
     * @var EmailValidator
     */
    $emailValidator = new EmailValidator($_POST['email']);

    // Display the message.
    echo "<h1>Hello {$user->getFullName()}</h1>";
    $p = "<h1>Hello {$user->getFullName()}</h1>";


    echo "<h2> Your phone number is: {$user->getPhone()} </h2>";

    echo $uploader->uploadFile();

    // Display marks using the object method
    $marks->displayMarks();

    // displaying email
    if (!$emailValidator->syntaxtMatch()) {
      echo "<p class='error'>Invalid email syntax. Please try again.</p>";
    } else if (!$emailValidator->isValid()) {
      echo "<p class='error'>Email doesn't exists. Please try again.</p>";
    } else {
      echo "<p>Email: {$_POST['email']}</p>";
    }
  }
  ?>
</body>

</html>

</body>

</html>