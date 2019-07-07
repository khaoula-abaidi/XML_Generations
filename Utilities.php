<?php


class Utilities
{
    private $dom;

    /**
     * Utilities constructor.
     * @param DOMElement $dom
     */
    public function __construct()
    {
    }

    /**
     * @param DOMElement $element
     * @return DOMElement
     */
    public function generateNamespaces(DOMElement $element){
        $element->setAttribute('xmlns','http://www.tei-c.org/ns/1.0');
        $element->setAttribute('xmlns:xsi','http://www.w3.org/2001/XMLSchema-instance');
        $element->setAttribute('xmlns:hal','http://hal.archives-ouvertes.fr/');
        $element->setAttribute('xsi:schemaLocation','http://www.tei-c.org/ns/1.0 http://api.archives-ouvertes.fr/documents/aofr-sword.xsd');
var_dump($element);
        return $element;
    }
    public function generateTeiHeader(){

    }
    public function genereteText(){

    }
    public function genereteListOrg(){

    }
    public function genereteOrg(){

    }
    public function generateOrgName(){

    }
    public function genereteIdno(){

    }
    public function genereteDesc(){

    }
    public function genereteAdress(){

    }
    public function genereteCountry(){

    }
    public function genereteRef(){

    }
    public function genereteDate(){

    }
    public function genereteLIdno(){

    }
    public function genereteRelation(){

    }
    public function genereteListRelation(){

    }
    public function genereteBack(){

    }
    public function genereteBody(){

    }
    public function genereteListBibl(){

    }
    public function genereteBiblFull(){

    }
    public function genereteProfileDesc(){

    }
    public function genereteAbstract(){

    }
    public function generetePartieDesc(){

    }
    public function genereteClassCode(){

    }
    public function genereteKeywords(){

    }
    public function genereteTerm(){

    }
    public function genereteTextClass(){

    }
    public function genereteLangUsage(){

    }
    public function genereteSourceDesc(){

    }
    public function genereteLanguage(){

    }
    public function genereteMonogr(){

    }
    public function genereteImprint(){

    }
    public function genereteBiblScope(){

    }
    public function genereteMeeting(){

    }
    public function genereteTitle(){

    }
    public function genereteSetElement(){

    }
    public function genereteAnalytic(){

    }
    public function genereteAffiliation(){

    }
    public function generetePersName(){

    }
    public function genereteForname(){

    }
    public function genereteSurname(){

    }
    public function genereteAuthor(){

    }
    public function genereteEmail(){

    }
    public function genereteNote(){

    }
    public function genereteNotesStmt(){

    }
    public function genereteSeriesStmt(){

    }
    public function generetePublicationStmt(){

    }
    public function genereteEditionStmt(){

    }
    public function genereteRespStmt(){

    }
    public function genereteResp(){

    }
    public function genereteName(){

    }
    public function genereteEdition(){

    }
    public function genereteEditor(){

    }
    public function genereteFunder(){

    }
    public function genereteAvailibility(){

    }
    public function genereteDistributor(){

    }
    public function genereteLicence(){

    }
    public function genereteTitleStmt(){

    }
    public function genereteTeiHeader(){

    }
    public function genereteP(){

    }
    public function generateTei(){
        $xml = new DOMDocument('1.0','UTF-8');
        $teiTag = new DOMElement('tei');
        $xml->appendChild($this->generateNamespaces($teiTag));
    }
}