<?php

class XmlEncoder {
    private $xmlString, $array;

    public function __construct($array) {
        $this->array = $array;
    }

    public function getUnformattedString(){
        if ($this->xmlString){
            $this->xmlString = preg_replace("/[\r\n]/", '', $this->xmlString);
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
        $this->xmlString  = $this->xml_encode($this->array);
    }

    private function xml_encode($mixed, $domElement=null, $DOMDocument=null, $elem = null) {
        //var_dump($mixed);
        //var_dump($elem);
        if (is_null($DOMDocument)) {
            $DOMDocument =new DOMDocument;
            $DOMDocument->preserveWhiteSpace = false;
            $this->xml_encode($mixed, $DOMDocument, $DOMDocument);
            return $DOMDocument->saveXML();
        }
        else {
            // To cope with embedded objects
            if (is_object($mixed)) {
                $mixed = get_object_vars($mixed);
            }
            if (is_array($mixed)) {
                if(array_key_exists('id',$mixed)){
                    $elem = $DOMDocument->createElement('element');
                    $elem->setAttribute("id", array_shift($mixed));
                    $DOMDocument->appendChild($elem);
                }
                foreach ($mixed as $index => $mixedElement) {
                    if (is_int($index)) {
                        if ($index === 0) {
                            $node = $domElement;
                        } else {
                            if (property_exists($domElement, "tagName")) {
                                $node = $DOMDocument->createElement($domElement->tagName);
                                if ($elem != null)
                                    $elem->appendChild($node);
                                else
                                    $domElement->parentNode->appendChild($node);
                            }
                        }
                    } else {
                        $plural = $DOMDocument->createElement($index);
                        if ($elem != null)
                            $elem->appendChild($plural);
                        else
                            $domElement->appendChild($plural);
                        $node = $plural;
                        if (!(rtrim($index, 's') === $index)) {
                            $singular = $DOMDocument->createElement(rtrim($index, 's'));
                            $plural->appendChild($singular);
                            $node = $singular;
                        }
                    }
                    $this->xml_encode($mixedElement, $node, $DOMDocument, $elem);
                }
            }
            else {
                $mixed = is_bool($mixed) ? ($mixed ? 'true' : 'false') : $mixed;
                $domElement->appendChild($DOMDocument->createTextNode($mixed));
            }
        }
    }
}
?>