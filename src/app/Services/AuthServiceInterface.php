<?php

namespace App\Services;

/**
 * Interface AuthServiceInterface
 * @package App\Services
 */
interface AuthServiceInterface
{
    /**
     * @param array $data
     * @return string
     */
    public function login(array $data) : string;

    /**
     * @param array $data
     * @return string
     */
    public function register(array $data) : string;
}
