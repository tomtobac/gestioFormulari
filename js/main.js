$(window).load(function() {
    //console.log("It begins!");
    init();
    getBooks();
});

function init() {
    //$('.alert, .alert-danger').hide();
    $('#divModal').load('modal.html');
    console.log($('#botoModal'));
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
            //console.log("success");
            //console.log($(data.LLIBRE));
            cleanFormData();
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
                    $('#collecio option:last').attr("selected", "selected");
                }
            });
            $.each(data.DEPARTAMENTS, function(index, el) {
                $('#Departament')
                    .append($("<option></option>")
                        .attr("value", el.DEPARTAMENT)
                        .text(el.DEPARTAMENT));
                if (data.LLIBRE[0].FK_DEPARTAMENT != null && data.LLIBRE[0].FK_DEPARTAMENT == el.DEPARTAMENT) {
                    $('#Departament option:last').attr("selected", "selected");
                }
            });
            $.each(data.EDITORS, function(index, el) {
                $('#Editorial')
                    .append($("<option></option>")
                        .attr("value", el.ID_EDIT)
                        .text(el.NOM_EDIT));
                if (data.LLIBRE[0].FK_IDEDIT != null && data.LLIBRE[0].FK_IDEDIT == el.ID_EDIT) {
                    $('#Editorial option:last').attr("selected", "selected");
                }
            });
            $.each(data.LLENGUES, function(index, el) {
                $('#Llengua')
                    .append($("<option></option>")
                        .attr("value", el.LLENGUA)
                        .text(el.LLENGUA));
                if (data.LLIBRE[0].FK_LLENGUA != null && data.LLIBRE[0].FK_LLENGUA == el.LLENGUA) {
                    $('#Llengua option:last').attr("selected", "selected");
                }
            });
            $.each(data.AUTORS, function(index, el) {
                var _table = $('#autorsModal');
                var row;
                row += '<tr>';
                row += '<td>' + el.ID_AUT + '</td>';
                row += '<td>' + el.NOM_AUT + '</td>';
                row += '<td>' + el.DNAIX_AUT + '</td>';
                row += '<td>' + el.FK_NACIONALITAT + '</td>';
                row += '<td>';
                row += '<button type="button" class="btn btn-danger btn-block" value=' + el.ID_AUT + '><span class="glyphicon glyphicon-trash"></span> Borrar</button>';
                row += '</td>';
                row += '</tr>'
                _table.append(row);
            });
            $.each(data.EXEMPLARS, function(index, el) {
                var _table = $('#exemplarsModals');
                var row;
                row += '<tr>';
                row += '<td>' + el.NUM_EXM + '</td>';
                row += '<td>' + el.NREG + '</td>';
                row += '<td>' + el.DATALTA_EXM + '</td>';
                row += '<td>' + el.FK_UBICEXM + '</td>';
                row += '<td>';
                row += '<button type="button" class="btn btn-danger btn-block" value=' + el.NREG + '><span class="glyphicon glyphicon-trash"></span> Borrar</button>';
                row += '</td>';
                row += '</tr>'
                _table.append(row);
            });
            blockStuff(true);

            $('#botoModal123').off("click").text("Editar");
            $('#botoModal123').on("click", function() {
                blockStuff(false);
                $(this).text('Guardar');
                $(this).off("click").on("click", function() {
                    saveDataForm();
                });
            });

        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });
}

function cleanFormData() {
    $('#formLlibre').trigger("reset");
    $('option').remove();
    $('#myModal td').remove();
}

function blockStuff(value) {
    $("#myModal input, textarea, select").prop("disabled", value);
    $(".btn-danger").prop("disabled", value);
}

function saveDataForm() {
	console.log("success");
    console.log($('#formLlibre').serialize());
}
