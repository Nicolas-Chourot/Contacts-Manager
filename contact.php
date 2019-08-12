<?php
require 'modelUtilities.php';

class Contact extends Record
{
    private $_id;
    private $_name;
    private $_email;
    private $_phone;

    public function setId($id)
    {
        $id = (int)$id;
        if ($id > 0)
            $this->_id = $id;
    }
    public function setName($name)
    {
        if (is_string($name))
            $this->_name = $name;
    }
    public function setEmail($email)
    {
        if (is_string($email))
            $this->_email = $email;
    }
    public function setPhone($phone)
    {
        if (is_string($phone))
            $this->_phone = $phone;
    }

    public function id()
    {
        return $this->_id;
    }
    public function name()
    {
        return $this->_name;
    }
    public function email()
    {
        return $this->_email;
    }
    public function phone()
    {
        return $this->_phone;
    }

    public function clone()
    {
        $clone = new Contact();
        $clone->setId($this->_id);
        $clone->setName($this->_name);
        $clone->setEmail($this->_email);
        $clone->setPhone($this->_phone);
        return $clone;
    }

    public static function compare($contact_a, $contact_b)
    {
        return strcmp($contact_a->name(), $contact_b->name());
    }
}

class Contacts 
{
    private $_contacts;
    private $_filePath;

    public function __construct($filePath)
    {
        $this->_filePath = $filePath;
        $this->_contacts = [];
        $this->read();
    }

    private function read()
    {
        if (file_exists($this->_filePath))
        {
            $contactsFile = fopen($this->_filePath, "r");
            try 
            {
                $this->_contacts = [];
                while (!feof($contactsFile))
                {
                    $contact = unserialize(fgets($contactsFile));
                    if ($contact)
                        $this->_contacts[] = $contact ;
                }
                $this->sortContacts();
            }
            catch (Exception $e)
            {
                echo 'Exception: ',  $e->getMessage();
            }
            finally
            {
                fclose($contactsFile);             
            }
           
        }
    }

    private function write()
    {
        $contactsFile = fopen("contacts.txt", "w");
        if (flock($contactsFile, LOCK_EX))
        {
            try
            {
                foreach($this->_contacts as $contact)
                {
                    fwrite($contactsFile, serialize($contact)."\n");
                }
                fflush($contactsFile);
            }
            catch (Exception $e)
            {
                echo 'Exception: ',  $e->getMessage();
            }
            finally
            {
                flock($contactsFile, LOCK_UN);
                fclose($contactsFile);
            }           
        }
        else
        {
            echo "Impossible de verrouiller le fichier contacts.txt !";
        }
        $this->read();
    }

    private function sortContacts()
    {
        usort($this->_contacts, "Contact::compare");
    }

    private function maxId()
    {
        $max = 0;
        foreach($this->_contacts as $contact)
        {
            if ($contact->id() > $max)
                $max = $contact->id();
        }
        return ($max + 1);
    }

    public function add($contact)
    {
        $contact->setId($this->maxId());
        $this->_contacts[] = $contact;
        $this->write();
    }

    public function get($id)
    {
        foreach($this->_contacts as $contact)
        {
            if ($contact->id() === $id)
               return $contact;
        }
        return null;
    }

    public function update($contact)
    {
        $contactToUpdate = $this->get($contact->id());
        if ($contactToUpdate != null)
        {
            $contactToUpdate->setName($contact->name());
            $contactToUpdate->setEmail($contact->email());
            $contactToUpdate->setPhone($contact->phone());
            $this->write();
        }
    }
    
    public function remove($id)
    {
        $index = 0;
        foreach($this->_contacts as $contact)
        {
            if ($contact->id() === $id)
            {
                unset($this->_contacts[$index]);
                $this->write();
                return true;
            }
            $index ++;
        }
        return false;
    }

    public function toArray()
    {
        $contacts = [];
        foreach($this->_contacts as $contact)
        {
            $contacts[] = $contact->clone();
        }
        return $contacts;
    }
}
/*
$contacts = new Contacts('contacts.txt');
$c = new Contact();
$c->setId(2);
$c->setName('François');
$c->setEmail('François@gmail.com');
$c->setPhone('(450) 430-3120');
$contacts->update($c);
//$contacts->add($c);

$c = new Contact();
$c->setName('Antoine');
$c->setEmail('antoine@gmail.com');
$c->setPhone('(450) 430-3120');
//$contacts->add($c);

//$contacts->remove(1);
var_dump($contacts->toArray());

echo "done";
*/
?>