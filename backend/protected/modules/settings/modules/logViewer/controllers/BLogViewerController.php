<?php
/**
 * @author Alexey Tatarivov <tatarinov@shogo.ru>
 * @link https://github.com/shogodev/argilla/
 * @copyright Copyright &copy; 2003-2013 Shogo
 * @license http://argilla.ru/LICENSE
 * @package backend.modules.product.controllers
 */
class BLogViewerController extends BController
{
  public $position = 1000;

  public $name = 'Лог frontend application';

  public $logFileName = 'application.log';

  public function actionIndex()
  {
    $logPath = Yii::getPathOfAlias('frontend.runtime').'/'.$this->logFileName;

    if( file_exists($logPath) )
    {
      $data = file($logPath);
      $data = array_slice(array_reverse($data), 0, 200);
      $dataLog = implode('<br/>', $data);
    }
    else
    {
      $dataLog = "Нет данных";
    }

    $this->render('index', array('dataLog' => $dataLog));
  }
}