<?php

require('models/contact.php');
$contact = new Contact($_POST);
$contacts = new Contacts('contacts.txt');
$contacts->update($contact);

header('Location: manage.php'); 
?>