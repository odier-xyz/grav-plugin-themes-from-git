<?php
/*--------------------------------------------------------------------------------------------------------------------*/

namespace Grav\Plugin;

/*--------------------------------------------------------------------------------------------------------------------*/

use Composer\Autoload\ClassLoader;

use Grav\Common\Plugin;
use Grav\Plugin\ThemesFromGit\AdminController;

/*--------------------------------------------------------------------------------------------------------------------*/

/**
 * Class ThemesFromGitPlugin
 * @package Grav\Plugin
 */
class ThemesFromGitPlugin extends Plugin
{
	/*----------------------------------------------------------------------------------------------------------------*/

	private $controller = null;

	/*----------------------------------------------------------------------------------------------------------------*/

	/**
	 * @return array
	 *
	 * The getSubscribedEvents() gives the core a list of events
	 *	 that the plugin wants to listen to. The key of each
	 *	 array section is the event that the plugin listens to
	 *	 and the value (in the form of an array) contains the
	 *	 callable (or function) as well as the priority. The
	 *	 higher the number the higher the priority.
	 */
	public static function getSubscribedEvents(): array
	{
		return [
			'onPluginsInitialized' => ['onPluginsInitialized', 0],
			'onPageInitialized'    => ['onPageInitialized'   , 0],
		];
	}

	/*----------------------------------------------------------------------------------------------------------------*/

	/**
	 * Composer autoload
	 *
	 * @return ClassLoader
	 */
	public function autoload(): ClassLoader
	{
		return require __DIR__ . '/vendor/autoload.php';
	}

	/*----------------------------------------------------------------------------------------------------------------*/

	public function onPageInitialized()
	{
		if($this->controller && $this->controller->isActive())
		{
			$this->controller->execute();
			$this->controller->redirect();
		}
	}

	/*----------------------------------------------------------------------------------------------------------------*/

	public function onPluginsInitialized(): void
	{
		if($this->isAdmin())
		{
			$this->controller = new AdminController($this);

			$this->enable([
				'onTwigSiteVariables' => ['onTwigSiteVariables', 0],
				'onAdminMenu'         => ['onAdminMenu'        , 0],
			]);
		}
	}

	/*----------------------------------------------------------------------------------------------------------------*/

	public function onTwigSiteVariables(): void
	{
		if($this->isAdmin()) $this->grav['assets']->addJs('plugin://themes-from-git/js/app.js', ['loading' => 'defer', 'priority' => 0]);
	}

	/*----------------------------------------------------------------------------------------------------------------*/

	public function onAdminMenu(): void
	{
		$base = trim($this->grav['base_url'], '/') . '/' . trim($this->grav['admin']->base, '/');

		$options = [
			'hint' => 'Install / update themes',
			'data' => [
				'tfg-uri' => "${base}/plugins/themes-from-git",
				'tfg-action' => 'sync',
			],
			'location' => 'pages',
			'route' => 'admin',
			'icon' => 'fa-shopping-basket',
		];

		$this->grav['twig']->plugins_quick_tray['ThemesFromGit'] = $options;
	}

	/*----------------------------------------------------------------------------------------------------------------*/
}

/*--------------------------------------------------------------------------------------------------------------------*/
