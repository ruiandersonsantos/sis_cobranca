<?php
    
class ImportService{

    public static function importDados()
    {    
        $hora_inicio = new DateTime(date('d-m-Y H:i:s'));
        
        echo "Inicio da importacao ---------------------------------------- ". date('d-m-Y H:i:s'). "\n";
        
        echo "Importando agencias. ". date('d-m-Y H:i:s'). "\n";
        I_AgenciaService::importAgencia();
       
        echo "Importando Bancos.". date('d-m-Y H:i:s'). "\n";
        I_BancoService::importBancos();
        
        echo "Importando cidades." . date('d-m-Y H:i:s'). "\n";
        I_CidadeService::importCidades();
        
        echo "Importando clientes." . date('d-m-Y H:i:s'). "\n";
        I_ClienteService::importClientes();
        
        echo "Importando contas bancarias." . date('d-m-Y H:i:s'). "\n";
        I_ContaService::importContas();
        
        echo "Importando estados." . date('d-m-Y H:i:s'). "\n";
        I_EstadoService::importEstados();
        
        echo "Importando paises." . date('d-m-Y H:i:s'). "\n";
        I_PaisService::importPaises();
        
        echo "Importando parcelas." . date('d-m-Y H:i:s'). "\n";
        I_ParcelaService::importParcelas();
        
        echo "Importando titulos." . date('d-m-Y H:i:s'). "\n";
        I_TituloService::importTitulos();
        
        echo "Fim da importacao ---------------------------------------- ". date('d-m-Y H:i:s'). "\n";
        
        $hora_fim = new DateTime( date('d-m-Y H:i:s'));
        
        
        
        $diferenca = $hora_inicio->diff($hora_fim);
        
        echo "Tempo de processamento --------------------------------- ". $diferenca->format( '%H Horas, %i Minutos e %s Segundos' ). "\n";
       
    }

}
