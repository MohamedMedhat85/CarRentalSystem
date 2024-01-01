// script.js

////////
document.addEventListener('DOMContentLoaded', function () {
    // Hide the buttons initially
    var allStatusElements = document.querySelectorAll('.car-status');
    var allActivateButtons = document.querySelectorAll('.rent');

    for (var i = 0; i < allStatusElements.length; i++) {
        var carStatus = allStatusElements[i].innerHTML.trim().toLowerCase();
        if (carStatus == 'active') {
            allActivateButtons[i].style.display = 'inline';
        } else {
            // Handle other statuses if needed
            allActivateButtons[i].style.display = 'none';

        }
    }
});


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

/////////////
function toggleCarTable() {
    var carTable = document.getElementById("carTable");
    var rentsTable = document.getElementById("myRentsTable");
    var form = document.getElementById("form");
    form.style.display = "inline";

    carTable.style.display = "table";
    rentsTable.style.display = "none";
}

function toggleMyRents() {
    var carTable = document.getElementById("carTable");
    var rentsTable = document.getElementById("myRentsTable");
    var form = document.getElementById("form");
    form.style.display = "none";

    carTable.style.display = "none";
    rentsTable.style.display = "table";
}
/////////////

/////////////

function rentCar(carId) {
    // Assuming you want to confirm before deleting
    var confirmDelete = confirm("Are you sure you want to rent this car?");
    if (confirmDelete) {
        // Redirect the user to the delete endpoint with the carId as a parameter
        window.location.href = 'rent_car.php?carId=' + carId;
    } else {
        // The user canceled the deletion
        console.log("Rented canceled.");
    }
}

function returnCar(Id) {
    // Assuming you want to confirm before deleting
    var confirmReturn = confirm("Are you sure you want to return this car?");
    if (confirmReturn) {
        // Redirect the user to the delete endpoint with the carId as a parameter
        window.location.href = 'return_car.php?Id=' + Id;
    } else {
        // The user canceled the deletion
        console.log("Return canceled.");
    }
}