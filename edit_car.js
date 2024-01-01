document.addEventListener('DOMContentLoaded', function () {
    var editForm = document.getElementById('edit_form');
    var carId = getCarIdFromUrl();

    if (carId) {
        // Append the carId to the form action URL
        editForm.action += '?carId=' + encodeURIComponent(carId);
    }

    function getCarIdFromUrl() {
        var urlParams = new URLSearchParams(window.location.search);
        return urlParams.get('carId');
    }
});