<?php
    
class ImportService{

    public static function importDados()
    {   
    
        $fp = fopen("C:\Users\user\OneDrive\CURSO_ADIANTI_FRAMEWORKS\Projetos\cobranca\app\service\log_importacao.txt", "a");
         
        $hora_inicio = new DateTime(date('d-m-Y H:i:s'));
        
        $texto = "Inicio da importacao ---------------------------------------- ". date('d-m-Y H:i:s'). "\n";
        echo $texto;
        $escreve = fwrite($fp, $texto);
        
        $texto = "Importando agencias. ". date('d-m-Y H:i:s'). "\n";
        echo $texto;
        $escreve = fwrite($fp, $texto);
        
        try
        { 
            I_AgenciaService::importAgencia();
        }
        catch(Exception $e)
        {
            $escreve = fwrite($fp, $e->getMessage(). date('d-m-Y H:i:s'). "\n");        
        }
        
        $texto = "Importando Bancos.". date('d-m-Y H:i:s'). "\n";      
        echo $texto;
        $escreve = fwrite($fp, $texto);
        
        try
        { 
           I_BancoService::importBancos();
        }
        catch(Exception $e)
        {
            $escreve = fwrite($fp, $e->getMessage(). date('d-m-Y H:i:s'). "\n");        
        } 
        
        
        $texto = "Importando cidades." . date('d-m-Y H:i:s'). "\n";      
        echo $texto;
        $escreve = fwrite($fp, $texto);
        
        try
        { 
            I_CidadeService::importCidades();
        }
        catch(Exception $e)
        {
            $escreve = fwrite($fp, $e->getMessage(). date('d-m-Y H:i:s'). "\n");        
        } 
       
        
        $texto = "Importando clientes." . date('d-m-Y H:i:s'). "\n";      
        echo $texto;
        $escreve = fwrite($fp, $texto);
        
        try
        { 
            I_ClienteService::importClientes();
        }
        catch(Exception $e)
        {
            $escreve = fwrite($fp, $e->getMessage(). date('d-m-Y H:i:s'). "\n");        
        } 
        
        
        $texto = "Importando contas bancarias." . date('d-m-Y H:i:s'). "\n";      
        echo $texto;
        $escreve = fwrite($fp, $texto);
        
        try
        { 
           I_ContaService::importContas();
        }
        catch(Exception $e)
        {
            $escreve = fwrite($fp, $e->getMessage(). date('d-m-Y H:i:s'). "\n");        
        }
        
        
        $texto = "Importando estados." . date('d-m-Y H:i:s'). "\n";      
        echo $texto;
        $escreve = fwrite($fp, $texto);
        
        try
        { 
            I_EstadoService::importEstados();
        }
        catch(Exception $e)
        {
            $escreve = fwrite($fp, $e->getMessage(). date('d-m-Y H:i:s'). "\n");        
        }
       
        
        $texto = "Importando paises." . date('d-m-Y H:i:s'). "\n";      
        echo $texto;
        $escreve = fwrite($fp, $texto);
        
        try
        { 
            I_PaisService::importPaises();
        }
        catch(Exception $e)
        {
            $escreve = fwrite($fp, $e->getMessage(). date('d-m-Y H:i:s'). "\n");        
        }
        
        
        $texto = "Importando parcelas." . date('d-m-Y H:i:s'). "\n";      
        echo $texto;
        $escreve = fwrite($fp, $texto);
        
        try
        { 
            I_ParcelaService::importParcelas();
        }
        catch(Exception $e)
        {
            $escreve = fwrite($fp, $e->getMessage(). date('d-m-Y H:i:s'). "\n");        
        }
        
        
        $texto = "Importando titulos." . date('d-m-Y H:i:s'). "\n";      
        echo $texto;
        $escreve = fwrite($fp, $texto);
        
        try
        { 
            I_TituloService::importTitulos();
        }
        catch(Exception $e)
        {
            $escreve = fwrite($fp, $e->getMessage(). date('d-m-Y H:i:s'). "\n");        
        }
        
        
        $texto = "Fim da importacao ---------------------------------------- ". date('d-m-Y H:i:s'). "\n";      
        echo $texto;
        $escreve = fwrite($fp, $texto);
                
        $hora_fim = new DateTime( date('d-m-Y H:i:s'));
        
        
        
        $diferenca = $hora_inicio->diff($hora_fim);
        
        $texto = "Tempo de processamento --------------------------------- ". $diferenca->format( '%H Horas, %i Minutos e %s Segundos' ). "\n";      
        echo $texto;
        $escreve = fwrite($fp, $texto);
        
       
        fclose($fp);
    }

}
