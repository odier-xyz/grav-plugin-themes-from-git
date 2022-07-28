<?php
/*--------------------------------------------------------------------------------------------------------------------*/

namespace Grav\Plugin\ThemesFromGit;

/*--------------------------------------------------------------------------------------------------------------------*/

use Grav\Common\Grav;

/*--------------------------------------------------------------------------------------------------------------------*/

class GitOps
{
	/*----------------------------------------------------------------------------------------------------------------*/
	
	public function __construct()
	{
		$this->grav = Grav::instance();

		$this->config = $this->grav['config']->get('plugins.themes-from-git');

		$this->repositoryPath = USER_DIR . '/themes';
	}

	/*----------------------------------------------------------------------------------------------------------------*/

	public function check(string $theme, string $repoURL, string $repoBranch): bool
	{
		return $this->synchronizeRepo(array(
			'theme' => $theme,
			'repo_url' => $repoURL,
			'repo_branch' => $repoBranch,
		));
	}

	/*----------------------------------------------------------------------------------------------------------------*/

	public function synchronize(): bool
	{
		$result = true;

		if(isset($this->config['repos']))
		{
			foreach($this->config['repos'] as $repo)
			{
				if($this->synchronizeRepo($repo) == false)
				{
					$result = false;
				}
			}
		}

		return $result;
	}

	/*----------------------------------------------------------------------------------------------------------------*/

	private function synchronizeRepo(array $repo): bool
	{
		/*------------------------------------------------------------------------------------------------------------*/

		$theme = $repo['theme'];
		$repoURL = $repo['repo_url'];
		$repoBranch = $repo['repo_branch'];

		if(empty($theme) || empty($repoURL) || empty($repoBranch))
		{
			return false;
		}

		/*------------------------------------------------------------------------------------------------------------*/

		try
		{
			$this->execute('if cd ' . escapeshellarg($theme) . '; then git pull; else git clone ' . escapeshellarg($repoURL) . ' -b ' . escapeshellarg($repoBranch) . ' ' . escapeshellarg($theme) . '; fi');

			return true;
		}
		catch(\Exception $e)
		{
			return false;
		}

		/*------------------------------------------------------------------------------------------------------------*/
	}

	/*----------------------------------------------------------------------------------------------------------------*/

	private function execute(string $command): array
	{
		exec('cd ' . escapeshellarg($this->repositoryPath) . ' ; ' . $command, $output, $ret);

		if($ret !== 0)
		{
			throw new \Exception(implode("\r\n", $output));
		}

		return $output;
	}

	/*----------------------------------------------------------------------------------------------------------------*/
}

/*--------------------------------------------------------------------------------------------------------------------*/
