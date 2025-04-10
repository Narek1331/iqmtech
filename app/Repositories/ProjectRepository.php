<?php

namespace App\Repositories;

use App\Models\Project;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProjectRepository
{
    /**
     * Store a new project.
     *
     * @param array $data
     * @return Project
     */
    public function store(array $data)
    {
        return Project::create($data);
    }

    /**
     * Find a project by ID.
     *
     * @param int $id
     * @return Project
     */
    public function findById(int $id): ?Project
    {
        return Project::find($id) ?? null;
    }
}
