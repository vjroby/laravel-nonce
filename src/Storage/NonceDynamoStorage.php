<?php

namespace Vjroby\LaravelNonce\Storage;

use Aws\DynamoDb\DynamoDbClient;

class NonceDynamoStorage implements NonceInterface
{

    /**
     * @param $id - string max 40 chars
     * @param $data - text
     * @return mixed
     */
    public function setNonce($id, $data)
    {
        // TODO: Implement setNonce() method.
    }

    /**
     * @param $id - string max 40 chars
     * @param $data - text
     * @return mixed
     */
    public function checkNonce($id, $data)
    {
        // TODO: Implement checkNonce() method.
    }
}