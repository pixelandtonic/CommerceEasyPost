<?php
namespace Craft;

class EasyPost_ShipmentsController extends BaseController
{
	public function beforeAction($action)
	{
		$this->requireAjaxRequest();
		return parent::beforeAction($action);
	}

	public function actionIndex()
	{
		return json_encode(craft()->easypost_shi
	}
}