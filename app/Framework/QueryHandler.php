<?php

namespace App\Framework;

interface QueryHandler
{
    public function handle(Query $query);
}
