<?php

namespace App\Services;

use App\Repositories\ProjectRepository;
use App\Models\Project;

class ProjectService
{
    protected $projectRepository;

    /**
     * Inject the ProjectRepository.
     *
     * @param ProjectRepository $projectRepository
     */
    public function __construct(ProjectRepository $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    /**
     * Find a project by ID.
     *
     * @param int $id
     * @return Project
     */
    public function findById(int $id): ?Project
    {
        return $this->projectRepository->findById($id);
    }
}
