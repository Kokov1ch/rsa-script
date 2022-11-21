<?php
declare(strict_types=1);
class Rsa
{

    public static function calculateD(int $value):int
    {
        $d = $value - 1;
        for ($i = 2; $i <= $value; $i++){
            if(($value % $i == 0) && ($d % $i == 0)){
                $d--;
                $i = 1;
            }
        }
        return $d;
    }

    public static function calculateE(int $d, int $value):int
    {
        $e = 10;
        while (true)
        {
            if (($e * $d) % $value == 1)
                break;
            else
                $e++;
        }
        return $e;
    }

    public static function isSimple($value):bool
    {
        if ($value < 2)
            return false;

        if ($value == 2)
            return true;

        for ($i = 2; $i < $value-1; $i++){
            if ($value % $i == 0)
                return false;
        }

        return true;
    }

    public static function encrypt(string $s, int $e, int $n):array
    {
        $result = array();
        $chars = str_split($s);
       foreach ($chars as $char){
           $big = gmp_pow(ord($char), $e);
           $big = gmp_mod($big, $n);
           $result[] = gmp_strval($big);
        }
        return $result;
    }

    public static function decrypt(array $input, int $d, int $n):string
    {
        $result = "";
        foreach ($input as $value){
            $big = gmp_init($value);
            $big = gmp_pow($big, $d);
            $big = gmp_mod($big, $n);
            $result= strval($big);
        }
        return $result;
    }
}