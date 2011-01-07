<?php

namespace Scm\Exception;

use Scm\Command\Command;

class CommandFailedException extends \RuntimeException
{
    protected $command;
    protected $parameters;

    public function __construct(CommandInterface $command, array $parameters, $code=0, $previous=null)
    {
        $this->command = $command;
        $this->parameters = $parameters;

        $message = $command.' command failed with parameters '.print_r($parameters, true);
        parent::__construct($message, $code, $previous);
    }

    public function getCommand()
    {
        return $this->command;
    }

    public function getParameters()
    {
        return $this->parameters;
    }
}