<?php

namespace App\Repository\Contracts;

interface FaqRepositoryInterface extends EloquentRepositoryInterface {


    /**
     * Summary of getAllFaqs
     * @param array $data
     * @return mixed
     */
    public function getAllFaqs(array $data);
    /**
     * @param array $data
     * @return \App\Http\Resources\Vendor\FaqResource
     */
    public function createFaq(array $data) : \App\Http\Resources\Vendor\FaqResource;
    /**
     * @param int $id
     * @return \App\Http\Resources\Vendor\FaqResource
     */
    public function getFaqById(int $id)  : \App\Http\Resources\Vendor\FaqResource;
    /**
     * Summary of updateFaq
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function updateFaq(int $id, array $data) : bool;
    /**
     * Summary of deleteFaq
     * @param int $id
     * @return bool
     */
    public function deleteFaq(int $id) : bool;

}
