<?php

class Hold extends DbObject
{
    // name of database table
    const DB_TABLE = 'hold';

    // database fields
    protected $id;
    protected $user_id;
    protected $volume;
    protected $symbol;

    // constructor
    public function __construct($args = array())
    {
        $defaultArgs = array(
            'id' => null,
            'user_id' => 0,
            'volume' => 0,
            'symbol' => ''
        );

        $args += $defaultArgs;

        $this->id = $args['id'];
        $this->user_id = $args['user_id'];
        $this->volume = $args['volume'];
        $this->symbol = $args['symbol'];
    }

    // save changes to object
    public function save()
    {
        $db = Db::instance();
        // omit id and any timestamps
        $db_properties = array(
            'id' => $this->id,
            'user_id' => $this->user_id,
            'volume' => $this->volume,
            'symbol' => $this->symbol
        );
        $db->store($this, __CLASS__, self::DB_TABLE, $db_properties);
    }

    // load object by ID
    public static function loadById($id)
    {
        $db = Db::instance();
        $obj = $db->fetchById($id, __CLASS__, self::DB_TABLE);
        return $obj;
    }

    // load all products
    public static function getHoldsByUserId($userID = null, $limit = null)
    {
        if ($userID == null) {
            return null;
        }

        $query = sprintf(" SELECT id FROM %s WHERE uid = %d",
            self::DB_TABLE,
            $userID
        );
        $db = Db::instance();
        $result = $db->lookup($query);
        if (!mysql_num_rows($result))
            return null;
        else {
            $objects = array();
            while ($row = mysql_fetch_assoc($result)) {
                $objects[] = self::loadById($row['id']);
            }
            return ($objects);
        }
    }


    public static function getHoldBySymbol($userID = null, $symbol = null, $limit = null)
    {
        if ($userID == null) {
            return null;
        }

        $query = sprintf(" SELECT id FROM %s WHERE uid = %d AND symbol = '%s'",
            self::DB_TABLE,
            $userID,
            $symbol
        );
        $db = Db::instance();
        $result = $db->lookup($query);
        if (!mysql_num_rows($result))
            return null;
        else {
//            $objects = array();
//            while($row = mysql_fetch_assoc($result)) {
//                $objects[] = self::loadById($row['id']);
//            }
//            return ($objects);

            $row = mysql_fetch_assoc($result);
//            $obj = new __CLASS__($row);
//            return $obj;
            return $row;
        }
    }


}