<?php
    //Implementar a Class Conta
    class ContaCorrente extends Conta {
        function transferir($contaDestino, $valor) {
            $this->saldo -= $valor;
        }
    }
?>