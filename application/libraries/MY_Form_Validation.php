<?php

class MY_Form_Validation extends CI_Form_validation
{
    function __construct($config = array())
    {
        parent::__construct($config);
    }
    
    function error_array()
    {
        if (count($this->_error_array) === 0)
        {
            return false;
        }
        else
            return $this->_error_array;
    }
}
?>
