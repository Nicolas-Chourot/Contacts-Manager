<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contacts manager</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <!-- Style pour les infobulles -->
    <link rel="stylesheet" href="css/tooltip.css">

    <!-- Style pour l'interface et la liste des contacts -->
    <link rel="stylesheet" href="css/contactManagerLayout.css">

    <!-- pour la dialogue de confirmation de retrait d'un contact -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">

    <!-- lien vers le favicon généré par https://favicon.io/favicon-converter/ -->
    <link rel="icon" href="favicon.ico">


</head>
<body>
    <div class="container">
    <h3><img src="favicon.ico">&nbsp;Gestionnaire de contacts</h3>
        <div class="contact-list-container">
            <?php

            function addCell($text, $cssClass = '')
            {
                echo '<div class= "'.$cssClass.'">'.$text."</div>";
            }      

            function makeButton($cssClass, $id, $tooltip, $glyphIconId) {
                return '<button id="'.$id.'" class="'.$cssClass.'"tooltip="'.$tooltip.'" tooltip-position="left">'.makeGlyphIcon($glyphIconId).'</button>';
            }

            function makeGlyphIcon($glyphIconId){
                return "<span class='glyphicon glyphicon-".$glyphIconId."'></span>";
            }

            function addContactsRow($contact)
            {
                addCell($contact->name());
                addCell($contact->email());
                addCell($contact->phone());
                addCell(makeButton("editContact","edit_".strval($contact->id()) ,"Modifier ".$contact->name(), 'pencil'));    
                addCell(makeButton("removeContact","delete_".strval($contact->id()) ,"Effacer ".$contact->name(), 'remove'));
            }

            function addContactsHeader()
            {
                addCell('Name','header-cell');
                addCell('Email','header-cell');
                addCell('Phone','header-cell');
                addCell(makeButton("addContact","addContact","Ajouter un contact", 'plus'),'header-cell');    
                addCell(' ','header-cell');
            }

            
            addContactsHeader();
            require('models/contact.php');

            $contacts = new Contacts('contacts.txt');
            $list = $contacts->toArray();
            foreach($list as $contact)
            {
                addContactsRow($contact);
            }

            ?>        
        </div>
    </div>


    <!-- Fichier local qui contient la librairie jQuery -->
    <script src="js/jquery-3.3.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

    <script>
    "use strict";

    $(document).ready(initUI);
    function initUI() {

        $('#addContact').click(addContact);
        $('.editContact').click(editContact);
        $('.removeContact').click(deleteContact);
    }
    function addContact() {
        $(location).attr('href', "form.php");
    }

    function editContact(e) {
        let contactId = e.currentTarget.id.split('_')[1];
        $(location).attr('href', "form.php?id=" + contactId );
    }

     function confirm(message, callBack){
        $.confirm({
            title: 'Attention!',
            content: message,
            buttons: {
                confirmer: function () {
                    callBack();
                },
                annuler: {},
            }
        });
     }

    function deleteContact(e) {
        let contactId = e.currentTarget.id.split('_')[1];
        let nameToDelete = e.currentTarget.getAttribute("tooltip");
        confirm(nameToDelete + '?', function () {
                    $(location).attr('href', "doDelete.php?id=" + contactId );
                });
    }

    </script>
</body>
</html>