<?php
require_once('IndexDat.php');

function main() {

}

$file = null;
$output = null;
$func = array();
$converts = array();
for ($j=1; $j<count($argv); $j++) {
    switch ($argv[$j]) {
        case '-m':
            $func [] = $argv[$j];
            break;
        case '-o':
            if ($j+1 >= count($argv)) {
                throw new Exception('not enough parameters');
            }
            $output = $argv[$j+1];
            $j++;
            break;
        case '-c':
            if ($j+2 >= count($argv)) {
                throw new Exception('not enough parameters');
            }
            $converts []= $argv[$j+1];
            $converts []= $argv[$j+2];
            $j+=2;
            break;
        default:
            $file = $argv[$j];
            break;
    }
}

if ($file == null) {
    die(
            "Usage:\n"
            ." php $argv[0] <Index.dat> -m\n"
            ." php $argv[0] <Index.dat> -o <Index.output.dat> -c <from_model> <to_model>\n"
            ."\n"
            ."  -m           show model list\n"
            ."  -o <output>  output file\n"
            ."  -f <model>   from\n"
            ."  -t <model>   to\n");
}


$dat = new IndexDat($file);

if (count($converts) > 0) {
    $models = $dat->getModels();
    foreach ($converts as $model) {
        if (!in_array($model, $models)) {
            echo("Warning: model not found: \"$model\"\n");
        }
    }
    for ($j=0; $j<count($converts); $j+=2) {
        $from = $converts[$j];
        $to = $converts[$j+1];
        $newValues = array();
        foreach ($dat->values as $value) {
            if ($value['model'] == $from) {
                $newValues []= $value;
            }
        }
        printf("%s => %s\n", $from, $to);
        foreach ($newValues as $value) {
            $value['model'] = $to;
            $dat->values []= $value;
            printf(" %s\n", $value['path']);
        }
    }
}

foreach ($func as $f) {
    switch ($f) {
        case '-m':
            showModelList($dat);
            break;
    }
}

if ($output != null) {
    $dat->writeFile($output);
}


function showModelList($dat) {

    foreach ($dat->getModels() as $model) {
        printf("%s\n", $model);
    }
}