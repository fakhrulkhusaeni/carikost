$(document).ready(function () {
    $("#btn-bayar").on("click", function (e) {
        snap.pay(midtransToken, {
            onSuccess: function (result) {
                console.log("Payment Success:", result);
            },
            onPending: function (result) {
                console.log("Payment Pending:", result);
            },
            onError: function (result) {
                console.log("Payment Failed:", result);
            },
            onClose: function () {
                console.log("Payment popup closed");
            },
        });
    });
});
