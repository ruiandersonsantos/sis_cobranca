<?php

class Contato extends TRecord
{
    const TABLENAME  = 'contato';
    const PRIMARYKEY = 'in';
    const IDPOLICY   =  'serial'; // {max, serial}
    
    
    private $cliente;
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('nome');
        parent::addAttribute('email');
        parent::addAttribute('telefone');
        parent::addAttribute('celular');
        parent::addAttribute('observacoes');
        parent::addAttribute('cliente_id');
        parent::addAttribute('data_hora_criacao');
        parent::addAttribute('ultima_atualizacao');
        parent::addAttribute('qt_atualizacoes');
    }

    /**
     * Method set_cliente
     * Sample of usage: $var->cliente = $object;
     * @param $object Instance of Cliente
     */
    public function set_cliente(Cliente $object)
    {
        $this->cliente = $object;
        $this->cliente_id = $object->id;
    }
    
    /**
     * Method get_cliente
     * Sample of usage: $var->cliente->attribute;
     * @returns Cliente instance
     */
    public function get_cliente()
    {
        
        // loads the associated object
        if (empty($this->cliente))
            $this->cliente = new Cliente($this->cliente_id);
        
        // returns the associated object
        return $this->cliente;
    }
    
}

