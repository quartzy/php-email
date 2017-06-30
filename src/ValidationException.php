<?php

namespace PhpEmail;

class ValidationException extends \InvalidArgumentException
{
    /**
     * @param array $exceptions
     *
     * @return ValidationException
     */
    public static function fromArray(array $exceptions)
    {
        $message = sprintf('Failed %d validations: ', count($exceptions)) . "\n";

        $count = 1;
        foreach ($exceptions as $property => $messages) {
            foreach ($messages as $message) {
                $message .= sprintf("%d) %s: %s\n", $count++, $property, $message);
            }
        }

        return new static($message);
    }
}
