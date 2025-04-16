<?php

namespace App\Services;

use App\Services\{
    ProjectService,
    UserService,
    BlackPhoneService
};
use App\Repositories\DataRepository;

class SyncService
{
    public $projectService;
    public $userService;
    public $blackPhoneService;

    public function __construct(
        ProjectService $projectService,
        UserService $userService,
        BlackPhoneService $blackPhoneService
        )
    {
        $this->projectService = $projectService;
        $this->userService = $userService;
        $this->blackPhoneService = $blackPhoneService;
    }
    public function check($data)
    {

        $user = $this->userService->findById($data['user_id']);

        if(!$user)
        {
            return false;
        }

        $project = $this->projectService->findById($data['project_id']);

        if(!$project)
        {
            return false;
        }

        if(!$project->status)
        {
            return false;
        }

        if(isset($data['page']) && $data['page'] && $this->checkDomainExists($data['page'],$project->domains))
        {
            $samePageCount = $project->datas()->where('page',$data['page'])->count();
        }else{
            return false;
        }


        if($project->global_limit <= $samePageCount)
        {
            return false;
        }

        if($project->daily_limit <= $samePageCount)
        {
            return false;
        }

        if(isset($data['phone']) && $data['phone'] && $this->blackPhoneService->findByUserIdAndPhone($data['user_id'],$data['phone']))
        {
            return false;
        }

        return true;


    }


    private function checkDomainExists($url, $domains)
    {
        $normalizedUrl = $this->normalizeDomain($url);

        foreach ($domains as $domain) {
            $normalizedDomain = $this->normalizeDomain($domain->domain);

            if ($normalizedUrl && $normalizedDomain && $normalizedUrl === $normalizedDomain) {
                return true;
            }
        }

        return false;
    }

    private function normalizeDomain(string $url): ?string
    {
        $parsed = parse_url(trim($url));

        if (is_array($parsed)) {

            if (isset($parsed['host'])) {
                return strtolower($parsed['host']);
            }

            if (isset($parsed['path'])) {
                return strtolower($parsed['path']);
            }
        }

        return null;
    }


}
