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
            //console.log("success");
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
            //console.log("error");
            $('.alert alert-danger').show();
        })
        .always(function() {
            //console.log("complete");
        });
}

function showBook(e) {
    var ID_LLIB = $(this).attr("value");
    //$('#myModalLabel').text("");
    getDataBook(ID_LLIB);
}

function getDataBook(ID_LLIBRE) {
    $.ajax({
            url: 'getDataBook.php',
            type: 'GET',
            dataType: 'json',
            data: { ID_LLIB: ID_LLIBRE },
        })
        .done(function(data) {
            console.log("success");
            console.log($(data));
            $.each(data.LLIBRE, function(index, el) {
                $('#CodiLlibre').val(el.ID_LLIB);
                $('#Titol').val(el.TITOL || '');
                $('#NumEdicio').val(el.NUMEDICIO || '');
                $('#AnyEdicio').val(el.ANYEDICIO || '');
                $('#Descripcio').val(el.DESCRIP_LLIB || '');
                $('#ISBN').val(el.ISBN || '');
                $('#DepositLegal').val(el.DEPLEGAL || '');
                $('#SigTop').val(el.SIGNTOP || '');
                console.log(el.FK_COLLECCIO);
            });
            $.each(data.COLLECCIONS, function(index, el) {
                //  <option value="1">Option one</option>
                $('#collecio')
                    .append($("<option></option>")
                        .attr("value", el.COLLECCIO)
                        .text(el.COLLECCIO));
                if (data.LLIBRE[0].FK_COLLECCIO != null && data.LLIBRE[0].FK_COLLECCIO == el.COLLECCIO) {
                	$('#collecio option:last').attr("selected","selected");
                }
            });

        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });

}
