<?php
declare(strict_types=1);
require_once ('rsa.php');
class Manager
{
    private Rsa $rsa;
    private string $text;
    public array $encrypted;
    private int $e;
    private int $d;
    private int $n;
    public function __construct()
    {
        $this->rsa = new Rsa();
    }

    public function setText(string $text)
    {
        $this->text = $text;
    }
    public function getText():string
    {
        return $this->text;
    }
    public function getEncrypted():string
    {
        $result = implode(' ', $this->encrypted);
        return $result;
    }
    public function encrypt(string $input,int $p, int $q)
    {
        if ($this->rsa->isSimple($p) && $this->rsa->isSimple($q)) {
            $this->text = $input;
            $this->n = $p * $q;
            $m = ($p - 1) * ($q - 1);
            $this->d = $this->rsa->calculateD($m);
            $this->e = $this->rsa->calculateE($this->d, $m);
            $this->encrypted = $this->rsa->encrypt($this->text, $this->e, $this->n);
        }
        else
            echo 'Числа p и p не простые!';
    }
    public function decrypt():string
    {
        if (isset($this->decrypted) && isset($this->d) && isset($this->e))
            return $this->rsa->decrypt($this->encrypted,$this->d, $this->n);
        else
            return 'Зашифрованный текст не найден!';
    }
}