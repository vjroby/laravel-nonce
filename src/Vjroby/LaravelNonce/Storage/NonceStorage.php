<?php
/**
 * Created by PhpStorm.
 * User: Robert Gabriel Dinu
 * Date: 12/18/14
 * Time: 11:45
 */

namespace Vjroby\LaravelNonce\Storage;

use Carbon\Carbon;
use Illuminate\Database\ConnectionResolverInterface as Resolver;


class NonceStorage implements NonceInterface{

    /**
     * @var \Illuminate\Database\ConnectionResolverInterface
     */
    protected $connection;

    /**
     * @var string
     */
    protected $connectionName;

    public function __construct($connection = null){
        $this->connection = \DB::connection($connection);
    }

    public function setResolver(Resolver $resolver)
    {
        $this->connection = $resolver;
    }


    public function setConnectionName($connectionName)
    {
        $this->connectionName = $connectionName;
    }

    protected function getConnection()
    {
        return $this->connection;
    }
    /**
     * @param $id - string max 40 chars
     * @param $data - text
     * @return mixed
     */
    public function setNonce($id, $data)
    {
        $this->getConnection()->table('nonce')
            ->insert([
                'id' => $id,
                'data' => $data,
                'created_at' => Carbon::now()
            ]);
    }

    /**
     * @param $id - string max 40 chars
     * @param $data - text
     * @return mixed
     */
    public function checkNonce($id, $data = false)
    {
        if ($data === false){
            $query = $this->checkNonceWithoutData($id);
        }else{
            $query = $this->checkNonceWithData($id,$data);
        }


        if (count($query) == 0){
            return true;
        }else{
            return false;
        }

    }

    protected function checkNonceWithData($id, $data)
    {
        return $query = $this->getConnection()->table('nonce')
            ->select('nonce.id')
            ->where('id', '=',$id)
            ->where('data', '=', $data)->get();
    }

    protected function checkNonceWithoutData($id)
    {
        return $query = $this->getConnection()->table('nonce')
            ->select('nonce.id')
            ->where('id', '=',$id)->get();
    }

} // end of class