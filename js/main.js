/*
 * GLOBALS!!
 */
var darreresDades = "";
$(window).load(function() {
    //console.log("It begins!");
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
    }).done(function(data) {
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
    }).fail(function() {
        //console.log("error");
        $('.alert alert-danger').show();
    }).always(function() {
        //console.log("complete");
    });
}

function showBook(e) {
    var ID_LLIB = $(this).attr("value");
    //$('#myModalLabel').text("");
    getDataBook(ID_LLIB);
}

function getDataBook(ID_LLIBRE) {
    cleanFormData();
    $.ajax({
        url: 'getDataBook.php',
        type: 'GET',
        dataType: 'json',
        data: {
            ID_LLIB: ID_LLIBRE
        },
    }).done(function(data) {
        //console.log("success");
        //console.log($(data.LLIBRE));
        darreresDades = data;
        $.each(data.LLIBRE, function(index, el) {
            $('#CodiLlibre').val(el.ID_LLIB);
            $('#Titol').val(el.TITOL || '');
            $('#NumEdicio').val(el.NUMEDICIO || '');
            $('#AnyEdicio').val(el.ANYEDICIO || '');
            $('#Descripcio').val(el.DESCRIP_LLIB || '');
            $('#ISBN').val(el.ISBN || '');
            $('#DepositLegal').val(el.DEPLEGAL || '');
            $('#SigTop').val(el.SIGNTOP || '');
        });
        // $.each(data.COLLECCIONS, function(index, el) {
        //     //  <option value="1">Option one</option>
        //     $('#collecio').append($("<option></option>").attr("value", el.COLLECCIO).text(el.COLLECCIO));
        //     if (data.LLIBRE[0].FK_COLLECCIO != null && data.LLIBRE[0].FK_COLLECCIO == el.COLLECCIO) {
        //         $('#collecio option:last').attr("selected", "selected");
        //     }
        // });
        $('#collecio123').autocomplete({
            source: "autoCompleteColleccio.php",
            minLength: 2
        });
        $("#collecio123").autocomplete("option", "appendTo", "#formLlibre");
        $("#collecio123").val(data.LLIBRE[0].FK_COLLECCIO);

        $.each(data.DEPARTAMENTS, function(index, el) {
            $('#Departament').append($("<option></option>").attr("value", el.DEPARTAMENT).text(el.DEPARTAMENT));
            if (data.LLIBRE[0].FK_DEPARTAMENT != null && data.LLIBRE[0].FK_DEPARTAMENT == el.DEPARTAMENT) {
                $('#Departament option:last').attr("selected", "selected");
            }
        });
        $.each(data.EDITORS, function(index, el) {
            $('#Editorial').append($("<option></option>").attr("value", el.ID_EDIT).text(el.NOM_EDIT));
            if (data.LLIBRE[0].FK_IDEDIT != null && data.LLIBRE[0].FK_IDEDIT == el.ID_EDIT) {
                $('#Editorial option:last').attr("selected", "selected");
            }
        });
        $.each(data.LLENGUES, function(index, el) {
            $('#Llengua').append($("<option></option>").attr("value", el.LLENGUA).text(el.LLENGUA));
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
            row += '<td class=\'taulaEditar\'>';
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
            row += '<td class=\'taulaEditar\'>';
            row += '<button type="button" class="btn btn-danger btn-block" value=' + el.NUM_EXM + '><span class="glyphicon glyphicon-trash"></span> Borrar</button>';
            row += '</td>';
            row += '</tr>'
            _table.append(row);
        });
        afterLoadBook();
    }).fail(function() {
        console.log("error");
    }).always(function() {
        //console.log("complete");
    });
}

function afterLoadBook() {
    blockStuff(true);
    $('#botoModal123').off("click").text("Editar");
    $('#botoModal123').on("click", function() {
        buttonEditar();
    });
    $('#autorsModal button').click(function() {
        var FK_IDAUT = $(this).val();
        var FK_IDLLIB = $('#CodiLlibre').val();
        //console.log("FK_IDAUT: " + FK_IDAUT + "\nFK_IDLLIB: " + FK_IDLLIB);
        deleteAutor(FK_IDLLIB, FK_IDAUT);
    });
    $('#exemplarsModals button').click(function() {
        var NUM_EXM = $(this).val();
        var FK_IDLLIB = $('#CodiLlibre').val();
        deleteExemplar(FK_IDLLIB, NUM_EXM);
    });
}

function cleanFormData() {
    $('#formLlibre').trigger("reset");
    $('option').remove();
    $('#myModal td').remove();
    $('.alert').hide();
    $('#afegirAutorNou').hide();
}

function blockStuff(value) {
    $("#myModal input, textarea, select").prop("disabled", value);
    $(".btn-danger").prop("disabled", value);
    $('.taulaEditar').hide();
}

function saveDataForm() {
    //Validarem el formulari: Els camps obligatoris seran títol i any edició. Any edició ha d'esser numèric.
    $.each($('.important'), function(index, el) {
        if (!$(el).val()) {
            $(el).parent().addClass("has-error");
        } else {
            $(el).parent().removeClass("has-error");
        }
    });
    if ($('.has-error').length == 0) {
        updateBook($('#formLlibre').serialize());
    } else {
        console.log("Hi ha errors.");
    }
}

function updateBook(info) {
    $.ajax({
        url: 'setDataBook.php',
        type: 'GET',
        dataType: 'html',
        data: info,
    }).done(function(data) {
        $('#formAlert').html(data).show();
        $("#myModal").animate({
            scrollTop: 0
        }, "slow");
    }).fail(function() {}).always(function() {});
}

function deleteAutor(FK_IDLLIB, FK_IDAUT) {
    $.ajax({
        url: 'delDataBook.php',
        type: 'GET',
        dataType: 'html',
        data: {
            id_llib: FK_IDLLIB,
            id_autor: FK_IDAUT
        },
    }).done(function(data) {
        $('#autorsModal button[type="button"][value="' + FK_IDAUT + '"]').parent().parent().remove();
        $('#autorsAlert').html(data).show();
        /*
        $("#myModal").animate({
        scrollTop: 0
        }, "slow");
        */
    }).fail(function() {
        console.log("error");
    }).always(function() {});
}

function deleteExemplar(FK_IDLLIB, NUM_EXM) {
    $.ajax({
        url: 'delDataBook.php',
        type: 'GET',
        dataType: 'html',
        data: {
            id_llib: FK_IDLLIB,
            num_exm: NUM_EXM
        },
    }).done(function(data) {
        var actual = $('#exemplarsModals button[type="button"][value="' + NUM_EXM + '"]').parent().parent()
        var anterior = actual.prev().children("td:first").text();
        actual.remove();
        $('#exemplarsAlert').html(data).show();
        /*
        $("#myModal").animate({
        scrollTop: 300
        }, "slow");
        /*
        * Actualitzam l'input d'Exemplar per afegir un nou exemplar.
        */
        $.isNumeric(anterior) ? anterior++ : 1;
        //console.log(anterior);
        //console.log(lastExemplar);
        //lastExemplar++;
        $('#exemplarsModals input:first').val(anterior);
    }).fail(function() {
        console.log("error");
    }).always(function() {});
}

function buttonEditar() {
    $('#afegirAutorNou').show();
    $('#autorsModal tr:last').after('<tr><td colspan="4"><input value="1" type="number" name="nouAutor" id="afegirAutorHidden" hidden></input><input id="afegirAutor" class="form-control"></input></td><td class><button type="submit" class="btn btn-success btn-block"><span class="glyphicon glyphicon-plus"></span> Afegir</button></td></tr>');

    /*
    $.each(darreresDades.NOUSAUTORS, function(index, el) {
        $('#afegirAutor').append($("<option></option>").attr("value", el.ID_AUT).text(el.NOM_AUT));
    });
    */

    $('#afegirAutor').autocomplete({
        source: "autoCompleteAutors.php",
        minLength: 2,
        select: function (event, ui) {
            idAutor = ui.item.id;
            //console.log(idAutor);
            $("#afegirAutorHidden").val(idAutor);
        }
    });
    $("#afegirAutor").autocomplete("option", "appendTo", "#autorsModal");



    var lastExemplar = $('#exemplarsModals tr:last td:first').text() || 0;
    lastExemplar++;
    $('#exemplarsModals tr:last').after('<tr><td><fieldset disabled><input type="number" value=' + lastExemplar + ' class="form-control"></fieldset></td><td><input type="number" class="form-control"></td><td><input type="date" class="form-control"></td><td><input type="text" class="form-control"></td><td class><button type="submit" class="btn btn-success btn-block"><span class="glyphicon glyphicon-plus"></span> Afegir</button></td></tr>');
    $('#autorsModal .btn-success').click(function() {
        var FK_IDAUT = $("#afegirAutorHidden").val();
        var FK_IDLLIB = $('#CodiLlibre').val();
        var NOM_AUT = $('#afegirAutor').val();
        console.log("send!");
        addAutor(FK_IDLLIB, FK_IDAUT, NOM_AUT);
    });
    $('#exemplarsModals .btn-success').click(function() {
        var FK_IDLLIB = $('#CodiLlibre').val();
        var NUM_EXM = $('#exemplarsModals input:first').val();
        var NREG = $('#exemplarsModals [type="number"]:last').val();
        var DATALTA_EXM = $('#exemplarsModals [type="date"]').val();
        var FK_UBICEXM = $('#exemplarsModals [type="text"]').val();
        //console.log("Exemplar: " + exemplar + "\nNºRegistre: " + nRegistre + "\nData: " + data + "\nUbicació: " + ubicacio);
        addExemplar(FK_IDLLIB, NUM_EXM, NREG, FK_UBICEXM, DATALTA_EXM);
    });
    blockStuff(false);
    $('.taulaEditar').show();
    $('#botoModal123').text('Guardar');
    $('#botoModal123').off("click").on("click", function() {
        saveDataForm();
        $('.alert').hide();
    });
    $('#afegirNovaColleccio').click(function(e) {
        var aux = $.trim($('#NovaCollecio').val());
        if (aux.length > 0) {
            addNovaColleccio(aux);
        }
        return false;
    });

    $('#enviarNouAutor').off("click").on("click", function() {
        var x = $('#afegirAutorNou').serialize();
        addAutorNou(x);
        return false;
    });
}

function addAutor(FK_IDLLIB, FK_IDAUT, NOM_AUT) {
    $.ajax({
        url: 'addDataBook.php',
        type: 'GET',
        dataType: 'html',
        data: {
            id_llib: FK_IDLLIB,
            id_autor: FK_IDAUT
        },
    }).done(function(data) {
        //Afegir nou tr>td amb ses dades
        //console.log(darreresDades);
        // $.each(darreresDades.NOUSAUTORS, function(index, el) {
        //     if (el.ID_AUT == FK_IDAUT) {
                //console.log("found it!");
                var taula = $('#autorsModal .btn-success').parent().parent().prev();
                var row;
                row += '<tr>';
                row += '<td>' + FK_IDAUT + '</td>';
                row += '<td>' + NOM_AUT + '</td>';
                row += '<td> - </td>';
                row += '<td> - </td>';
                row += '<td class=\'taulaEditar\'>';
                row += '<button type="button" class="btn btn-danger btn-block" value=' + FK_IDAUT + '><span class="glyphicon glyphicon-trash"></span> Borrar</button>';
                row += '</td>';
                row += '</tr>'
                taula.after(row);
                //console.log(row);
        //     }
        // });
        $('#autorsModal button').click(function() {
            var FK_IDAUT = $(this).val();
            var FK_IDLLIB = $('#CodiLlibre').val();
            //console.log("FK_IDAUT: " + FK_IDAUT + "\nFK_IDLLIB: " + FK_IDLLIB);
            deleteAutor(FK_IDLLIB, FK_IDAUT);
        });
        //
        $('#autorsAlert').html(data).show();
        /*$("#myModal").animate({
        scrollTop: 0
        }, "slow");
        */
    }).fail(function() {
        console.log("error");
    }).always(function() {});
}

function addExemplar(FK_IDLLIB, NUM_EXM, NREG, FK_UBICEXM, DATALTA_EXM) {
    $.ajax({
        url: 'addDataBook.php',
        type: 'GET',
        dataType: 'html',
        data: {
            id_llib: FK_IDLLIB,
            num_exm: NUM_EXM,
            nreg: NREG,
            data: DATALTA_EXM,
            fk_ubicexm: FK_UBICEXM
        },
    }).done(function(data) {
        //Afegir nou tr>td amb ses dades
        //console.log(darreresDades);
        //isset($id_llib) && isset($num_exm) && isset($nreg) && isset($data) && isset($fk_ubicexm)
        //console.log("found it!");
        var taula = $('#exemplarsModals .btn-success').parent().parent().prev();
        var row;
        row += '<tr>';
        row += '<td>' + NUM_EXM + '</td>';
        row += '<td>' + NREG + '</td>';
        row += '<td>' + DATALTA_EXM + '</td>';
        row += '<td>' + FK_UBICEXM + '</td>';
        row += '<td class=\'taulaEditar\'>';
        row += '<button type="button" class="btn btn-danger btn-block" value=' + NUM_EXM + '><span class="glyphicon glyphicon-trash"></span> Borrar</button>';
        row += '</td>';
        row += '</tr>'
        taula.after(row);
        $('#exemplarsModals button').click(function() {
            var NUM_EXM = $(this).val();
            var FK_IDLLIB = $('#CodiLlibre').val();
            deleteExemplar(FK_IDLLIB, NUM_EXM);
        });
        $('#exemplarsModals input:first').val(parseInt(NUM_EXM) + 1);
        $('#exemplarsAlert').html(data).show();
        /*$("#myModal").animate({
        scrollTop: 0
        }, "slow");
        */
    }).fail(function() {
        console.log("error");
    }).always(function() {});
}

function addNovaColleccio(NovaCollecio) {
    $.ajax({
            url: 'addDataBook.php',
            type: 'GET',
            dataType: 'html',
            data: { nova_colleccio: NovaCollecio },
        })
        .done(function(data) {
            //console.log("success");
            $('#novaColleccioAlert').html(data).show();
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });
}


function addAutorNou(PARAM) {
    $.ajax({
        url: 'addAutor.php',
        type: 'GET',
        dataType: 'html',
        data: PARAM,
    }).done(function(data) {
        console.log(data);
        $('#autorsAlert').html(data).show();
    }).fail(function() {
        console.log("error");
    }).always(function() {});
}
