function updateFullname() {
    firstName = document.getElementById("fname").value;
    last_name = document.getElementById("lname").value;
    document.getElementById("full_name").value = firstName + " " + last_name;
  }