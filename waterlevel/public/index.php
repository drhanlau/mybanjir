<?php

require __DIR__.'/../vendor/autoload.php';

use Sunra\PhpSimple\HtmlDomParser;

$app = new Slim\Slim();

$app->get('/', function() {
    echo "MyBanjir";
});

$app->group("/crawler", function() use($app) {

    $app->get('/waterlevel/:state', function ($state) {

        $url = 'http://infobanjir.water.gov.my/waterlevel_page.cfm?state='.$state;

        try {
            $html = HtmlDomParser::file_get_html( $url );
        }
        catch(Exception $e) {
            header("Content-Type: application/json");

            $data = array('Message' => 'An error has occured');
            echo json_encode($data);
            exit;
        }

        $table = $html->find('table.tbMain1_aa');

        $data = array();
        if( count($table) > 1){
            $table = $table[1];

            $rows = $table->find('tr');

            if($rows){
                $counter = 0;
                foreach($rows as $row){
                    $tds = $row->find('td');
                    if($counter > 0 && count($tds) > 1 ){
                        $item = array();
                        $item['StationId'] = clean_html($tds[0]->find('font', 0)->plaintext);
                        $item['StationName'] = clean_html($tds[1]->plaintext);
                        $item['District'] = clean_html($tds[2]->plaintext);
                        $item['RiverBasin'] = clean_html($tds[3]->plaintext);
                        $item['LastUpdateDate'] = clean_html($tds[4]->plaintext);
                        $item['RiverLevel'] = (float)clean_html($tds[5]->plaintext);
                        $item['NormalLevel'] = (float)clean_html($tds[6]->plaintext);
                        $item['AlertLevel'] = (float)clean_html($tds[7]->plaintext);
                        $item['WarningLevel'] = (float)clean_html($tds[8]->plaintext);
                        $item['DangerLevel'] = (float)clean_html($tds[9]->plaintext);


                        // check if it's in database
                        $level = Waterlevel::where('StationId', $item['StationId'])->get()->first();

                        if(!$level){
                            $level = new Waterlevel;
                            $level->StationId = $item['StationId'];
                            $level->LastUpdateDate = $item['LastUpdateDate'];
                            $level->StationName = $item['StationName'];
                            $level->District = $item['District'];
                            $level->State = $state;
                            $level->save();
                        }

                        $level->LastUpdateDate  = $item['LastUpdateDate'];
                        $level->RiverLevel      = $item['RiverLevel'];
                        $level->NormalLevel     = $item['NormalLevel'];
                        $level->AlertLevel      = $item['AlertLevel'];
                        $level->WarningLevel    = $item['WarningLevel'];
                        $level->DangerLevel    = $item['DangerLevel'];
                        $level->save();

                        $data[] = $level;
                    }

                    $counter++;
                }
            }
        }

        header("Content-Type: application/json");
        echo json_encode($data);
        exit;
    });

});

$app->group("/api", function() use($app) {

    $app->get('/waterlevel/:state', function ($state) {

        $state = strtolower($state);

        $levels = Waterlevel::where('state','=', $state)->get();

        if(!$levels){
            $data = array('Message' => 'An error has occured');
        }else{
            $data = $levels->toArray();
        }

        header("Content-Type: application/json");
        header('Access-Control-Allow-Origin: *');
        echo json_encode($data);
        exit;
    });

});

$app->run();



function clean_html($value){

    $value = str_replace("  \t", "", $value);
    $value = str_replace("\t", "", $value);
    $value = str_replace("&nbsp;  ", "", $value);
    return str_replace("\r\n", "", $value);
}
