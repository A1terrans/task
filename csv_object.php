<?php
class CSVObj
{ 
    public $code, $name;
    function __construct($code, $name)
    {
        $this->code = $code;
        $this->name = $name;
    }
    public function __toString() {
        return $this->code .'#'. $this->name;
    }
}
?>