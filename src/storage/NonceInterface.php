<?php

namespace Vjroby\LaravelNonce;


interface NonceInterface {

    /**
     * @param $id - string max 40 chars
     * @param $data - text
     * @return mixed
     */
    public function setNonce($id, $data);

    /**
     * @param $id - string max 40 chars
     * @param $data - text
     * @return mixed
     */
    public function checkNonce($id, $data);

} // end of interface