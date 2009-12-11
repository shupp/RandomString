<?php

/**
 * RandomString 
 * 
 * @author    Bill Shupp <hostmaster@shupp.org> 
 * @copyright 2009 Bill Shupp
 * @license   BSD
 */
class RandomString
{
    const LOWER   = 'abcdefghijklmnopqrstufwxyz';
    const UPPER   = 'ABCDEFGHIJKLMNOPQRSTUFWXYZ';
    const NUMBERS = '1234567890';
    const CHARS   = '!@#$%^&*(){}[]:;|';

    protected $useLower   = true;
    protected $useUpper   = true;
    protected $useNumbers = true;
    protected $useChars   = true;
    protected $length     = 8;
    protected $lines      = 1;

    /**
     * Set your options
     * 
     * @param string $option The option to set
     * @param mixed  $value  The option's value
     * 
     * @throws Exception on invalid option
     * @return void
     */
    public function setOption($option, $value)
    {
        switch ($option) {
            case 'useLower':
                $this->useLower = (bool) $value;
                break;
            case 'useUpper':
                $this->useUpper = (bool) $value;
                break;
            case 'useNumbers':
                $this->useNumbers = (bool) $value;
                break;
            case 'useChars':
                $this->useChars = (bool) $value;
                break;
            case 'length':
                $this->length = (int) $value;
                break;
            case 'lines':
                $this->lines = (int) $value;
                break;
            default:
                throw new Exception('invalid option');
        }
    }

    /**
     * Sets an array of options in one go
     * 
     * @param array $options Options as an associative array
     * 
     * @throws Exception on any invalid options
     * @return void
     */
    public function setOptions(array $options)
    {
        foreach ($options as $key => $val) {
            $this->setOption($key, $val);
        }
    }

    /**
     * Builds a random string
     * 
     * @return string
     */
    public function buildString()
    {
        $chars = '';

        if ($this->useLower) {
            $chars .= self::LOWER;
        }
        if ($this->useUpper) {
            $chars .= self::UPPER;
        }
        if ($this->useNumbers) {
            $chars .= self::NUMBERS;
        }
        if ($this->useChars) {
            $chars .= self::CHARS;
        }

        if (strlen($chars) == 0) {
            throw new Exception('No character sets selected');
        }

        $string = '';
        for ($i = 0; $i < $this->length; $i++) {
            $string .= $chars[mt_rand(0, strlen($chars) -1)];
        }

        return $string;
    }

    /**
     * Gets an array of random strings
     * 
     * @return array
     */
    public function getStrings()
    {
        $strings = array();
        for ($i = 0; $i < $this->lines; $i++) {
            $strings[] = $this->buildString();
        }
        return $strings;
    }
}

?>
