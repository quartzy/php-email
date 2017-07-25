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
            foreach ($messages as $nestedMessage) {
                $message .= sprintf("%d) %s: %s\n", $count++, $property, $nestedMessage);
            }
        }

        return new static($message);
    }
}
