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
        $db_properties = array(
            'id' => $this->id,
            'uid' => $this->uid,
            'volume' => $this->volume,
            'symbol' => $this->symbol,
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
        }
    }

}