<?php

namespace App\Framework;

class CommandBus
{
    /**
     * @template TResult
     * @param  Command<TResult>  $command
     * @return TResult
     * @throws \Exception
     */
    public static function dispatch(Command $command)
    {
        $commandClass = get_class($command);
        $handlerClass = str_replace('Commands', 'Handlers', $commandClass) . 'Handler';

        $handler = app($handlerClass);

        if (!$handler instanceof CommandHandler) {
            throw new \Exception("Handler {$handlerClass} must implement CommandHandler interface");
        }

        return $handler->handle($command);
    }
}
