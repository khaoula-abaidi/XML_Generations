<?php


class generateTeiClass
{
    const version = '1.0';
    const encoding = 'UTF-8';
    const TEI = 'TEI';
    const xmlns = 'http://www.tei-c.org/ns/1.0';
    const xmlnsHal = 'http://hal.archives-ouvertes.fr/';
    private $attribute_title;
    private $attribute_ref;
    private $attribute_language;
    private $attribute_abstract;
    private $attribute_listOrg;
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
    private function generateRootTag(string $name_root_tag,DOMDocument $xml_doc){
// ------------ Génération des namesspaces && TEI root tag ----------
        $tei = $xml_doc->createElement($name_root_tag);
        $tei->setAttribute('xmlns', self::xmlns);
        $tei->setAttribute('xmlns:hal', self::xmlnsHal);
        return $tei;
    }
    /**
     * @param string $child_tag_name
     * @param DOMDocument $xml_doc
     * @param array $attributes
     * @param string $value_tag
     * @return DOMElement
     */
    private function generateSimpleTag(string $child_tag_name, DOMDocument $xml_doc, array $attributes,string $value_tag = null):DOMElement{
        $tag = $xml_doc->createElement($child_tag_name,$value_tag);
        if($attributes) {
            foreach ($attributes as $name_attr => $value_attr) {
                $tag->setAttribute($name_attr, $value_attr);
            }
        }
        return $tag;
    }
    private function generateComplexTag(string $tag_name, DOMDocument $xml_doc,array $children){
        $tag = $xml_doc->createElement($tag_name);
        if($children){
            // relier le noeud fils au parent
            foreach ($children as $child){
                $tag->appendChild($child);
            }
        }
        return $tag;
    }
    public function generateTeiFile(){

    $xml_doc = new DOMDocument(self::version, self::encoding);
// ------------ Génération des namesspaces && TEI root tag ----------

    //$tei = $xml_doc->createElement('TEI');
   // $tei->setAttribute('xmlns', self::xmlns);
   // $tei->setAttribute('xmlns:hal', self::xmlnsHal);
    $tei = $this->generateRootTag('TEI',$xml_doc);
// ------------ TEXT  root tag ----------
    $text = $xml_doc->createElement('text');
    // <text>
    //   <body></body>
    $body = $xml_doc->createElement('body');
    $text->appendChild($body);
    // -------------------------------------<body>
    // <listBibl>                            </listBibl>
    $listBibl = $xml_doc->createElement('listBibl');
    // ---------- <biblFull>                 </biblFull> ---
    $biblFull = $xml_doc->createElement('biblFull');
    //       <titleStmt></titleStmt>
    $titleStmt = $xml_doc->createElement('titleStmt');
    // génération du noeud title et le relier au parent titleStmt
    //$title = $xml_doc->createElement('title', 'Test de dépôt');
    $this->generateAttributesArray();
    $title = $this->generateSimpleTag('title',$xml_doc,$this->attribute_title,'test de dépot');
    //$title->setAttribute('xml:lang', 'en');
    $titleStmt->appendChild($title);
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
    $biblFull->appendChild($titleStmt);
    //       <editionStmt>                     </editionStmt>
    $editionStmt = $xml_doc->createElement('editionStmt');
    //............ <edition></edition>   ..........
    $edition = $xml_doc->createElement('edition');
    // de facon generale : <edition n = 'option' type = 'option'><date *> <ref *> <fs *>  </edition>
    //  <ref type="file" n="nbfiles" subtype="author" target="Test.pdf"/>
        $ref = $this->generateSimpleTag('ref',$xml_doc,$this->attribute_ref);

     /**$ref = $xml_doc->createElement('ref');
        //$ref->setAttribute('type', 'file');
        //$ref->setAttribute('n', '1');
        //$ref->setAttribute('subtype', 'author');
        //$ref->setAttribute('target', 'file.pdf');//url document
        */
    $edition->appendChild($ref);
    $editionStmt->appendChild($edition);
    $biblFull->appendChild($editionStmt);
    //       <notesStmt></notesStmt>
    $notesStmt = $xml_doc->createElement('notesStmt');
    //liste des notes
    $biblFull->appendChild($notesStmt);
    //       <sourceDesc>                       </sourceDesc>
    $sourceStmt = $xml_doc->createElement('sourceStmt');
    //               <biblStruct>  </biblStruct>
    $biblStruct = $xml_doc->createElement('biblStruct');
    //    .........<analytic></analytic><monogr></monogr>....
    $analytic = $xml_doc->createElement('analytic');
    // <analytic>  <title*> .. </title> <author*></author> </analytic>
    // per each title :
    $analytic->appendChild($title);
    //per each auteur : $analytic->appendChild($auteur)
    $biblStruct->appendChild($analytic);
    $monogr = $xml_doc->createElement('monogr');
    // <monogr> <idno *><title *> <meeting 0><respStmt 0,settlement 0><country 0><editor *><imprint 0><authority *>
    $biblStruct->appendChild($monogr);
    $sourceStmt->appendChild($biblStruct);
    $biblFull->appendChild($sourceStmt);
    //       <profileDesc></profileDesc>
    $profileDesc = $xml_doc->createElement('profileDesc');
    //general: <langUsage 0><textClass 0><abstract *><particDesc 0><creation 0>
    $langUsage = $xml_doc->createElement('langUsage');
    $profileDesc->appendChild($langUsage);
    //<language ident = 'langage du document'/>
    $language = $this->generateSimpleTag('language',$xml_doc,$this->attribute_language);
    $langUsage->appendChild($language);
    $textClass = $xml_doc->createElement('textClass');
    //<keywords scheme = 'author'0>
    $keywords = $xml_doc->createElement('keywords');
    $keywords->setAttribute('scheme', 'author');
    //<term xml:lang = 'fr/en/...'>///</term>
    $textClass->appendChild($keywords);
    // $classCode = $xml_doc->createElement('classCode');
    // per each <classCode n = '' scheme = '' *>
    // $textClass->appendChild($classCode);
    $profileDesc->appendChild($textClass);
    $abstract = $this->generateSimpleTag('abstract',$xml_doc,$this->attribute_abstract,'resume du document');
    $profileDesc->appendChild($abstract);
    $biblFull->appendChild($profileDesc);
    $listBibl->appendChild($biblFull);
    $body->appendChild($listBibl);
    // -------------------------------------</body>
    // <back>.......</back>
    $back = $xml_doc->createElement('back');
    // -------------------------------------<back>
    // ......<listOrg></listOrg>.....
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
    $back->appendChild($listOrg);
    // -------------------------------------<back>
    $text->appendChild($back);
    //</text>
// ------------ relation TEXT  to parent tag TEI ----------
    $tei->appendChild($text);
// ------------ Relation du TEI  element au document XML  ----------
    $xml_doc->appendChild($tei);
    $xml = $xml_doc->saveXML();
    //echo $xml;
    $xml_doc->save('teifileClass.xml');
    }
}