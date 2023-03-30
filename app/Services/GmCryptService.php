<?php

namespace App\Services;

class GmCryptService
{
    protected $key;
    protected $keylen;

    /**
     * construct
     * @param string $plat 平台
     */
    public function __construct($plat = 'www')
    {
        if ($plat == 'www') {
            $this->key = '&&&#47al!@';
        } elseif ($plat == 'mobile') {
            $this->key = '5%*G9D&>+)!';
        }

        $this->keylen = strlen($this->key);
    }

    /**
     * 加密字串
     * @param string $input 欲加密的字串
     * @return string
     */
    public function encode($input)
    {
        $l = 0;
        $c = 0;
        $result = '';

        for ($i = 0; $i < strlen($input); $i++) {
            $pick = substr($input, $i, 1);
            $t = ord($pick) ^ ord(substr($this->key, $l, 1));
            $t2 = $t & 15;
            $t = $t >> 4;
            $tmp = chr($t + ord('A'));
            $result = $result . $tmp;
            $tmp = chr($t2 + ord('A'));
            $result = $result . $tmp;
            $l++;
            $l = $l % ($this->keylen - 1);
        }

        return $result;
    }

    /**
     * 解密字串
     * @param string $input 欲解密的字串
     * @return string
     */
    public function decode($input)
    {
        $l = 0;
        $c = 0;
        $result = '';

        for ($i = 0; $i < strlen($input); $i++) {
            $pick = substr($input, $i, 1);

            if (ord($pick) >= ord('A') && ord($pick) <= ord('Q')) {
                $v = ord($pick) - ord('A');
            } else {
                $v = 0;
            }

            $c = $c << 4;
            $c = $c | $v;

            if ($i % 2 == 1) {
                $c = $c ^ ord(substr($this->key, $l, 1));

                $result = $result . chr($c);
                $c = 0;
                $l++;
                $l = $l % ($this->keylen - 1);
            }
        }

        return $result;
    }
}
