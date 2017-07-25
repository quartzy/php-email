<?php

namespace PhpEmail;

use Closure;

/**
 * @internal
 */
class Validate
{
    /**
     * @var array
     */
    private $validations = [];

    /**
     * @param string  $property   The name of the property the function validates
     * @param Closure $validation
     * @param string  $message
     */
    public function is($property, Closure $validation, $message)
    {
        if (array_key_exists($property, $this->validations)) {
            $this->validations[$property][] = [$validation, $message];
        } else {
            $this->validations[$property] = [[$validation, $message]];
        }
    }

    /**
     * @return Validate
     */
    public static function that()
    {
        return new static();
    }

    /**
     * @param string $property
     * @param mixed  $value
     *
     * @return Validate
     */
    public function isString($property, $value)
    {
        $this->is($property, function () use ($value) {
            return is_string($value);
        }, sprintf('Value expected to be string, type %s given.', gettype($value)));

        return $this;
    }

    /**
     * @param string $property
     * @param $value
     *
     * @return Validate
     */
    public function isNullOrString($property, $value)
    {
        $this->is($property, function () use ($value) {
            return is_null($value) || is_string($value);
        }, sprintf('Value expected to be string, type %s given.', gettype($value)));

        return $this;
    }

    /**
     * @param string $property
     * @param mixed  $value
     *
     * @return Validate
     */
    public function isEmail($property, $value)
    {
        $this->is($property, function () use ($value) {
            return filter_var($value, FILTER_VALIDATE_EMAIL);
        }, sprintf('Value expected to be a valid email address.'));

        return $this;
    }

    /**
     * @param string $property
     * @param array  $list
     * @param string $type
     *
     * @return Validate
     */
    public function allInstanceOf($property, array $list, $type)
    {
        $this->is($property, function () use ($list, $type) {
            foreach ($list as $element) {
                if (!$element instanceof $type) {
                    return false;
                }
            }

            return true;
        }, sprintf('All values were expected to be type %s', $type));

        return $this;
    }

    /**
     * @param string $property
     * @param mixed  $value
     * @param int    $length
     *
     * @return Validate
     */
    public function hasMinLength($property, $value, $length)
    {
        $this->is($property, function () use ($value, $length) {
            return is_string($value) && mb_strlen($value) >= $length;
        }, sprintf('Value must have a minimum length of %d', $length));

        return $this;
    }

    /**
     * @param string $property
     * @param mixed  $value
     *
     * @return Validate
     */
    public function isFile($property, $value)
    {
        $this->is($property, function () use ($value) {
            return is_string($value) && is_file($value);
        }, sprintf('Value must be a file that exists in the system'));

        return $this;
    }

    /**
     * @throws ValidationException
     *
     * @return void
     */
    public function now()
    {
        $exceptions = [];

        foreach ($this->validations as $property => $validation) {
            foreach ($validation as $expectation) {
                if (!call_user_func($expectation[0])) {
                    if (array_key_exists($property, $exceptions)) {
                        $exceptions[$property][] = $expectation[1];
                    } else {
                        $exceptions[$property] = [$expectation[1]];
                    }
                }
            }
        }

        if ($exceptions) {
            throw ValidationException::fromArray($exceptions);
        }
    }
}
