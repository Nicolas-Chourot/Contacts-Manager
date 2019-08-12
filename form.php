<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add contact</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- lien vers le favicon généré par https://favicon.io/favicon-converter/ -->
    <link rel="icon" href="favicon.ico">
    <!-- Style pour l'interface et la liste des contacts -->
    <link rel="stylesheet" href="css/contactManagerLayout.css">
</head>
<body>
    <div class="container">
        <h3><img src="favicon.ico">&nbsp;<span id="actionTitle"></span></h3>
        <hr>
        <div id="contactFormPanel" class="form-group col-md-4" style="max-width: 330px;">
           <!-- Le formulaire id="contactForm" sera inséré ici -->
        </div>
        <h3 style="color:red" id='error'></h3>
    </div>

<script src="js/jquery-3.3.1.js"></script>
<script src="js/controlBuilder.js"></script>
<script src="js/validation.js"></script>
<script src="js/jquery.maskedinput.js"></script>

<script>
"use strict";


<?php // injection de code javascript
    if (isset($_GET["id"])) // le id est-il spécifié?
    {
        require('models/contact.php');
        $contacts = new Contacts('contacts.txt');
        $contact = $contacts->get((int)$_GET['id']);
        echo "let actionTitle = 'Modificaton de contact'; ";
        if (isset($contact)) 
        {
            echo "let contactFormAction = 'doEdit.php'; ";
            echo "let error = '';";

            echo "let id = '".strval($contact->id())."';";
            echo "let name = '".$contact->name()."';";
            echo "let email = '".$contact->email()."';";
            echo "let phone = '".$contact->phone()."';";
        }
        else
        {
            echo "let error = 'Erreur! Contact inexistant!';";
        }
    }
    else
    {
        echo "let actionTitle = 'Ajout de contact'; ";
        echo "let contactFormAction = 'doAdd.php'; ";
        echo "let error = '';";
 
        echo "let id = '0'; ";
        echo "let name = ''; ";
        echo "let email = ''; ";
        echo "let phone = ''; ";
    }
?>

//////////////////////////////////////////////////////////////////////////////////////////////////
// fonctions de validations des champs du formulaire.

function validate_Name(){
    let TBX_Name = document.getElementById("name");

    if (TBX_Name.value === "")
        return "Nom manquant";

    return "";
}

function validate_Phone(){
    let TBX_Phone = document.getElementById("phone");

    if (TBX_Phone.value === "")
        return "Téléphone manquant";

    return "";
}

function validate_email(){
    let TBX_Email = document.getElementById("email");
    let emailRegex = /^([\w\.\-]+)@([\w\-]+)((\.(\w){2,3})+)$/;

    if (TBX_Email.value === "")
        return "Adresse de courriel manquante";

    if (!emailRegex.test(TBX_Email.value))
        return "Adresse de courriel invalide";

    return "";
}

//////////////////////////////////////////////////////////////////////////////////////////////////
// Création du formulaire.

function insertContactForm(parentPanel){

    let contactForm = makeForm("contactForm", contactFormAction);

    contactForm.appendChild(makeHidden("id", id));
    contactForm.appendChild(makeTextBox("name","Nom", "form-control"));
    contactForm.appendChild(document.createElement("br"));

    contactForm.appendChild(makeTextBox("email","Courriel", "form-control"));
    contactForm.appendChild(document.createElement("br"));
    
    contactForm.appendChild(makeTextBox("phone","Téléphone", "form-control phone"));
    contactForm.appendChild(document.createElement("br"));

    contactForm.appendChild(makeSubmitButton("Soumettre...","btn btn-primary"));
    contactForm.appendChild(document.createElement("br"));

    document.getElementById(parentPanel).appendChild(contactForm);

 }

//let validationProvider = null;

function initValidation() {
    // installer les validations du formulaire

    let validationProvider = new ValidationProvider("contactForm");
    validationProvider.addControl("name", validate_Name);
    validationProvider.addControl("phone", validate_Phone);
    validationProvider.addControl("email", validate_email);
    // installer des filtres
    document.getElementById("name").addEventListener("keypress", textInputAlphaFilter);
    // installer les masques de saisie
    $(".phone").mask("(999) 999-9999");
}

function injectValues() {

    $("#name").val(name);
    $("#email").val(email);
    $("#phone").val(phone);
}

function showError() {
    $("#error").html(error);
}

// au chargement du document html
window.onload = () => { 
    $("#actionTitle").html(actionTitle);
    if (error === "") {
        insertContactForm("contactFormPanel"); 
        initValidation(); 
        injectValues();
    }
    else{
        showError();
    }
};
</script>

</body>
</html>