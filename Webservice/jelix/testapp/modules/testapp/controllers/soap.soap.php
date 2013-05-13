<?php

/**
 * @package     testapp
 * @subpackage  testapp module
 * @version     1
 * @contributor
 * @link        http://www.jelix.org
 * @licence     GNU Lesser General Public Licence see LICENCE file or http://www.gnu.org/licenses/lgpl.html
 */

/**
 * Web Services usefull to test SOAP request handling, WSDL generation, web servives documentation generation
 */
class soapCtrl extends jController {

    /**
     * Test with an array as param
     * @param string $req
     * @return string
     */
    function info() {

        $response = $this->getResponse('soap');
        $query = $this->param('req');
        $multiplerequest = explode("||", $query);
        $response->data = array();
//Si plusieurs requête
        for ($i = 0; $i < count($multiplerequest); $i++) {
            $request = explode("|", $multiplerequest[$i]);
            switch ($request[0]) {
                case "GET":
//Récupération des différents champs des tables à partir des documents xml des daos
                    $xmldao = new DomDocument;
                    $chemin = '../../testapp/modules/testapp/daos/' . $request[1] . '.dao.xml';
                    $xmldao->load($chemin);
                    $Listeprop = $xmldao->getElementsByTagName("property");
//Récupération du contenu de la table
                    $Factory = jDao::get($request[1]);
                    foreach (explode("&", $request[2]) as $chunk) {
                        $param = explode("=", $chunk);
                        if ($param[1] == "?") {
                            $listOfAll = $Factory->findAll();
                        } else {
                            $conditions = jDao::createConditions();
                            $conditions->addCondition($param[0], '=', $param[1]);
                            $listOfAll = $Factory->findBy($conditions);
                        }
                        foreach ($listOfAll as $val) {
                            $chaine = array();
                            foreach ($Listeprop as $Listename) {
                                $toEval = '$var = $val->' . $Listename->getAttribute("name") . ';';
                                eval($toEval);
                                $chaine[$Listename->getAttribute("name")] = $var;
                            }
                            $response->data[] = $chaine;
                        }
                    }
                    break;
                case "POST":
                    break;
                case "PUT":
                    $xmldao = new DomDocument;
                    $chemin = '../../GiteoWebService/modules/GiteoWebService/daos/' . $request[1] . '.dao.xml';
                    $xmldao->load($chemin);
                    $Listeprop = $xmldao->getElementsByTagName("property");

                    $Factory = jDao::get($request[1]);
                    $record = jDao::createRecord($request[1]);

// on remplit le record
                    foreach (explode("&", $request[2]) as $chunk) {

                        $param = explode("=", $chunk);
                        $record->$param[0] = $param[1];
                    }
// on le sauvegarde dans la base
                    $e = new Exception("BDD error");
                    try {
                        $Factory->insert($record);
                        $response->data[] = "PUT succeed";
                    } catch (Exception $e) {
                        $response->data[] = "PUT error";
                    }
                    break;
                case "DELETE":
                    $Factory = jDao::get($request[1]);
                    foreach (explode("&", $request[2]) as $chunk) {
                        $param = explode("=", $chunk);
                        try {
                            $Factory->delete($param[1]);
                            $response->data[] = "DELETE succeed";
                        } catch (Exception $e) {
                            $response->data[] = "DELETE error";
                        }
                    }
                    break;
                default:
                    $response->data[] = "Method error";
                    break;
            }
        }
        return $response;
    }

}