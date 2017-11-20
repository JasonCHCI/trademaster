<?php

class Transaction extends DbObject {
    // name of database table
    const DB_TABLE = 'transaction';

    // database fields
    protected $id;
    protected $uid;
    protected $volume;
    protected $symbol;

    // constructor
    public function __construct($args = array()) {
        $defaultArgs = array(
            'id' => null,
            'uid' => 0,
            'volume' => 0,
            'symbol' => '',
            'buyorsell' => 1,
            'price' => 0
        );

        $args += $defaultArgs;

        $this->id = $args['id'];
        $this->uid = $args['uid'];
        $this->volume = $args['volume'];
        $this->symbol = $args['symbol'];
        $this->buyorsell = $args['buyorsell'];
        $this->price = $args['price'];
    }

    // save changes to object
    public function save() {
        $db = Db::instance();
        // omit id and any timestamps
        $db_properties = array(
            'uid' => $this->uid,
            'symbol' => $this->symbol,
            'volume' => $this->first_name,
            'buyorsell' => $this->buyorsell,
            'price' => $this->price

        );
        $db->store($this, __CLASS__, self::DB_TABLE, $db_properties);
    }

    // load object by ID
    public static function loadById($id) {
        $db = Db::instance();
        $obj = $db->fetchById($id, __CLASS__, self::DB_TABLE);
        return $obj;
    }

    public static function getTransactionsByUserId($userID=null, $limit=null) {
        if($userID==null) {
            return null;
        }

        $query = sprintf(" SELECT id FROM %s WHERE uid = %d",
            self::DB_TABLE,
            $userID
        );
        $db = Db::instance();
        $result = $db->lookup($query);
        if(!mysql_num_rows($result))
            return null;
        else {
            $objects = array();
            while($row = mysql_fetch_assoc($result)) {
                $objects[] = self::loadById($row['id']);
            }
            return ($objects);
//
//            $row = mysql_fetch_assoc($result);
//            $obj = new __CLASS__($row);
//            return $obj;
        }
    }


    public static function getPrediction(){
        $result = array();
        $symbol_array = self::getSymbols();
        foreach ($symbol_array as $symbol) {
            $transactions = getTransactionsBySymbol($symbol);
            $total_volume = 0;
            foreach ($transactions as $transaction) {
                $volume = $transaction.get('volume');
                $buyorsell = $transaction.get('buyorsell');
                if ($buyorsell > 0) {
                    $total_volume += $volume;
                } else {
                    $total_volume -= $volume;
                }
            }
            if ($total_volume > 0) { $result[$symbol] = 'buy';}
            else {$result[$symbol] = 'sell';}

        }

        return $result;
    }

    public static function getSymbols(){
        $query = sprintf(" SELECT symbol FROM %s ",
            self::DB_TABLE
        );

        $db = Db::instance();
        $result = $db->lookup($query);
        if(!mysql_num_rows($result))
            return null;
        else {
            $objects = array();
            while ($row = mysql_fetch_assoc($result)) {
                $objects[] = self::loadById($row['id']);
            }
            echo $objects;
            return ($objects);

        }
    }


    public static function getTransactionsBySymbol($symbol=null, $limit=null) {
        if($symbol==null) {
            return null;
        }

        $query = sprintf(" SELECT id FROM %s WHERE uid = %s",
            self::DB_TABLE,
            $symbol
        );
        $db = Db::instance();
        $result = $db->lookup($query);
        if(!mysql_num_rows($result))
            return null;
        else {
            $objects = array();
            while($row = mysql_fetch_assoc($result)) {
                $objects[] = self::loadById($row['id']);
            }
            return ($objects);
//
//            $row = mysql_fetch_assoc($result);
//            $obj = new __CLASS__($row);
//            return $obj;
        }
    }

}