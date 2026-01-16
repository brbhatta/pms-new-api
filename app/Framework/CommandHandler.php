<?php

namespace App\Framework;

interface CommandHandler
{
    public function handle(Command $command);
}
