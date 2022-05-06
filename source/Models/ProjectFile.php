<?php

namespace Source\Models;

use Source\Core\Model;

/**
 * FSPHP | Class User Active Record Pattern
 *
 * @author Robson V. Leite <cursos@upinside.com.br>
 * @package Source\Models
 */
class ProjectFile extends Model
{
    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct("projectfile", ["id"], ["project", "title" ,"uri" ,"subtitle" ,"status" ,"description" ,"cover"]);
    }

    /**
     * @param string $firstName
     * @param string $lastName
     * @param string $tag
     * @param string $password
     * @param string|null $document
     * @return User
     */
	 
    public function bootstrap(
		string $application_id,
		string $project,
		string $title,
		string $uri,
		string $subtitle,
		string $status,
		string $description,
		string $cover
    ): ProjectFile {
		$this->application_id = $application_id;
		$this->project = $project;
		$this->title = $title;
		$this->uri = $uri;
		$this->subtitle = $subtitle;
		$this->status = $status;
		$this->description = $description;
		$this->cover = $cover;
        return $this;
    }
		
    public function findProjectFile(string $application_id, string $project, string $title, string $uri, string $subtitle, string $status, string $description, string $cover, string $columns = "*"): ?ProjectFile
    {
        $find = $this->find("application_id = :application_id AND project = :project AND title = :title  AND uri = :uri  AND subtitle = :subtitle AND status = :status AND description = :description AND cover = :cover",  "application_id={$application_id}&project={$project}&title={$title}&uri={$uri}&subtitle={$subtitle}&status={$status}&description={$description}&cover={$cover}", $columns);
        return $find->fetch();
    }
		
	
	public function getProject(): ?Works
    {
        if ($this->project) {
            return (new Works())->findById($this->project);
        }
        return null;
    }
	
    /**
     * @return bool
     */
    public function save(): bool
    {
        if (!$this->required()) {
            $this->message->warning("Falta informar dados");
            return false;
        }

        /** User Update */
        if (!empty($this->id)) {
            $projectId = $this->id;

            if ($this->find("project = :project AND title = :title  AND uri = :uri  AND subtitle = :subtitle AND status = :status AND description = :description AND cover = :cover AND id != :i", "project={$this->project}&title={$this->title}&uri={$this->uri}&subtitle={$this->subtitle}&status={$this->status}&description={$this->description}&cover={$this->cover}&i={$this->ProjectcoverId}", "id")->fetch()) {
                $this->message->warning("O Arquivo já foi cadastratado");
                return false;
            }

            $this->update($this->safe(), "id = :id", "id={$projectId}");
            if ($this->fail()) {
                $this->message->error("Erro ao atualizar, verifique os dados");
                return false;
            }
        }

        /** User Create */
        if (empty($this->id)) {
            if ($this->findProjectFile($this->application_id, $this->project, $this->title, $this->uri, $this->subtitle, $this->status, $this->description, $this->cover, "id")) {
                $this->message->warning("Esse arquivo já foi cadastrado");
                return false;
            }

            $projectId = $this->create($this->safe());
            if ($this->fail()) {
                $this->message->error("Erro ao cadastrar, verifique os dados");
                return false;
            }
        }

        $this->data = ($this->findById($projectId))->data();
        return true;
    }
}





