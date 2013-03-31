<?php

/**
 * Класс для вывода картинок в несколько полосок, имеющих одинаковую ширину, расположены друг под другом.
 * Картинки размещаются так, чтобы занять как можно меньше места по вертикали.
 *
 * Принцип работы алгоритма:
 * 1) Раскидывает картинки в заданное количество массивов (полосок)
 * 2) Перемещает картинки из одного массива в другой, стараясь получить полоски наиболее одинаковой ширины.
 * 3) Пересчитывает размеры картинок, так чтобы все полоски были заданной ширины.
 *
 * Получение полосок наиболее одинаковой ширины очень ресурсоемкий процесс,
 * поэтому можно задать допустимую погрешность в процентах,
 * насколько длинна полоски может отличаться от средней длинны полосок.
 * Если погрешность не задана, будет произведен полный перебор.
 * Чем больше погрешность, тем больше будет суммарная высота полосок
 */
class renderImageHelper {

  public $images = array();   // массив объектов image
  public $lines = array();    // массив массивов в каждом из которых картинки. - полоски.
  public $countLines = 5;     // количество полосок

  /**
   * @param image[] $images массив картинок
   * @param int $countLines количество линий в 
   * @param int $needWidth Ширина, в которую нужно вписать картикни
   */

  public function __construct($images, $countLines, $needWidth) {

    $this->images = $images;
    $this->countLines = $countLines;
    $this->needWidth = $needWidth;
  }

  /**
   * Подготовка данных к вычислению. 
   */
  public function Init() {

// задаем всем картинкам одинаковую высоту - любое целое значение.
    // при этом ширина картинок пересчитывается, сохраняя пропорции
    $this->setLineHeight(1000);

    // теперь отсортируем картинки по возрастанию ширины
    // это не обязательно, но это уменьшит количество вызовов рекурсий, при самом размещении.
    $this->sortImagesByWidth();

    // заполняем массив $lines
    $this->fillLines();
    // Все готово к вызову метода, размешающего картинки.
  }

  /**
   * Меняет элементы в двух массивов с картинками так, 
   * чтобы разница сумм длин картинок в них была 
   */
  public function sortTwoImageLines($leftImages, $rightImages) {

    $bestDiff = $this->getLinesDiff($leftImages, $rightImages);

    $bestLeft = array();
    $bestRight = array();

    $this->cloneImagesArray($leftImages, $bestLeft);
    $this->cloneImagesArray($rightImages, $bestRight);

    // меняем местами все картинки из левого массива, со всеми картинками из правого, полный перебор
    foreach ($leftImages as $leftImage) {
      foreach ($rightImages as $rightImage) {
        // меняем картинки местами
        $this->swapImages($leftImage, $rightImage);
        // если разность меньше - заменяем запоминаем результат
        if ($bestDiff > $currDiff = $this->getLinesDiff($leftImages, $rightImages)) {
          $bestDiff = $currDiff; // лучшее расхождение длинн
          $this->cloneImagesArray($leftImages, $bestLeft); // запиминаем лучший вариант левого массива
          $this->cloneImagesArray($rightImages, $bestRight); // запиминаем лучший вариант правого массива
        }else{
          $this->swapImages($leftImage, $rightImage);  
        }
      }
    }

    // если количество элементов в левом массиве больше одного
    if (count($bestLeft) > 1 && false) {

      $this->moveImage($bestLeft, $bestRight);
      // запускаем функцию еще раз
      $result = $this->sortTwoImageLines($bestLeft, $bestRight);
      
      // TODO: незабыть убрать
      echo "<pre>";
      var_dump(count($result[0]));
      var_dump(count($result[1]));
      echo "</pre>";
      die();
      // и если получаем лучший результат - вернем его
      if ($bestDiff > $this->getLinesDiff($result[0], $result[1])) {
        $bestDiff = abs($newLeftWidth - $newRightWidth);
        $bestLeft = $result[0];
        $bestRight = $result[1];
      }else{ // иначе перетаскиваем картинку обратно.
        $this->moveImage($bestRight, $bestLeft);  
      }
    }
    
    return array($bestLeft, $bestRight);
  }

  public function clearArray(&$imageArray) {
    foreach ($imageArray as $image) {
      unset($image);
    }
  }

  public function cloneImagesArray($imagesArray, &$imagesArray2) {
    $this->clearArray($imagesArray2);
    foreach ($imagesArray as $image) {
      $imagesArray2[] = clone $image;
    }
  }

  public function getLinesDiff($line1, $line2) {
    $leftWidth = $this->getLineWidth($line1);
    $rightWidth = $this->getLineWidth($line2);
    return abs($leftWidth - $rightWidth);
  }

  /**
   *
   * @param images[] $leftImages
   * @param images[] $rightImages
   * @param int $lineWidth 
   */

  /**
   * Размещает картики в массиве $lines, добиваясь максимально одинаковой длинны полосок.
   * @param int $availableError - погрешность (0-100)
   * Указывает насколько полоски могут отчличаться по друг от  друга по ширине.
   * умолчанию - 10%. Чем больше - тем быстрее отработает алгоитм, 
   * но меньше вероятность получить наиболее компактное размещение картинок
   */
  public function sortImages($availableError) {
    

    // TODO: незабыть убрать
//    echo "<pre>";
//    foreach ($this->lines as $line){
//      var_dump(count($line));  
//    }
//    echo "</pre>";


    // в двойном цикле запускаем 
    for ($k = 0; $k < $this->countLines; $k++) {
      for ($n = 0; $n < $this->countLines; $n++) {
        if ($n == $k) {
          continue;
        }
        $ind_n = ($n != $this->countLines) ? $n : 0;
        $ind_k = ($k != $this->countLines) ? $k : 0;
        
        $result = $this->sortTwoImageLines($this->lines[$ind_n], $this->lines[$ind_k]);
        $this->cloneImagesArray($result[0], $this->lines[$ind_n]);
        $this->cloneImagesArray($result[1], $this->lines[$ind_k]);
        
        $result = $this->sortTwoImageLines($this->lines[$ind_k], $this->lines[$ind_n]);
        $this->cloneImagesArray($result[0], $this->lines[$ind_n]);
        $this->cloneImagesArray($result[1], $this->lines[$ind_k]);
      }
    }
  }

  /**
   * Возвращает длинну полоски
   * @param type $images 
   */
  public function getLineWidth($images) {

    $width = 0;
    foreach ($images as $image) {
      $width += $image->width;
    }

    return $width;
  }

  /**
   * Задает всем картинкам в массиве одинаковую высоту, сохраняя пропорции картинки
   * @param int $newHeight
   */
  public function setLineHeight($newHeight) {
    foreach ($this->images as $key => $image) {
      $image->width = ($image->width * $newHeight) / $image->height;
      $image->height = $newHeight;
    }
  }

  /**
   * заполняет полоски (массив $lines) копируя обьекты из массива images
   * в результате у получается массив, содержажий массивы с одинаковым количеством картинок в каждом.
   */
  function fillLines() {
    $numLine = 0; // текуший номер линии.
    foreach ($this->images as $image) {
      if ($numLine > $this->countLines - 1) {
        $numLine = 0;
      }
      $this->lines[$numLine][] = clone $image;
      $numLine++;
    }
  }

//  public function setLineWidth($needWidth) {
//    
//  }
  // сортировка по возрастанию ширины
  public function sortImagesByWidth() {
    $countImages = count($this->images);
    for ($i = 0; $i < $countImages - 1; $i++) {
      for ($j = 0; $j < $countImages - 1; $j++) {
        if ($this->images[$j]->width > $this->images[$j + 1]->width) {
          $this->swapImages($this->images[$j], $this->images[$j + 1]);
        }
      }
    }
  }

  /**
   * меняет 2 картинки местами
   */
  public function swapImages($image1, $image2) {
    $tmp = clone $image1;
    $image1 = clone $image2;
    $image2 = clone $tmp;
    unset($tmp);
  }

  public function moveImage(&$leftImages,&$rightImages){
    $rightImages[] = $leftImages[count($leftImages)];
    unset($leftImages[count($leftImages)]);
  }
}

?>