<?php

namespace Contracts\Repositories;

interface HeroRepositoryContract
{
    /**
     * {@inheritdoc}
     */
    public function setHero(array $promos, array $data);
}
