<?php
/**
 * Part of earth project.
 *
 * @copyright  Copyright (C) 2016 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later.
 */

namespace Lyrasoft\Luna\Admin\Controller\Language;

use Lyrasoft\Luna\Helper\LunaHelper;
use Lyrasoft\Luna\Language\LanguageHelper;
use Phoenix\Controller\AbstractPhoenixController;

/**
 * The ChangeController class.
 *
 * @since  {DEPLOY_VERSION}
 */
class ChangeController extends AbstractPhoenixController
{
	/**
	 * doExecute
	 *
	 * @return  mixed
	 */
	protected function doExecute()
	{
		$lang = $this->input->get('lang');

		$return = $this->input->getBase64('return');

		$uri = $this->container->get('uri');

		$luna = LunaHelper::getPackage();

		if ($luna->isFrontend())
		{
			$redirect = $luna->get('frontend.redirect.language', 'home');
		}
		else
		{
			$redirect = $luna->get('admin.redirect.language', 'home');
		}

		try
		{
			if (!$lang)
			{
				throw new \InvalidArgumentException('No language', 404);
			}

			$language = LanguageHelper::getLanguage($lang);

			if (!$language)
			{
				throw new \RangeException('Language ' . $lang . ' not exists.', 404);
			}

			LanguageHelper::setLocale($lang);
		}
		catch (\Exception $e)
		{
			if (WINDWALKER_DEBUG)
			{
				throw $e;
			}

			$this->setRedirect($this->router->http($redirect));

			return false;
		}

		if ($return)
		{
			$return = $uri['base.path'] . ltrim($uri->get('script') . '/', '/') . $language->alias . '/' . base64_decode($return);
		}
		else
		{
			$return = $this->router->http($redirect);
		}

		$this->setRedirect($return);

		return true;
	}
}
