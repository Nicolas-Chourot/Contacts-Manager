<?php
//echo $_GET['id'];
require('models/contact.php');
$contacts = new Contacts('contacts.txt');
$contact = $contacts->get((int)$_GET['id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit contact</title>
</head>
<body>
    <form action="doEdit.php" method="post"> 
        <input type="hidden" name="id" value = "<?php echo $contact->id(); ?>" >
        Name<br>
        <input type="text"  name="name" value = "<?php echo $contact->name(); ?>" > <br><br>
        Email<br>
        <input type="text"  name="email" value = "<?php echo $contact->email(); ?>" > <br><br>
        Phone<br>
        <input type="text"  name="phone" value = "<?php echo $contact->phone(); ?>" > <br><br>
        <input type="submit">
    </form>
</body>
</html>