<?php

namespace App\Framework;

use App\Framework\Query;
use App\Framework\QueryHandler;

class QueryBus
{
    /**
     * @template TResult
     * @param Query<TResult> $query
     * @return TResult
     */
    public function dispatch(Query $query)
    {
        $queryClass = get_class($query);
        $handlerClass = str_replace('Queries', 'Handlers', $queryClass) . 'Handler';

        $handler = app($handlerClass);

        if (!$handler instanceof QueryHandler) {
            throw new \Exception("Handler {$handlerClass} must implement QueryHandler interface");
        }

        return $handler->handle($query);
    }
}
