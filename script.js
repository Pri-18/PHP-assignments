/**
 * Form fullname update function for user form.
 */
function updateFullname() {
    // get the value of the firstname and trimmed the extra space 
    let firstName = document.getElementById("fname").value.trim();
    // get the value of the lastname and trimmed the extra space 
    let last_name = document.getElementById("lname").value.trim();
    //updating the full name
    document.getElementById("full_name").value = firstName + " " + last_name;
  }
