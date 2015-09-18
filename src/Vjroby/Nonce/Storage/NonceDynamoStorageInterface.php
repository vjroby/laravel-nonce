<?php
/**
 * Created for nonce.
 * User: Robert Gabriel Dinu
 * Date: 9/17/15
 * Time: 16:05
 */

namespace Vjroby\LaravelNonce\Storage;


interface NonceDynamoStorageInterface
{
    const REQUEST_ITEMS  = 'RequestItems';
    const ORDERS = 'Orders';
    const PUT_REQUEST = 'PutRequest';
    const TABLE_NAME = 'TableName';
    const ITEM = 'Item';
    const ITEM_COUNT = 'ItemCount';
    const COUNT = 'Count';

    const TYPE_STRING = 'S';
    /**
     * A String Set data type.
     */
    const TYPE_STRING_ARRAY = 'SS';
    /**
     * A Number data type.
     */
    const TYPE_NUMBER = 'N';
    /**
     * A Number Set data type.
     */
    const TYPE_NUMBER_ARRAY = 'NS';
    const TYPE_BINARY = 'B';
    /**
     * A Binary Set data type.
     */
    const TYPE_BINARY_SET = 'BS';
    /**
     * Associative array of <string> keys mapping to (associative-array) values.
     * Each array key should be changed to an appropriate <string>.
     * A Map of attribute values.
     * associative-array<associative-array>
     */
    const TYPE_MAP_ASSOCIATIVE_ARRAY = ' M';
    /**
     * A List of attribute values.
     *  (array<associative-array>)
     */
    const TYPE_LIST_ASSOCIATIVE_ARRAY = 'l';
    /**
     * A Null data type.
     * bool
     */
    const TYPE_NULL = 'NULL';
    /**
     * A Boolean data type.
     * bool
     */
    const TYPE_BOOL= 'BOOL';
    /**
     * @param $awsClient
     * @return mixed
     */
    public function setClient($awsClient);

    /**
     * @param string $tableName
     * @return mixed
     */
    public function setTableName($tableName);

} // end of interface