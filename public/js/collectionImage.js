$('#add_image').click(function(){
    //récupérer le numéro des futurs champs que je veux créer
    const index = +$('#widgets_counter').val();

    //Je récupère le prototype des entrées et je remplace le __name__ par l'index à l'aide de la regex ci-dessous
    const tmpl = $('#ad_images').data('prototype').replace(/__name__/g, index);

    // J'injecte ce code au sein de la div
    $('#ad_images').append(tmpl);

    $('#widgets_counter').val(index + 1);

    //je gere le bouton supprimer
    handleDeleteButtons();

});

function handleDeleteButtons(){
    $('button[data-action="delete"]').click(function(){
        const target = this.dataset.target;

        $($(target)).remove();
    });
}

//Editer le counterWidgets pour qu'il prennent le nombres de sous formulaires
function editCounterWidgets(){
    nbWidgets = $('#ad_images div.form-group').length;

    $('#widgets_counter').val(nbWidgets);
}

editCounterWidgets();

//Pour pouvoir etre appelé des le chargement de la page
handleDeleteButtons();
