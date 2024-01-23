<?php

namespace App\Repository\Contracts;

use App\Http\Resources\AddressResource;
use Illuminate\Database\Eloquent\Model;

interface AddressRepositoryContract extends EloquentRepositoryInterface {

/**
     * Summary of getAllPages
     * @param array $data
     * @return mixed
     */
    public function getAddresses(array $data);
    /**
     * Summary of showPageDetail
     * @param array $input
     * @return AddressResource
     */
    public function addAddress(array $input) : AddressResource;
    /**
     * Summary of deleteAddress
     * @param int $id
     * @return bool
     */
    public function deleteAddress(int $id) : bool;

}
