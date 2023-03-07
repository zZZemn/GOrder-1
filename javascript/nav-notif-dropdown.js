var notificationDropdown = document.getElementsByClassName("notification-dropdown");

var avatarDropdown = document.getElementsByClassName("avatar-dropdown");
var avatarDropdownContainer = document.getElementsByClassName("avatar-dropdown-container");

var messageDropdown = document.getElementsByClassName("message-dropdown");
var messageDropdownContainer = document.getElementsByClassName("message-dropdown-container");

var i;


for (i = 0; i < notificationDropdown.length; i++) {
    notificationDropdown[i].addEventListener("click", function() {
    
    var dropdownContent = this.nextElementSibling;

    if (dropdownContent.style.display === "block") 
    {
        dropdownContent.style.display = "none";
        this.classList.remove("notification-active")
    } 
    else 
    {
        dropdownContent.style.display = "block";
        this.classList.add("notification-active")

        avatarDropdownContainer[0].style.display = "none";
        avatarDropdown[0].classList.remove("avatar-active");

        messageDropdownContainer[0].style.display = "none";
        messageDropdown[0].classList.remove("message-active");
    }
  });
}


