<?php 

namespace Formitize\API\Methods\Job;

class Job extends \Formitize\API\Methods\AbstractAPI
{
	
	/**
	 * even if Job contains an ID - it will clear it out and create a new job.
	 * @param \Formitize\Job\Job $job
	 */
	function createJob(\Formitize\Job\Job $job)
	{
		$job->id = 0;
		return $this->client->post("job/", $job->getData());
	}

	
	function updateJob(\Formitize\Job\Job $job)
	{
		return $this->client->post("job/", $job->getData());
	}
	

}
?>