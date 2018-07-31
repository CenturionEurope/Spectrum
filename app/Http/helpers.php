<?php

function ColeField($Cole,$Tag,$Element,$Classes=null, $ID=null){
    // Provide a quick frontend for loading ColeFields
    return html_entity_decode(app('App\Http\Controllers\Cole\ColeController')->ColeField($Cole,$Tag,$Element,$Classes, $ID));
}

function ColeImage($Tag,$Classes=null,$ID=null){
    return app('App\Http\Controllers\Cole\ColeController')->ColeFieldImage($Tag,$Classes,$ID);
}

function ColeDebug($v, $asString = false){
    if (!$asString) {
        array_map(function ($x) {
            (new Illuminate\Support\Debug\Dumper)->dump($x);
        }, [$v]);
    } else {
        $r = array_map(function ($x) {
            return (new App\Library\Classes\Dumper)->dump($x);
        }, [$v]);
        return $r[0];
    }
}