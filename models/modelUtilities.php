<?php

require ('utilities/formUtilities.php');

abstract class Record
{
    public function __construct(array $recordData = null)
    {
        if ($recordData != null)
            $this->hydrate($recordData);
    }

    public function hydrate(array $recordData)
    {
        foreach($recordData as $fieldName => $fieldValue)
        {
            $method = 'set'.ucfirst($fieldName);
            if (method_exists($this, $method))
                $this->$method(sanitizeString($fieldValue));
        }
    }
}
?>