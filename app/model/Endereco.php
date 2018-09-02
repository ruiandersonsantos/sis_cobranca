<?php

class Endereco extends TRecord
{
    const TABLENAME  = 'endereco';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}
    
    
    private $cidade;
    private $cliente;
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('cep');
        parent::addAttribute('logradouro');
        parent::addAttribute('numero');
        parent::addAttribute('bairro');
        parent::addAttribute('complemento');
        parent::addAttribute('cliente_id');
        parent::addAttribute('data_hora_criacao');
        parent::addAttribute('ultima_atualizacao');
        parent::addAttribute('qt_atualizacoes');
        parent::addAttribute('cidade_id');
    }

    /**
     * Method set_cidade
     * Sample of usage: $var->cidade = $object;
     * @param $object Instance of Cidade
     */
    public function set_cidade(Cidade $object)
    {
        $this->cidade = $object;
        $this->cidade_id = $object->id;
    }
    
    /**
     * Method get_cidade
     * Sample of usage: $var->cidade->attribute;
     * @returns Cidade instance
     */
    public function get_cidade()
    {
        
        // loads the associated object
        if (empty($this->cidade))
            $this->cidade = new Cidade($this->cidade_id);
        
        // returns the associated object
        return $this->cidade;
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

