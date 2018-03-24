$(document).ready(function () {
    $.getJSON("php/getBrand.php", success = function (data) {
        var options = "";
        for (var i = 0; i < data.length; i++) {
            options += "<option Value='" + (i + 1) + "'>" + data[i] + "</option>";
        }
        console.log(options);
        $('#selectBrand').append(options);
        $('#selectBrand').change();
    });
    $('#selectBrand').change(function () {
        var options = "";
        $.getJSON("php/getMed.php?brand=" + $(this).val(), success = function (data) {

            for (var i = 0; i < data.length; i++) {
                options += "<option value='" + data[i] + "'>" + data[i] + "</option>";
            }
            $('#selectProduct').html("");
            $('#selectProduct').append(options);
        });
    });

});
