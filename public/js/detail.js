$(document).ready(function () {
    const date = new Date();
    const formattedDate = date.toISOString().split("T")[0];
    $("#booking-date").attr("min", formattedDate);
});
