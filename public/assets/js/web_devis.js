var $collectionHolder;
var element = $("#estimate");

// setup an "add a detail" link
// var $addDetailButton = $('<button class="btn btn_block btn-sm btn-success" onclick="addNewDetail()"><span class="glyphicon glyphicon-plus"></span></button>');
// var $newLinkTr = $('<li></li>').append($addDetailButton);
var $newLinkLi = $('<li></li>');


function setActivityGroupOnNewLine(newLine, groupId) {
    $selectId = $(newLine).find('select').attr('id');
    if ($selectId.search('activityGroup') !== -1) {
        $('#' + $selectId).find('option').each(function () {
            if ($(this).attr('value') == groupId) {
                $(this).attr('selected', 'selected');
            }
        });
    }
    ;
}

function addDeleteLink($formLi) {
    var $removeFormButton = $('<a href="#" class="glyphicon glyphicon-minus" style="margin-left: 10px"></a>');
    // if (!$formLi.hasClass('.detail')) {
        $formLi.append($removeFormButton);
    // }

    $removeFormButton.on('click', function (e) {
        // remove the li for the detail form
        $formLi.remove();
        e.preventDefault();
        return;
    });
}

function removeLine(index) {
    // remove the li for the detail form
    $("#" + index).remove();
    $("#" + index).preventDefault();
    return;
}

function setCheckBoxDesabled(newLine, group) {

    $checkbox = $(newLine).find('input:checkbox').attr('id');

    if ($("#" + group).hasClass('isReferent')) {

        $('#' + $checkbox).attr('disabled', 'disabled');

    }

}

function selectDefault(newLine, group, profil, certaintyLevel) {

    let selects = $(newLine).find('select');
    let profilId = selects[1].id;
    let certaintyLevelId = selects[2].id;

    $('#' + profilId).find('option').each(function () {
        if ($(this).text() === profil) {
            $(this).attr('selected', 'selected');
        }
    });

    $('#' + certaintyLevelId).find('option').each(function () {
        if ($(this).text() === certaintyLevel) {
            $(this).attr('selected', 'selected');
        }
    });

}

function clickedCheckbox($checkbox) {
    $checkboxId = $($checkbox).attr('id');
    $sameIdLength = $checkboxId.length - ("automatic").length;
    $sameId = $checkboxId.substring(0, $sameIdLength);
    $(".embeddedForm").find("input[id ^= '" + $sameId + "']").each(function () {
        if ($checkbox[0].checked) {
            $(this).attr('readonly', 'readonly');
            $(this).css('background-color', $('body').css('background-color'));
        }
        else {
            $(this).removeAttr('readonly');
            $(this).css('background-color', '');
        }
    });
    $(".embeddedForm").find("select[id ^= '" + $sameId + "']").each(function () {
        if ($checkbox[0].checked) {
            $(this).attr('disabled', 'disabled');
            $(this).css('background-color', $('body').css('background-color'));
        }
        else {
            $(this).removeAttr('disabled');
            $(this).css('background-color', '');
        }
    });
}

function showHide(clicked) {

    $("ul.showhide").hide();

    if (clicked !== null) {
        let active = $(clicked).parent();
        let show = $(active).attr('id');

        $('ul.nav').children().removeClass('active');
        $(active).addClass('active');
        let ulShow = show.replace('nav', 'ul');
        $("#" + ulShow).show();
    }
    else {
        $("#nav_inchargepersons").addClass('active');
        $("#ul_inchargepersons").show();
    }
}

function line(listId) {
    let ulId = "#ul_" + listId;

    lineInUl(ulId);
    addNewLine(listId, null, null, null);
}

function hideEmbeddedEntityName() {
    $('#actions').find('label').each(function () {
        $(this).css('display', 'none');
    });
}

function addNewLine(group, groupId, profil, certaintyLevel) {

    // Get the data-prototype explained earlier
    var prototype = $collectionHolder.data('prototype');

    // get the new index
    var index = $collectionHolder.data('index');

    var newForm = prototype;
    // You need this only if you didn't set 'label' => false in your tags field in TaskType
    // Replace '__name__label__' in the prototype's HTML to
    // instead be a number based on how many items we have
    newForm = newForm.replace(/__name__label__/g, 'Ligne n°' + (index + 1));

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    newForm = newForm.replace(/__name__/g, index);
    // increase the index with one for the next item
    $collectionHolder.data('index', index + 1);

    // Display the form in the page in a li, after the "Add a detail" link li
    var $newFormLi = $('<li class="row"></li>').append(newForm);

    $collectionHolder.find('div').each(function () {
        $(this).removeAttr('autofocus');
    })

    if (group == null) {
        $collectionHolder.append($newFormLi);
        addDeleteLink($newFormLi);
    }
    else {
        $("#" + group).append($newFormLi);
        $("#" + group).addClass('in');
        // Sélection de la valeur activityGroup du groupe
        setActivityGroupOnNewLine($newFormLi, groupId);

        // Setting checkbox invisible for Réalisation
        setCheckBoxDesabled($newFormLi, group);

        // Dans une Réalisation, Profil = 'Développeur Back' et Certitude = 'Très Certain'
        selectDefault($newFormLi, group, profil, certaintyLevel);
    }

    // add a delete link to the new form
    addDeleteLink($newFormLi);
}

function lineInUl(ulId) {
    // Get the ul that holds the collection of tags
    $collectionHolder = $(ulId);

    // add the "add a line" anchor and li to the details ul
    $collectionHolder.before($newLinkLi);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionHolder.data('index', $collectionHolder.find(':input').length);


    // Dans embeddedForm : gestion de l'accessibilité des zones de saisie
    $collectionHolder.find('input[type=checkbox]').each(function () {
        clickedCheckbox($(this));
    });

    // Dans header_form : Affiche le total d'un groupe au dessus de la liste du groupe
    $collectionHolder.find('div.groupTotal').each(function () {
        totalId = $(this).attr('id');
        totalId = "show" + totalId;
        $('#' + totalId).html($(this).html());
        $(this).remove();
    });

    // Dans header_edit : Affiche le total du devis au dessus des lignes du devis
    $('#globalShowTotal').html($('#globalTotal').html());
    $('#globalTotal').remove();
}

function generateEstimate(estimateTitle, id) {

    html2canvas(document.getElementById('estimate'), {
        html2canvas: {dpi: 160, logging: true},
        image: {type: 'png', quality: 1}
    }).then(function (canvas) {
        // Export the canvas to its data URI representation
        var base64image = canvas.toDataURL("image/jpeg", 1.0);

        // Open the image in a new window
        // window.open(base64image, "_blank");

        let name = estimateTitle + id + '.jpeg';

        // download(base64image, name);
        var link = document.createElement("a");

        link.download = name;
        link.href = base64image;
        document.body.appendChild(link);
        link.click();
    });

}

function linkUnlink(id, group1, group2) {
    let parentId = $("#" + id).parent().attr('id');
    let parent1 = $(group1).attr('id');
    let list1 = parent1.substring(3, parent1.length) + '[]';
    let parent2 = $(group2).attr('id');
    let list2 = parent2.substring(3, parent2.length) + '[]';
    let copyOfThis = $("#" + id);

    if ($(group1).attr('id') == parentId) {
        $(copyOfThis).children().attr('name', list2);
        $("#" + parent2).prepend(copyOfThis);
    }
    else {
        $(copyOfThis).children().attr('name', list1);
        $("#" + parent1).prepend(copyOfThis);
    }
    $(this).remove();
}

$(document).ready(function () {

// Datatable en français
    $('#headerList').DataTable({
        ordering: false,
        "language": {
            "lengthMenu": "Afficher _MENU_ lignes par page",
            "zeroRecords": "Rien à afficher",
            "info": "Page _PAGE_ sur _PAGES_",
            "infoEmpty": "Aucun devis trouvé",
            "infoFiltered": "(recherche portant sur _MAX_ devis répondant aux cirtères de filtre)",
            "decimal": ",",
            "thousand": ".",
            "search": "Recherche",
            "paginate": {
                "first": "Première",
                "last": "Dernière",
                "next": "Suivante",
                "previous": "Précédente"
            }
        },
        "drawCallback" : function(settings) {

            let index = $('#indexId').attr('value');

            $('a.index'+index).contextmenu(function(e) {
                e.preventDefault();

                let id = $(this).closest('tr').attr('id');

                if(index == 2) {
                    $("<div class='menuContextuel c2'>" +
                        "<div class='divContextuel'><i style='margin-right: 10px;' class=\"far fa-envelope\"></i><a id='contextuelEnvoyerDevis' target='_blank' href="+routes.header_send.replace('_id_', id)+" class='aContext' >Envoyer le Devis</a></div>" +
                        "<div class='divContextuel'><i style='margin-right: 10px;' class=\"far fa-trash-alt\"></i><a class='aContext' href="+routes.header_delete.replace('_id_', id)+">Supprimer le Devis</a></div>" +
                        "<div class='divContextuel'><i style='margin-right: 10px;' class=\"far fa-eye\"></i><a class='aContext' href="+routes.header_show.replace('_id_', id)+">Aperçu</a></div>" +
                        "</div>").appendTo("body").css({top: e.pageY + 'px', left: e.pageX + 'px'});
                } else if(index == 3) {
                    $("<div class='menuContextuel c3'>" +
                        "<div class='divContextuel'><i style='margin-right: 10px;' class=\"far fa-window-restore\"></i><a class='aContext' href="+routes.header_reactivate.replace('_id_', id)+">Réactiver</a></div>" +
                        "<div class='divContextuel'><i style='margin-right: 10px;' class=\"far fa-eye\"></i><a class='aContext' href="+routes.header_show.replace('_id_', id)+">Aperçu</a></div>" +
                        "</div>").appendTo("body").css({top: e.pageY + 'px', left: e.pageX + 'px'});
                } else if(index == 4) {
                    $("<div class='menuContextuel c4'>" +
                        "<div class='divContextuel'><i style='margin-right: 10px;' class=\"far fa-check-square\"></i><a class='aContext' href="+routes.header_accept.replace('_id_', id)+">Accepter</a></div>" +
                        "<div class='divContextuel'><i style='margin-right: 10px;' class=\"far fa-times-circle\"></i><a class='aContext' href="+routes.header_refuse.replace('_id_', id)+">Refuser</a></div>" +
                        "<div class='divContextuel'><i style='margin-right: 10px;' class=\"far fa-edit\"></i><a class='aContext' href="+routes.header_version.replace('_id_', id)+">Réviser</a></div>" +
                        "<div class='divContextuel'><i style='margin-right: 10px;' class=\"far fa-eye\"></i><a class='aContext' href="+routes.header_show.replace('_id_', id)+">Aperçu</a></div>" +
                        "</div>").appendTo("body").css({top: e.pageY + 'px', left: e.pageX + 'px'});
                } else if(index == 5) {
                    $("<div class='menuContextuel c5'>" +
                        "<div class='divContextuel'><i style='margin-right: 10px;' class=\"fas fa-dolly\"></i><a class='aContext' href="+routes.header_deliver.replace('_id_', id)+">Livrer les Travaux</a></div>" +
                        "<div class='divContextuel'><i style='margin-right: 10px;' class=\"far fa-eye\"></i><a class='aContext' href="+routes.header_show.replace('_id_', id)+">Aperçu</a></div>" +
                        "</div>").appendTo("body").css({top: e.pageY + 'px', left: e.pageX + 'px'});
                } else if(index == 6) {
                    $("<div class='menuContextuel c6'>" +
                        "<div class='divContextuel'><i style='margin-right: 10px;' class=\"far fa-eye\"></i><a class='aContext' href="+routes.header_show.replace('_id_', id)+">Aperçu</a></div>" +
                        "</div>").appendTo("body").css({top: e.pageY + 'px', left: e.pageX + 'px'});
                } else if(index == 7) {
                    $("<div class='menuContextuel c7'>" +
                        "<div class='divContextuel'><i style='margin-right: 10px;' class=\"fas fa-file-invoice-dollar\"></i><a class='aContext' href="+routes.header_bill.replace('_id_', id)+">Envoyer la Facture</a></div>" +
                        "</div>").appendTo("body").css({top: e.pageY + 'px', left: e.pageX + 'px'});
                } else if(index == 8) {
                    $("<div class='menuContextuel c8'>" +
                        "<div class='divContextuel'><i style='margin-right: 10px;' class=\"far fa-eye\"></i><a class='aContext' href="+routes.header_show.replace('_id_', id)+">Aperçu</a></div>" +
                        "</div>").appendTo("body").css({top: e.pageY + 'px', left: e.pageX + 'px'});
                }

                $('#contextuelEnvoyerDevis').click(function () {
                    window.location = routes.header_step4.replace('_id_', id);
                })

            });

        }
    });

    $(document).mousedown(function (e) {
        if (!$(e.target).parents('.menuContextuel').length > 0) {
            $('.menuContextuel').remove();
        }
    });

    $('#envoyerDevis').click(function() {

        let href = $(this).attr('href');

        let id2 = href.replace('/header/', '');

        let id3 = id2.replace('/send', '');

        window.location = routes.header_step4.replace('_id_', id3);
    })

    // Pour la gestion des lignes form embarqué
    lineInUl('ul.embeddedForm');

    // add a delete link to all of the existing tag form li elements
    $collectionHolder.find('li').each(function () {
        if (!$(this).hasClass('undeletable')) {
            addDeleteLink($(this));
        }
    });


    // Embarquer dans le formulaire la veleur des listes "select" pour les lignes "automatic"
    $('form').submit(function (event) {
        $('select').removeAttr('disabled');
    });

    $('.embeddedForm').find('.disabled').each(function () {
        $(this).find('select').each(function () {
            $(this).attr('disabled', 'disabled');
            $(this).css('background-color', $('body').css('background-color'));
        })
    });

    showHide(null);

    if (typeof(TRIGER_APP) !== "undefined" && TRIGER_APP) {
        $('#nav_applications').find('a').trigger('click');
    }

    hideEmbeddedEntityName();
});