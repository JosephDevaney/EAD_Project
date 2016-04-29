<?php

function array_to_xml($array ,&$xml) {
    foreach($array as $key => $value) {
        if(is_array($value)) {
            $key = is_numeric($key) ? "element" : $key;
            $subnode = $xml->addChild("$key");
            array_to_xml($value, $subnode);
        }
        else {
            $key = is_numeric($key) ? "element" : $key;
            $xml->addChild("$key","$value");
        }
    }
}

class XmlEncoder {
    private $xmlString, $array;

    public function __construct($array) {
        $this->array = $array;
    }

    public function getUnformattedString(){
        if ($this->xmlString){
            $this->xmlString = preg_replace("/[\r\n]/", '', $this->xmlString);
            $this->xmlString = preg_replace("/[\t]/", '', $this->xmlString);
            return $this->xmlString;
        }
        return false;
    }

    public function getString(){
        if ($this->xmlString){
            return $this->xmlString;
        }
        return false;
    }

    public function encode()
    {
        $xml = new SimpleXMLElement('<array/>');
        array_to_xml($this->array, $xml);
        $this->xmlString = $xml->asXML();
    }
}
?>