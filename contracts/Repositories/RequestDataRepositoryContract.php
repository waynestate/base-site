<?php

namespace Contracts\Repositories;

interface RequestDataRepositoryContract
{
    /**
     * Get data and send it with the request object.
     *
     * @param array $data
     * @return mixed
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function getRequestData(array $data);
}
