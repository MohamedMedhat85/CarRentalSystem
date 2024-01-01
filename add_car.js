const addCar = document.getElementById("add-car-form");

document.addEventListener('DOMContentLoaded', function () {
    var currentURL = window.location.href
    var check = 'invalid-officeId';
    if (currentURL.indexOf(check) !== -1) {
        const Office = document.getElementById("office_id");
        Office.placeholder = "The Office ID you entered doesn't exist";
    }



});
addCar.addEventListener("submit", function (event1) {
    validateAndNavigate(event1);
});

function validateAndNavigate(event1) {
    const carModel = document.getElementById("car_model");
    const Year = document.getElementById("year");
    const PlateId = document.getElementById("plate_id");
    const Image = document.getElementById("car_iamge");
    const Price = document.getElementById("car_price");
    const Office = document.getElementById("office_id");

    if (carModel.value.trim() === "") {
        event1.preventDefault();
        carModel.placeholder = "Please Enter The Car Model";
    }
    if (Year.value.trim() === "") {
        event1.preventDefault();
        Year.placeholder = "Please Enter The Year";
    }
    if (PlateId.value.trim() === "") {
        event1.preventDefault();
        PlateId.placeholder = "Please Enter The Plate ID";
    }
    if (Image.value.trim() === "") {
        event1.preventDefault();
        Image.placeholder = "Please Enter Your Image URL";

    }
    if (Price.value.trim() === "") {
        event1.preventDefault();
        Price.placeholder = "Please Enter The Price";
    }
    if (Office.value.trim() === "") {
        event1.preventDefault();
        Office.placeholder = "Please Enter The Office ID";
    }
}

