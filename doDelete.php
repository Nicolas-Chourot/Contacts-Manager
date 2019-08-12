<?php
require('models/contact.php');
$contacts = new Contacts('contacts.txt');
$contacts->remove((int)$_GET['id']);
header('Location: manage.php'); 
?>