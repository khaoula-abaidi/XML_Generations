<?php

class generateTeiClass
{
    const version = '1.0';
    const encoding = 'UTF-8';
    const TEI = 'TEI';
    const xmlns = 'http://www.tei-c.org/ns/1.0';
    const xmlnsHal = 'http://hal.archives-ouvertes.fr/';
    const xmlnsXsi = 'http://www.w3.org/2001/XMLSchema-instance';
    const versionTei = '1.1';
    const xmlnsXsiLocation = 'http://www.tei-c.org/ns/1.0 http://api.archives-ouvertes.fr/documents/aofr-sword.xsd';
    private $attribute_title;
    private $attribute_ref;
    private $attribute_language;
    private $attribute_abstract;
    private $attribute_listOrg;
    private $attribute_keywords;
    private $attribute_classCode;
    public function __construct()
    {
    }
    private function generateAttributesArray() {
        $this->attribute_title = [
            'xml:lang' => 'en'
        ];
        $this->attribute_ref = [
            'type' => 'file',
            'n' => 1,
            'subtype'=>'author',
            'target' => 'file.pdf'
        ];
        $this->attribute_language = [
          'ident' => 'en'
        ];
        $this->attribute_abstract = [
            'xml:lang' => 'en'
        ];
        $this->attribute_listOrg = [
            'type' => 'structures'
        ];
        $this->attribute_keywords = [
           'scheme' => 'author'
        ];
        $this->attribute_classCode=[
            'n' => '',
            'scheme' =>''
        ];
    }
    private function generateElementChildren(string $element): array {
        $children = [];
        switch ($element){
            case 'text':
                $children = ['body','back'];
                break;
            case 'teiHeader':
                $children = ['fileDesc','profileDesc'];
                break;
        }
        return $children;
    }
    private function generateRootTag(string $name_root_tag,DOMDocument $xml_doc,DOMElement $child){
// ------------ Génération des namesspaces && TEI root tag ----------
        $tei = $xml_doc->createElement($name_root_tag);
        $tei->setAttribute('xmlns', self::xmlns);
        $tei->setAttribute('xmlns:xsi',self::xmlnsXsi);
        $tei->setAttribute('xmlns:hal', self::xmlnsHal);
        $tei->setAttribute('version',self::versionTei);
        $tei->setAttribute('xsi:schemaLocation',self::xmlnsXsiLocation);
        $tei->appendChild($child);
        return $tei;
    }
    /**
     * @param string $child_tag_name
     * @param DOMDocument $xml_doc
     * @param array $attributes
     * @param string $value_tag
     * @return DOMElement
     */
    private function generateSimpleTag(string $child_tag_name, DOMDocument $xml_doc, array $attributes = null,string $value_tag = null):DOMElement{
        $tag = $xml_doc->createElement($child_tag_name,$value_tag);
        if($attributes) {
            foreach ($attributes as $name_attr => $value_attr) {
                $tag->setAttribute($name_attr, $value_attr);
            }
        }
        return $tag;
    }
    private function generateComplexTag(string $tag_name, DOMDocument $xml_doc,array $children = null){
        $tag = $xml_doc->createElement($tag_name);
        if($children){
            // relier le noeud fils au parent
            foreach ($children as $child){
                $tag->appendChild($child);
            }
        }
        return $tag;
    }
    /**
     * Function tei xml file
     */
    public function generateTeiFile(){
    $xml_doc = new DOMDocument(self::version, self::encoding);
    //       <titleStmt> <title></title></titleStmt>
    // génération du noeud title et le relier au parent titleStmt
    $this->generateAttributesArray();
    $title = $this->generateSimpleTag('title',$xml_doc,$this->attribute_title,'test de dépot');
     $titleStmt = $this->generateComplexTag('titleStmt',$xml_doc,[$title]);
    /**
     * // génération des noeuds author et les relier au parent titleStmt
     * $author = $xml_doc->createElement('author');
     * $author->setAttribute('role','aut');
     * //generation noeud persName + affiliation d'un auteur
     * foreach($document->getAuthors() as $auteur){
     * $persName = $xml_doc->createElement('persName');
     * //persName = <forename type = ''>....</forename><surname>....</surname>
     * $fornename = $xml_doc->createElement('forename',$auteur->getFirstname());
     * $fornename->setAttribute('type','first');
     * $persName->appendChild($fornename);
     * $surname = $xml_doc->createElement('surname',$auteur->getLastname());
     * $persName->appendChild($surname);
     * $author->appendChild($persName);
     *        // pour chaque structure de l'auteur [de meme persName, email , idnoorgName, ptr]
     *      foreach($auteur->getStructures() as $structure){
     * $affiliation = $xml_doc->createElement('affiliation');
     * $affiliation->setAttribute('ref','struct-'.$structure->getId());
     * $author->appendChild($affiliation);
     *    }
     * $titleStmt->appendChild($author);
     * }
     */
    //............ <edition></edition>   ..........
    // de facon generale : <edition n = 'option' type = 'option'><date *> <ref *> <fs *>  </edition>
    //  <ref type="file" n="nbfiles" subtype="author" target="Test.pdf"/>
        $ref = $this->generateSimpleTag('ref',$xml_doc,$this->attribute_ref);
        //          <EDITION>    ------------------------------------------------------------------------------
        //                           [<ref></ref]
        //                           ------------------------------------------------------------------------------
        //          </EDITION>
     $edition = $this->generateComplexTag('edition',$xml_doc,[$ref]);
        //          <editionStmt>    ------------------------------------------------------------------------------
        //                           [<edition></edition]
        //                           ------------------------------------------------------------------------------
        //          </editionSTMT>
     $editionStmt = $this->generateComplexTag('editionStmt',$xml_doc,[$edition]);
    //       <notesStmt></notesStmt>
    $notesStmt = $xml_doc->createElement('notesStmt');
    //liste des notes
    //    .........<analytic></analytic><monogr></monogr>....
    $analytic = $xml_doc->createElement('analytic');
    // <analytic>  <title*> .. </title> <author*></author> </analytic>
    // per each title :
        $titleClone = $title->cloneNode(true);
    $analytic->appendChild($titleClone);
    //per each auteur : $analytic->appendChild($auteur)
    // <monogr> <idno *><title *> <meeting 0><respStmt 0,settlement 0><country 0><editor *><imprint 0><authority *>
        $monogr = $xml_doc->createElement('monogr');
        //<biblStruct> [ <analytic></analytic><monogr></monogr>] </biblStruct
        $biblStruct = $this->generateComplexTag('biblStruct',$xml_doc,[$analytic,$monogr]);
        //          <sourceStmt>    ------------------------------------------------------------------------------
        //                           [<biblStruct></biblStruct]
        //                           ------------------------------------------------------------------------------
        //          </sourceSTMT>
        $sourceStmt = $this->generateComplexTag('sourceStmt',$xml_doc,[$biblStruct]);
    //general: <langUsage 0><textClass 0><abstract *><particDesc 0><creation 0>
    //<language ident = 'langage du document'/>
    $language = $this->generateSimpleTag('language',$xml_doc,$this->attribute_language);
    $langUsage = $this->generateComplexTag('langUsage',$xml_doc,[$language]);
    //<keywords scheme = 'author'0>
        $keywords = $this->generateSimpleTag('keywords',$xml_doc,$this->attribute_keywords);
    //<term xml:lang = 'fr/en/...'>///</term>
    $classCode = $this->generateSimpleTag('classCode',$xml_doc,$this->attribute_classCode);
    // per each <classCode n = '' scheme = '' *>
        //<textClass>
                // <keywords></keywords> <classCode></classCode>
        // </textClass>
    $textClass  = $this->generateComplexTag('textClass',$xml_doc,[$keywords,$classCode]);
    $abstract = $this->generateSimpleTag('abstract',$xml_doc,$this->attribute_abstract,'resume du document');
        //          <profileDesc>    ------------------------------------------------------------------------------
        //                           [<langUsage></langUsage><textClass></textClass><abstract></abstract>]
        //                           ------------------------------------------------------------------------------
        //          </profileDesc>
    $profileDesc = $this->generateComplexTag('profileDesc',$xml_doc,[$langUsage,$textClass,$abstract]);
        // <BIBLFULL>  ------------------------------------------------------------------------------
        //         [ <titleStmt></titleStmt>      <editionStmt></editionStmt><notesStmt></notesStmt> <sourceStmt></sourceStmt>   <profileDesc></profileDesc>]
        //          --------------------------------------------------------------------------------
        // </BIBLFULL>
        $biblFull  = $this->generateComplexTag('biblFull',$xml_doc,[$titleStmt,$editionStmt,$notesStmt,$sourceStmt,$profileDesc]);
        // <TEI><TEXT><BODY><LISTBIBL>[<biblFull></biblFull>]</LISTBIBL></BODY></TEXT></TEI>
        $listBibl = $this->generateComplexTag('listBibl',$xml_doc,[$biblFull]);
        //<TEI><TEXT><BODY>[<listBibl></listBibl>]</BODY></TEXT></TEI>
        $body = $this->generateComplexTag('body',$xml_doc,[$listBibl]);
                        // <TEI><TEXT><BACK>   ---<listOrg></listOrg>---  </BACK></TEXT></TEI>
       $listOrg = $this->generateSimpleTag('listOrg',$xml_doc,$this->attribute_listOrg);
    // Liste des structures du document :
    /**
     * foreach($document->getStructures() as $structure){
     *  $org = $xml_doc->createElement('org');
     *  $org->setAttribute('type',$structure->getType());
     *  $org->setAttribute('xml:id','struct-'.$structure->getId());
     *  $listOrg->appendChild($org);
     *}
     */
       //<TEI><TEXT>    -------- <BACK>   [<listOrg></listOrg>]  </BACK>--------  </TEXT></TEI>
        $back = $this->generateComplexTag('back',$xml_doc,[$listOrg]);
        //  <TEI> ----------------------------<text>  [<body></body><back></back>]   </text>----------------------------   <TEI>
        $text = $this->generateComplexTag('text',$xml_doc,[$body,$back]);
 // ------------ Génération des namesspaces && TEI root tag ----------
        $tei = $this->generateRootTag('TEI',$xml_doc,$text);
// ------------ Relation du TEI  element au document XML  ----------
    $xml_doc->appendChild($tei);
    $xml = $xml_doc->saveXML();
    //echo $xml;
    $xml_doc->save('teifileClass.xml');
    $xml_doc->load('teifileClass.xml');
    echo $xml_doc->schemaValidate('aofr.xsd');
    }
}