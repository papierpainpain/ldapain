<?php

namespace Api\Models;

use \Hackzilla\PasswordGenerator\Generator\ComputerPasswordGenerator;

/**
 * Class Password
 * 
 * @package Api\Models
 */
class Password
{
    /**
     * Generate a random password with the following rules:
     * - At least one number
     * - At least one special character
     * - At least one uppercase letter
     * - At least one lowercase letter
     * - At least 8 characters
     * 
     * @return string
     */
    public static function generate(): string
    {
        $generator = new ComputerPasswordGenerator();

        $generator->setUppercase();
        $generator->setLowercase();
        $generator->setNumbers();
        $generator->setSymbols();
        $generator->setLength(rand(8, 16));

        return $generator->generatePasswords()[0];
    }

    /**
     * Check if the password is valid with the following rules:
     * - At least one number
     * - At least one special character
     * - At least one uppercase letter
     * - At least one lowercase letter
     * - At least 8 characters
     * 
     * @param string $password
     * @return bool
     */
    public static function isValid(string $password): bool
    {
        // Contains at least one number
        if (!preg_match('/[0-9]/', $password)) {
            return false;
        }

        // Contains at least one special character
        if (!preg_match("/[\[^\'£$%^&*()}{@:\'#~?><>,;@\|\\\-=\-_+\-¬\`\]]/", $password)) {
            return false;
        }

        // Contains at least one uppercase letter
        if (!preg_match('/[A-Z]/', $password)) {
            return false;
        }

        // Contains at least one lowercase letter
        if (!preg_match('/[a-z]/', $password)) {
            return false;
        }

        // Contains at least 8 characters
        if (strlen($password) < 8) {
            return false;
        }

        return true;
    }
}
