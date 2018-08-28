<?php

class Conta extends TRecord
{
    const TABLENAME  = 'conta';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}
    
    
    private $agencia;
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('chave_origem');
        parent::addAttribute('numero_conta');
        parent::addAttribute('chave_primaria_agencia');
        parent::addAttribute('data_hora_criacao');
        parent::addAttribute('ultima_atualizacao');
        parent::addAttribute('qt_atualizacoes');
        parent::addAttribute('agencia_id');
    }

    /**
     * Method set_agencia
     * Sample of usage: $var->agencia = $object;
     * @param $object Instance of Agencia
     */
    public function set_agencia(Agencia $object)
    {
        $this->agencia = $object;
        $this->agencia_id = $object->id;
    }
    
    /**
     * Method get_agencia
     * Sample of usage: $var->agencia->attribute;
     * @returns Agencia instance
     */
    public function get_agencia()
    {
        
        // loads the associated object
        if (empty($this->agencia))
            $this->agencia = new Agencia($this->agencia_id);
        
        // returns the associated object
        return $this->agencia;
    }
    
}

