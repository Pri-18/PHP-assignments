<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form result</title>
    <style>
        h1 {
            font-size: 4rem;
            text-align: center;
            margin-top: 4rem;
            color: green;
        }
    </style>
</head>
<body>
    <?php
    class User {
        public $firstName;
        public $lastName;

        public function __construct($firstName, $lastName) {
            $this->firstName = trim($firstName);
            $this->lastName = trim($lastName);
        }

        public function getFullName() {
            return "$this->firstName" ." " . "$this->lastName";
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $user = new User($_POST['fname'], $_POST['lname']);
        echo "<h1>Hello {$user->getFullName()}</h1>";
    }
    ?>
</body>
</html>
