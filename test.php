<?php
session_start();
if (!$_SESSION['name']) {
header("Location:index.php");
  exit;
}
 if (!isset($_GET['test'])) {
        http_response_code(404);
?>
     <p>Тест не выбран</p>
     <p><a href="list.php">Список тестов</a></p>
<?php
    exit;
} 

if (isset($_GET['test'])) {
   
   $hungle = file_get_contents($_GET['test']);
   $content = json_decode($hungle, true);
   $head = $content[0]['question'];
   $block[] = $content[0]['items'];


} else {
  http_response_code(404);
  echo '<h3>Тест не выбран</h3>';
}

?>



<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Генератор тестов на PHP и JSON</title>
    <style>
      .img {
        width: 400px;
        position : relative;
       }
       .img h2 { 
        display: block;
        position: absolute; 
        text-align: center;
        top: 20%; 
        left: 0;
        right: 0;
        margin: auto;
       }
       .img p { 
        position: absolute;
        text-align: center;
        left: 0;
        right: 0;
        margin: auto;
        line-height: 1.5;
        top: 40%; 
       }

    </style>
</head>
<body>

<?php 
if (isset($head)) {
  echo "<h2>$head</h2>";
  ?>
    <form action="" method="POST" enctype="multipart/form-data"> 
    <fieldset>
      
  <?php 
  for ($i=0; $i < count($content[0]['items']); $i++) { 
     ?>
     <p><h4> <?php echo ($content[0]['items'][$i]['quest'] ); ?> </p></h4> 
     <?php    
     
     for ($k = 0; $k < count($content[0]['items'][$i]['answers']); $k++) { 
      $correct[] = $content[0]['items'][$i]['answers'][$k]['result'];
       ?>
     <label><input type=radio name="<?= $i ?>" value="<?= $content[0]['items'][$i]['answers'][$k]['answer'] ?>"><?php $content[0]['items'][$i]['answers'][$k]['answer'] ?></label>
    <?php
    echo ($content[0]['items'][$i]['answers'][$k]['answer']);
     } 
   } ?>
       </fieldset>
    <input class="add" type="submit" name="add" value="Отправить">
  </form> <?php
  }

if (empty($_POST)) {
?>
     <p>Введите данные в форму</p>
      <p><a href="list.php">Список тестов</a></p>
      <p><a href="sessionDestroy.php">Выйти</a></p>
<?php
    exit;
} else {
    foreach ($content[0]['items'] as $key => $value) {   
          for ($i = 0; $i < count($_POST); $i++) {          
            if ($i == $key) {
                for ($k = 0; $k < count($content[0]['items'][$i]['answers']); $k++) {
                  if (isset($_POST[$i]) && $_POST[$i] === $content[0]['items'][$i]['answers'][$k]['answer']) {
                        $results[] = $content[0]['items'][$i]['answers'][$k]['result'];
                       // var_dump($results);

                    }
                }
            }
        }
    }
}

   /*  else {
      echo 'Вы не ответили на вопросы';
     }
*/
if (empty($result)) {
  
$result = array_sum($results);
$correct = array_sum($correct);
function clean($value)
{
    $value = trim($value);
    $value = stripslashes($value);
    $value = strip_tags($value);
    $value = htmlspecialchars($value);
    
    return $value;
}
$name=clean($_SESSION['name']);
if ($result === $correct) {
?>
      <div class="img">
      <img src="image/sert2.php">     
      <h2><?=$name?></h2>
                        
                        
      <p>Вы правильно ответили на все вопросы этого теста!!!</p>
    </div>
<?php
} else {
?>
     <h4>Попробуйте еще раз</h4>
<?php
}
}
?>

<p><a href="list.php">Выбрать другой тест</a></p>
<p><a href="sessionDestroy.php">Выйти</a></p>


</body>
</html>
