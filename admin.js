// script.js
document.addEventListener('DOMContentLoaded', function () {
    // Hide the buttons initially
    var currentURL = window.location.href
    var check = 'userIdComparison';
    if (currentURL.indexOf(check) !== -1) {
        toggleReservationsCar();
    }

    var check2 = 'userID';
    if (currentURL.indexOf(check2) !== -1) {
        toggleUsersTable();
    }
    var check3 = "officeIDD";
    if (currentURL.indexOf(check3) !== -1) {
        toggleOfficeTable();
    }


});
document.addEventListener('DOMContentLoaded', function () {
    // Hide the buttons initially
    var allStatusElements = document.querySelectorAll('.car-status');
    var allActivateButtons = document.querySelectorAll('.activate-car');
    var allDeactivateButtons = document.querySelectorAll('.deactivate-car');
    var allEditButtons = document.querySelectorAll('.edit-car');
    var allDeleteButtons = document.querySelectorAll('.delete-car');

    for (var i = 0; i < allStatusElements.length; i++) {
        var carStatus = allStatusElements[i].innerHTML.trim().toLowerCase();
        if (carStatus == 'active') {
            allActivateButtons[i].style.display = 'none';
            allDeactivateButtons[i].style.display = 'inline';
            allDeleteButtons[i].style.display = 'inline';
            allEditButtons[i].style.display = 'inline';
        } else if (carStatus == 'out_of_service') {
            allActivateButtons[i].style.display = 'inline';
            allDeactivateButtons[i].style.display = 'none';
            allDeleteButtons[i].style.display = 'inline';
            allEditButtons[i].style.display = 'inline';
        } else if (carStatus == 'rented') {
            allActivateButtons[i].style.display = 'none';
            allDeactivateButtons[i].style.display = 'none';
            allDeleteButtons[i].style.display = 'none';
            allEditButtons[i].style.display = 'inline';
        }
        else {
            // Handle other statuses if needed
            allActivateButtons[i].style.display = 'none';
            allDeactivateButtons[i].style.display = 'none';
            allDeleteButtons[i].style.display = 'none';
            allEditButtons[i].style.display = 'none';
        }
    }

});

/////////////////////////
document.addEventListener('DOMContentLoaded', function () {
    // Hide the buttons initially
    var allStatusElements = document.querySelectorAll('.rent_status');
    var allActivateButtons = document.querySelectorAll('.return_car');

    for (var i = 0; i < allStatusElements.length; i++) {
        var rentStatus = allStatusElements[i].innerHTML.trim().toLowerCase();
        if (rentStatus == 'returned') {
            allActivateButtons[i].style.display = 'none';
        } else {
            // Handle other statuses if needed
            allActivateButtons[i].style.display = 'inline';

        }
    }
});

document.addEventListener('DOMContentLoaded', function () {
    // Hide the buttons initially
    var allUserStatusElements = document.querySelectorAll('.user-status');
    var allBlockButtons = document.querySelectorAll('.block-button');
    var allActivateButtons = document.querySelectorAll('.activate-button');

    for (var i = 0; i < allUserStatusElements.length; i++) {
        var userStatus = allUserStatusElements[i].innerHTML.trim().toLowerCase();
        if (userStatus == 'blocked') {
            allBlockButtons[i].style.display = 'none';
            allActivateButtons[i].style.display = 'inline';
        } else {
            // Handle other statuses if needed  
            allBlockButtons[i].style.display = 'inline';
            allActivateButtons[i].style.display = 'none';

        }
    }
});
///////////////////////


/////////////////////////
function toggleCarTable() {
    var carTable = document.getElementById("carTable");
    var userTable = document.getElementById("userTable");
    var rentsTable = document.getElementById("myRentsTable");
    var customRentsTable = document.getElementById("rents-form");
    var carsForm = document.getElementById("cars-form");
    var usersForm = document.getElementById("users-form");
    var officeForm = document.getElementById("office-form");
    var officeTable = document.getElementById("office-table");
    officeForm.style.display = "none";
    officeTable.style.display = "none";

    userTable.style.display = "none";
    rentsTable.style.display = "none";
    customRentsTable.style.display = "none";
    usersForm.style.display = 'none';
    carTable.style.display = "inline";
    carsForm.style.display = 'inline'

}

function toggleReservationsCar() {
    var carTable = document.getElementById("carTable");
    var userTable = document.getElementById("userTable");
    var rentsTable = document.getElementById("myRentsTable");
    var rentsForm = document.getElementById("rents-form");
    var carsForm = document.getElementById("cars-form");
    var usersForm = document.getElementById("users-form");
    var officeForm = document.getElementById("office-form");
    var officeTable = document.getElementById("office-table");
    officeForm.style.display = "none";
    officeTable.style.display = "none";

    userTable.style.display = "none";
    carTable.style.display = "none";
    usersForm.style.display = 'none';
    rentsTable.style.display = "inline";
    rentsForm.style.display = "inline";
    carsForm.style.display = 'none';

}

function toggleUsersTable() {
    var carTable = document.getElementById("carTable");
    var userTable = document.getElementById("userTable");
    var rentsTable = document.getElementById("myRentsTable");
    var customRentsTable = document.getElementById("rents-form");
    var carsForm = document.getElementById("cars-form");
    var usersForm = document.getElementById("users-form");
    var officeForm = document.getElementById("office-form");
    var officeTable = document.getElementById("office-table");
    officeForm.style.display = "none";
    officeTable.style.display = "none";
    userTable.style.display = "inline";
    carTable.style.display = "none";
    rentsTable.style.display = "none";
    customRentsTable.style.display = "none";
    carsForm.style.display = 'none';
    usersForm.style.display = 'inline';
}
function toggleOfficeTable() {
    var carTable = document.getElementById("carTable");
    var userTable = document.getElementById("userTable");
    var rentsTable = document.getElementById("myRentsTable");
    var customRentsTable = document.getElementById("rents-form");
    var carsForm = document.getElementById("cars-form");
    var usersForm = document.getElementById("users-form");
    var officeForm = document.getElementById("office-form");
    var officeTable = document.getElementById("office-table");

    userTable.style.display = "none";
    carTable.style.display = "none";
    rentsTable.style.display = "none";
    customRentsTable.style.display = "none";
    carsForm.style.display = 'none';
    usersForm.style.display = 'none';
    officeForm.style.display = "inline";
    officeTable.style.display = "inline";

}

/////////////////////////
function deleteCar(carId) {
    // Assuming you want to confirm before deleting
    var confirmDelete = confirm("Are you sure you want to delete this car?");

    if (confirmDelete) {
        // Redirect the user to the delete endpoint with the carId as a parameter
        window.location.href = 'delete_car.php?carId=' + carId;
    } else {
        // The user canceled the deletion
        console.log("Deletion canceled.");
    }
}

function editCar(carId) {
    // Assuming you want to confirm before deleting
    var confirmEdit = confirm("Are you sure you want to edit this car?");

    if (confirmEdit) {
        // Redirect the user to the delete endpoint with the carId as a parameter
        window.location.href = 'edit_car.html?carId=' + carId;
    }
    else {
        // The user canceled the deletion
        console.log("Editing canceled.");
    }
}
/////////////////////////////////////////////////////////////////////////////////////////

function activateCar(carId) {
    var confirmActivate = confirm("Are you sure you want to Activate this car?");

    if (confirmActivate) {
        // Redirect the user to the delete endpoint with the carId as a parameter
        window.location.href = 'activate_car.php?carId=' + carId;
    }
    else {
        // The user canceled the deletion
        console.log("Activation canceled.");
    }

}

function deactivateCar(carId) {
    var confirmDectivate = confirm("Are you sure you want to dectivate this car?");

    if (confirmDectivate) {
        // Redirect the user to the delete endpoint with the carId as a parameter
        window.location.href = 'deactivate_car.php?carId=' + carId;
    }
    else {
        // The user canceled the deletion
        console.log("Deactivation canceled.");
    }

}


function returnCar(Id) {
    // Assuming you want to confirm before deleting
    var confirmReturn = confirm("Are you sure you want to return this car?");
    if (confirmReturn) {
        // Redirect the user to the delete endpoint with the carId as a parameter
        window.location.href = 'return_car_for_admin.php?Id=' + Id;
    } else {
        // The user canceled the deletion
        console.log("Return canceled.");
    }
}

function blockUser(user_id) {
    // Assuming you want to confirm before deleting
    var confirmReturn = confirm("Are you sure you want to block this user?");
    if (confirmReturn) {
        // Redirect the user to the delete endpoint with the carId as a parameter
        window.location.href = 'block_activate_user.php?user_id=' + user_id;
    } else {
        // The user canceled the deletion
        console.log("Blocking user canceled.");
    }
}
