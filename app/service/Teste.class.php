<?php

class Teste{

    public static function escreve()
    {
        $fp = fopen("C:\Users\user\OneDrive\CURSO_ADIANTI_FRAMEWORKS\Projetos\cobranca\app\service\bloco1.txt", "a");
         
        // Escreve "exemplo de escrita" no bloco1.txt
        $escreve = fwrite($fp, date("Y-m-d h:m:s"). "\n");
         
        // Fecha o arquivo
        fclose($fp);
    }
}