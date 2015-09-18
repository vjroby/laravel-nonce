<?php

namespace Vjroby\LaravelNonce\Storage;

use Aws\DynamoDb\DynamoDbClient;
use Carbon\Carbon;

class NonceDynamoStorage implements NonceInterface, NonceDynamoStorageInterface
{
    const TOKEN_FIELD = 'token';
    const CREATED_AT_FIELD = 'created_at';
    const DATA_FIELD = 'data';
    const DATA = 'Data';
    const CONSISTENT_READ = "ConsistentRead";


    /**
     * @var DynamoDbClient
     */
    protected $client;

    /**
     * @var
     */
    protected $tableName;

    /**
     * @return mixed
     */
    protected function getTableName()
    {
        return $this->tableName;
    }

    /**
     * @return DynamoDbClient
     */
    protected function getClient()
    {
        return $this->client;
    }

    /**
     * @param $id - string max 40 chars
     * @param $data - text
     * @return mixed
     */
    public function setNonce($id, $data)
    {
        $data = (is_null($data) || strlen($data) == 0)
            ? [self::TYPE_NULL => true] : [self::TYPE_STRING => $data];
        return $this->getClient()->putItem([
                self::TABLE_NAME => $this->getTableName(),
                self::ITEM => [
                    self::TOKEN_FIELD => [
                        self::TYPE_STRING => $id
                    ],
                    self::DATA_FIELD => $data,
                    self::CREATED_AT_FIELD => [
                        self::TYPE_STRING => Carbon::now()->format('Y-m-d H:i:s'),
                    ]
                ]
            ]
        );
    }

    /**
     * @param $id - string max 40 chars
     * @param $data - text
     * @return mixed
     */
    public function checkNonce($id, $data)
    {
        $item = $this->getItem($id, $data);
        return is_null($item);
    }

    /**
     * @param $awsClient
     * @return void
     */
    public function setClient($awsClient)
    {
        $this->client = $awsClient;
    }

    /**
     * @param string $tableName
     * @return mixed
     */
    public function setTableName($tableName)
    {
        $this->tableName = $tableName;
    }

    /**
     * @param $id
     * @param $data
     * @return mixed|null
     */
    protected function getItem($id, $data)
    {
        $response = $this->getClient()->getItem([
            self::TABLE_NAME => $this->getTableName(),
            "Key" => [
                self::TOKEN_FIELD => [
                    self::TYPE_STRING => $id
                ],
            ],
            self::CONSISTENT_READ => true

        ]);

        return $response->get(self::ITEM);
    }

}