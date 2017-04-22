<?php

class IndexDat {

    public $x1;
    public $values;

    public function __construct($path) {
        $fp = fopen($path, 'rb');
        $this->x1 = $this->readInt($fp);
        $count = $this->readInt($fp);

        $index = 0;

        while (!feof($fp)) {
            $dcpLen = $this->readInt($fp);
            $dcpPath = $this->readString($fp, $dcpLen);

            $nazo = fread($fp, 12);

            $secLen = $this->readInt($fp);
            $sec = $this->readString($fp, $secLen);
            $modelLen = $this->readInt($fp);
            $model = $this->readString($fp, $modelLen);

            $this->values[] = array('path' => $dcpPath, 'nazo' => $nazo, 'sec' => $sec, 'model' => $model);
            $index++;
            if ($index == $count) {
                break;
            }
        }

        fclose($fp);
    }

    public function writeFile($path) {
        $fp = fopen($path, 'wb');
        $this->writeInt($fp, $this->x1);
        $this->writeInt($fp, count($this->values));
        foreach ($this->values as $value) {
            $this->writeStringWithLength($fp, $value['path']);
            fwrite($fp, $value['nazo'], 12);
            $this->writeStringWithLength($fp, $value['sec']);
            $this->writeStringWithLength($fp, $value['model']);
        }
        fclose($fp);
    }

    function getModels() {
        $models = array();
        foreach ($this->values as $value) {
            $model = $value['model'];
            $models[$model] = 1;
        }
        return array_keys($models);
    }

    function readInt($fp) {
        $r = fread($fp, 4);
        if (strlen($r) != 4) {
            die('count:' . strlen($r));
        }
        return unpack('V', $r)[1];
    }

    function readString($fp, $length) {
        $str = fread($fp, $length);
        $n = fread($fp, 1);
        if (ord($n) != 0) {
            die('文字列の後ろが0じゃない ftell:' + ftell($fp));
        }
        return $str;
    }

    function writeInt($fp, $value) {
        fwrite($fp, pack('V', $value), 4);
    }


    function writeString($fp, $value) {
        fwrite($fp, $value);
        fwrite($fp, "\0");
    }

    function writeStringWithLength($fp, $value) {
        fwrite($fp, pack('V', strlen($value)));
        fwrite($fp, $value);
        fwrite($fp, "\0");
    }

}
