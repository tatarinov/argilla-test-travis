<?php
/**
 * @author Alexey Tatarinov <tatarinov@shogo.ru>
 * @link https://github.com/shogodev/argilla/
 * @copyright Copyright &copy; 2003-2015 Shogo
 * @license http://argilla.ru/LICENSE
 */
class CsvChunkCommand extends CConsoleCommand
{
  private $data;

  private $header;

  public function actionIndex($file = '', $limit = 10000)
  {
    if( !file_exists($file) )
    {
      echo 'Неверный путь к файлу '.$file.PHP_EOL;
      return;
    }

    echo 'Start load file '.$file.PHP_EOL;
    $this->findAll($file);
    echo 'End load file '.$file.PHP_EOL;
    $path = dirname($file);
    $this->chunk($limit, $path);
  }

  private function findAll($file)
  {
    $this->data = array();
    $row = 0;
    $handle = fopen($file, 'r');

    while( ($item = fgetcsv($handle, null, ",")) !== false )
    {
      if( $row++ == 0 )
      {
        $this->header = $item;
        continue;
      }

      $this->data[] = $item;
    }
    fclose($handle);
  }

  private function chunk($limit, $path)
  {
    $chunks = array_chunk($this->data, $limit);
    foreach($chunks as $key => $chunk)
    {
      echo 'Start create chunk '.$key.PHP_EOL;
      $handle = fopen($path.'/chunk_'.($key + 1).'.csv', 'w');
      fputcsv($handle, $this->header);

      foreach($chunk as $item)
      {
        fputcsv($handle, $item);
      }
      fclose($handle);
      echo 'End create chunk '.$key.PHP_EOL;
    }
  }
} 