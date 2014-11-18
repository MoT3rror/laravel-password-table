<?php
class MD5Hasher implements \Illuminate\Hashing\HasherInterface
{
    public function make($value, array $options = array())
    {
        return hash('md5', $value);
    }

    public function check($value, $hashedValue, array $options = array())
    {
        return $this->make($value) === $hashedValue;
    }

    public function needsRehash($hashedValue, array $options = array())
    {
        return true;
    }
}
