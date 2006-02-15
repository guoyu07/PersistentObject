<?php
/**
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @package PersistentObject
 */

/**
 * Main definition of a persistent object.
 *
 * Each persistent object will have exactly one definition. The purpose of
 * the definition is to provide information about how the database table is structured
 * and how it is mapped to the data object.
 *
 * @see ezcPersistentSession for an elaborate example.
 *
 * @package PersistentObject
 */
class ezcPersistentObjectDefinition
{
    /**
     * Name of the database table to use.
     */
    public $table = null;

    /**
     * Class-name of the PersistentObject
     */
    public $class = null;

    /**
     * Holds the identifier property.
     *
     * @var ezcPersistentObjectIdProperty
     */
    public $idProperty = null;

    /**
     * The fields of the Persistent Object as an array of ezcPersistentObjectProperty.
     * The key is the name of the persistent object field name.
     */
    public $properties = array();

    /**
     * The fields of the Persistent Object as an array of ezcPersistentObjectProperty.
     * The key is the name of the original database column.
     */
    public $columns = array();

    /**
     * Constructs a new PersistentObjectDefinition
     */
    public function __construct( $table = '',
                                 $key = '',
                                 $class = '',
                                 $incrementKey = '',
                                 array $properties = array() )
    {
        $this->table = $table;
        $this->primaryKey = $key;
        $this->class = $class;
        $this->incrementKey = $incrementKey;
        $this->properties = $properties;
    }

    /**
     * Returns a new instance of this class with the data specified by $array.
     *
     * $array contains all the data members of this class in the form:
     * array('member_name'=>value).
     *
     * __set_state makes this class exportable with var_export.
     * var_export() generates code, that calls this method when it
     * is parsed with PHP.
     *
     * @param array(string=>mixed)
     * @return ezcPersistentObjectDefinition
     */
    public static function __set_state( array $array )
    {
        return new ezcPersistentObjectDefinition( $array['table'],
                                                  $array['primaryKey'],
                                                  $array['class'],
                                                  $array['incrementKey'],
                                                  $array['properties'] );
    }
}
?>
