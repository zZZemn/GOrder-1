var messageDropdown = document.getElementsByClassName("message-dropdown");

var avatarDropdown = document.getElementsByClassName("avatar-dropdown");
var avatarDropdownContainer = document.getElementsByClassName(
    "avatar-dropdown-container"
);

var notificationDropdown = document.getElementsByClassName(
    "notification-dropdown"
);
var notificationDropdownContainer = document.getElementsByClassName(
    "notification-dropdown-container"
);

var i;

for (i = 0; i < messageDropdown.length; i++) {
    messageDropdown[i].addEventListener("click", function () {

        var dropdownContent = this.nextElementSibling;

        if (dropdownContent.style.display === "block") {
            dropdownContent.style.display = "none";
            this
                .classList
                .remove("message-active")

        } else {
            dropdownContent.style.display = "block";
            this
                .classList
                .add("message-active")

            avatarDropdownContainer[0].style.display = "none";
            notificationDropdownContainer[0].style.display = "none";

            avatarDropdown[0]
                .classList
                .remove("avatar-active");
            notificationDropdown[0]
                .classList
                .remove("notification-active");
        }
    });
}
