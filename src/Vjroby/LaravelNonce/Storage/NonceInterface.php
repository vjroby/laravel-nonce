<?php

namespace Vjroby\LaravelNonce\Storage;


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
    public function checkNonce($id, $data = false);

} // end of interface