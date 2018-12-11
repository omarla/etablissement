toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": false,
    "progressBar": true,
    "positionClass": "toast-top-full-width",
    "preventDuplicates": false,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
}

$(document).ready(function () {
    $('#data-table').DataTable();

    $('.data-table').each(function (index) {
        $(this).DataTable();
    })



});

function setDataListItems(datalist, data, valueName, htmlTextName) {
    data = JSON.parse(data);

    let i = 0;

    datalist.empty();

    while (i < MAX_OPTIONS && i < data.length) {
        datalist.append(
            `<option value='${data[i][valueName]}'>${data[i][htmlTextName]}</option>`
        );
        i++;
    }
}

var initVars = {
    url: {
        module: (new URL(window.location.href)).searchParams.get('module'),
        type: (new URL(window.location.href).searchParams.get('type')) || '',
        action: (new URL(window.location.href).searchParams.get('action'))
    }
};