<?php

namespace Plugo\Controller;

use Plugo\Services\Security\Security;

abstract class AbstractController
{

	protected function renderView(string $template, array $data = []): string
	{
		$templatePath = dirname(__DIR__, 2) . '/templates/' . $template;
		$security = new Security();
		$data = $security->dataEscape($data);
		return require_once dirname(__DIR__, 2) . '/templates/layout.php';
	}

	protected function redirectToRoute(string $path, array $params = []): void
	{
		$uri = $_SERVER['SCRIPT_NAME'] . "?path=" . $path;

		if (!empty($params)) {
			$strParams = [];
			foreach ($params as $key => $val) {
				if ($key == 'flash') {
					header("Location: " . $uri);
					die;
				}
				array_push($strParams, urlencode((string) $key) . '=' . urlencode((string) $val));
			}
			$uri .= '&' . implode('&', $strParams);
		}

		header("Location: " . $uri);
		die;
	}
}
