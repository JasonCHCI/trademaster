<?php

class Test extends DbObject {
    // name of database table
    const DB_TABLE = 'test';

    // database fields
    protected $id;
    public $ticket_number;
    protected $price;
    protected $volume;

    // constructor
    public function __construct($args = array()) {
        $defaultArgs = array(
            'id' => null,
            'ticket_number' => '',
            'price' => 0,
            'volume' => 0,
            );

        $args += $defaultArgs;

        $this->id = $args['id'];
        $this->title = $args['ticket_number'];
        $this->price = $args['price'];
        $this->volume = $args['volume'];
    }

    // save changes to object
    public function save() {
        $db = Db::instance();
        // omit id and any timestamps
        $db_properties = array(
            'ticket_number' => $this->ticket_number,
            'price' => $this->price,
            'volume' => $this->volume
            );
        $db->store($this, __CLASS__, self::DB_TABLE, $db_properties);
    }

    // load object by ID
    public static function loadById($id) {
        $db = Db::instance();
        $obj = $db->fetchById($id, __CLASS__, self::DB_TABLE);
        return $obj;
    }

    // load object by title
    public static function loadByTitle($title) {
        $db = Db::instance();
        $obj = $db->fetchById($title, __CLASS__, self::DB_TABLE);
        return $obj;
    }



    // load all products
    public static function getAllStocks($limit=null) {
        $query = sprintf(" SELECT * FROM %s ORDER BY id ASC ",
            self::DB_TABLE
            );
        $db = Db::instance();
        $result = $db->lookup($query);
        if(!mysql_num_rows($result))
            return null;
        else {
            return ($result);
        }
    }

}
