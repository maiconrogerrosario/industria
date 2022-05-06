<?php

namespace Source\Models;

use Source\Core\Model;

/**
 * FSPHP | Class User Active Record Pattern
 *
 * @author Robson V. Leite <cursos@upinside.com.br>
 * @package Source\Models
 */
class Works extends Model
{
    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct("works", ["id"], ["customer_id", "name"]);
    }

    /**
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     * @param string $password
     * @param string|null $document
     * @return User
     */
	 
	
	 
    public function bootstrap(
	    string $application_id,	
        string $customer_id,
		string $name,
		string $address_street,
		string $address_number,
		string $address_neighborhood,
		string $address_complement,
	    string $address_postalcode,
		string $address_city,
		string $address_state,
		string $address_country,
		string $observation,
		string $date_initial,
		string $date_final,	
		string $status,
		string $projectcost,	
		string $photo1,
		string $photo2
    ): Works {
		$this->application_id = $application_id;
		$this->customer_id = $customer_id;
		$this->name = $name;
		$this->address_street = $address_street;
		$this->address_number = $address_number;
		$this->address_neighborhood = $address_neighborhood;
		$this->address_complement = $address_complement;
		$this->address_postalcode = $address_postalcode;
		$this->address_city = $address_city;
		$this->address_state = $address_state;
		$this->address_country = $address_country;
		$this->observation = $observation;
		$this->date_initial = $date_initial;
		$this->date_final = $date_final;
		$this->projectcost = $projectcost;
		$this->status = $status;
		$this->photo1 = $photo1;
		$this->photo2 = $photo2;
		
        return $this;
    }
		

    public function findByName(string $name,string $application_id, string $columns = "*"): ?Works
    {
        $find = $this->find("name = :name AND application_id = :application_id ", "name={$name}&application_id={$application_id}", $columns);
        return $find->fetch();
    } 


	public function getCustomer(): ?Customer
	{ 
		if ($this->customer_id) {
			
			 return (new Customer())->findById($this->customer_id);
        }
		
        return null;	
	}	




    /**
     * @return bool
     */
    public function save(): bool
    {
        if (!$this->required()) {
            $this->message->warning("Nome, sobrenome, email e senha são obrigatórios");
            return false;
        }
   

        /** User Update */
        if (!empty($this->id)) {
            $workId = $this->id;

            if ($this->find("name = :name AND id != :i", "name={$this->name}&i={$workId}", "id")->fetch()) {
                $this->message->warning("O e-mail informado já está cadastrado");
                return false;
            }

            $this->update($this->safe(), "id = :id", "id={$workId}");
            if ($this->fail()) {
                $this->message->error("Erro ao atualizar, verifique os dados");
                return false;
            }
        }

        /** User Create */
        if (empty($this->id)) {
            if ($this->findByName($this->name,$this->application_id, "id")) {
                $this->message->warning("Esse Projeto já esta Cadastrado");
                return false;
            }

            $workId = $this->create($this->safe());
            if ($this->fail()) {
                $this->message->error("Erro ao cadastrar, verifique os dados");
                return false;
            }
        }

        $this->data = ($this->findById($workId))->data();
        return true;
    }
	
}