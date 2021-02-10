<?php


namespace victor\sample;


class MonitoringService
{

    public function getJobTypeById($CATEGORY) : JobType
    {

    }

    public function initChildJob(string $link, int $jobTypeCategory): Job {
        return $this->initialConfigJob([
            'jobType' => $this->getJobTypeById($jobTypeCategory),
            'link' => $link,
            'parentJob' => $this->currentJob(),
            'timeStart' => microtime(true),
            'storeConfig' => null,
        ]);
    }
    public function initialConfigJob(array $array): Job
    {

    }

    public function publishJob(Job $job)
    {

    }

    private function currentJob(): Job
    {

    }

    public function terminateJob()
    {
    }
}