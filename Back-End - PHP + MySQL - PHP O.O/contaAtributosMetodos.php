<?php
    Class Conta {
        public $saldo = 0;
        public $titular;

        function depositar($valor) {
            echo "Depositando: ".$valor."<br>";
            $this->saldo += $valor;
        }

        function sacar($valor) {
            echo "Sacando: ".$valor."<br>";
            if(($this->saldo > 0) && ($this->saldo >= $valor)) {
                $this->saldo -= $valor;
            } else {
                echo "Saldo insuficiente.<br><br>";
            }
        }

        function verSaldo (){
            echo "Saldo Atual: ".$this->saldo. "<br><br>";
        }
    }

    class ContaCorrente extends Conta {
        function transferir($contaDestino, $valor) {
            $this->saldo -= $valor;
        }
    }

    $novaConta = new Conta();
    $novaConta->verSaldo();
    $novaConta->depositar(500);
    $novaConta->verSaldo();
    $novaConta->sacar(1150);
    $novaConta->verSaldo();

    // Herança 
    $contaCorrente = new ContaCorrente();
    $contaCorrente->transferir('xxx-xxx', 500);
    echo $contaCorrente->verSaldo();
?>