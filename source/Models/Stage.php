<?php

namespace Source\Models;

use Source\Core\Model;
use Source\Models\User;
use Source\Support\Pager;

/**
 * FSPHP | Class User Active Record Pattern
 *
 * @author Robson V. Leite <cursos@upinside.com.br>
 * @package Source\Models
 */
class Stage extends Model
{
	
	

    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct("stage", ["id"], ["application_id","work_id", "stage_name","date_initial","date_final","duration"]);
		
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
		string $work_id,
		string $stage_name,
		string $status,
        string $date_initial,
		string $date_final,
		string $duration,
		string $annotations
    ): Stage{
		$this->application_id = $application_id;
		$this->work_id = $work_id;
		$this->stage_name = $stage_name;
		$this->status = $status;
        $this->date_initial = $time_initial;
		$this->date_final = $date_final;
		$this->duration = $duration;
		$this->annotations = $annotations;
        return $this;
    }		
	
		
	public function findStage(string $application_id, string $work_id, string $stage_name, string $date_initial, string $date_final, string $duration, string $columns = "*"): ?Stage
    {	
		$find = $this->find("application_id = :application_id AND work_id = :work_id AND  stage_name= :stage_name AND date_initial = :date_initial AND date_final = :date_final AND  duration = :duration", "application_id={$application_id}&stage_name={$stage_name}&date_initial={$date_initial}&date_final={$date_final}&duration={$duration}", $columns);
		
        return $find->fetch();		
    }
	
    public function getStage(): ?StageCategory
	{ 

		if ($this->stage_id) {
			
            return (new StageCategory())->findById($this->stage_id);
			
        }
		
        return null;
		
	}
	
	public function getWork(): ?Works
	{ 

		if ($this->work_id) {
			
            return (new Works())->findById($this->work_id);
			
        }
		
        return null;

	}
	

	public function status(User $user, string $id): ?object
	{ 

		$status = $this->find(
            "user_id = :user",
            "user={$user->id}&id={$id}",
            "
                (SELECT status FROM stage WHERE user_id = :user AND id = :id) as status
            "
        )->fetch();

        if (!$status) {
            return null;
        }

        return (object)[
            "status" => $status->status
          
        ];

	}
	
    /**
     * @return bool
     */
    public function save(): bool
    {
        if (!$this->required()) {
            $this->message->warning("Por favor informar todos os dados");
            return false;
        }
		
        /** User Update */
        if (!empty($this->id)) {
            $stageId = $this->id;
            if ($this->find("stage_name = :e AND id != :i", "e={$this->stage_name}&i={$stageId}", "id")->fetch()) {
                $this->message->warning("Erro ao atualizar essa etapa");
                return false;
            }		
            $this->update($this->safe(), "id = :id", "id={$stageId}");
            if ($this->fail()) {
                $this->message->error("Erro ao atualizar, verifique os dados");
                return false;
            }
        }	
        /** User Create */
        if (empty($this->id)) {

            $stageId = $this->create($this->safe());
            if ($this->fail()) {	
                $this->message->error("Erro ao criar essta etapa, verifique os dados");
                return false;
            }
        }
		
        $this->data = ($this->findById($stageId))->data();
        return true;
    }
}