$(window).load(function() {
    console.log("It begins!");
    init();
    getBooks();
});

function init() {
    //$('.alert, .alert-danger').hide();
    $('#divModal').load('modal.html');
}

function getBooks() {
    $.ajax({
            url: 'getBooks.php',
            type: 'GET',
            dataType: 'json',
        })
        .done(function(data) {
            console.log("success");
            $.each(data, function(key, val) {
                var _table = $('#llistatLibres');
                var row;
                row += '<tr>';
                row += '<td>' + val.ID_LLIB + '</td>';
                row += '<td>' + val.TITOL + '</td>';
                row += '<td>';
                row += '<button type="button" class="btn btn-info btn-block" data-toggle="modal" data-target="#myModal" value=' + val.ID_LLIB + '><span class="glyphicon glyphicon-search"></span> Mostra</button>';
                row += '</td>';
                row += '</tr>'
                _table.append(row);
            });
            //Activam es botons
            $('.btn-info').click(showBook);
        })
        .fail(function() {
            console.log("error");
            $('.alert alert-danger').show();
        })
        .always(function() {
            console.log("complete");
        });
}

function showBook(e) {
    var ID_LLIB = $(this).attr("value");
    //$('#myModalLabel').text("");
}
