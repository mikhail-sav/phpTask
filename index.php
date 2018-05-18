<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Task4</title>
</head>
<body>
    <header>
        <h1>Найти строку в тексте</h1>
    </header>
    <form method="post">
        <label>Main string:<input type="text" name="search"></label>
        <br>
        <button>Search</button>
        <hr>
    </form>
    

    <?php
        $string1 = "Sed ut perspiciatis, unde omnis iste natus error sit voluptatem accusantium doloremque
                    laudantium, totam rem aperiam eaque ipsa, quae ab illo inventore veritatis et quasi 
                    architecto beatae vitae dicta sunt, explicabo. Nemo enim ipsam voluptatem, quia voluptas sit,
                    aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos, qui ratione
                    voluptatem sequi nesciunt, neque porro quisquam est, qui dolorem ipsum, quia dolor sit,
                    amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt,
                    ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam,
                    quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi
                    consequatur? Quis autem vel eum iure reprehenderit, qui in ea voluptate velit esse,
                    quam nihil molestiae consequatur, vel illum, qui dolorem eum fugiat, quo voluptas nulla pariatur?
                    At vero eos et accusamus et iusto odio dignissimos ducimus, qui blanditiis praesentium
                    voluptatum deleniti atque corrupti, quos dolores et quas molestias excepturi sint, obcaecati
                    cupiditate non provident, similique sunt in culpa, qui officia deserunt mollitia animi, id est
                    laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero
                    tempore, cum soluta nobis est eligendi optio, cumque nihil impedit, quo minus id, quod maxime placeat,
                    facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et
                    aut officiis debitis aut rerum necessitatibus saepe eveniet, ut et voluptates repudiandae sint et molestiae
                    non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores
                    alias consequatur aut perferendis doloribus asperiores repellat.";

    $user = (string)($_POST['search']);
    $stringArr = explode(" ", $string1); // массив слов текста
    preg_match_all('/"(?:\\\\.|[^\\\\"])*"|\S+/', $user, $matches); // обеденяем то, что в кавычках
    for ($i = 0; $i < count($matches[0]); $i++){
    $normArray[$i] = $matches[0][$i]; // массив строк user
    };
    if ($normArray == null){
    echo $string1;
    } else{
    findText($normArray, $stringArr);
    }

function findText($userText, $mainText ){
for($i = 0; $i < count($userText); $i++ ){
for($j = 0; $j < count($mainText); $j++){
    if (preg_match('~"([^"]*)"~u' , $userText[$i] , $m)) { // если есть кавычки
        $userTextWithNoCommas[$i] = $m[1];  // убираем кавычки
        $pieces = explode(" ", $userTextWithNoCommas[$i]); //разбили user на массив строк
        if (count($pieces) == 1){ // провереям одно ли стлово в кавычках
            if ($pieces[0] == $mainText[$j]){ // если да
                $find[$i] = preg_replace("/$mainText[$j]/", "<mark>$mainText[$j]</mark>", $mainText[$j]);
                $mainText[$j] = $find[$i];
            }
        } else { // если слово не одно
            $k = 0;
            $check =0;
            while ( $mainText[$j] != $userTextWithNoCommas[$i] and ($k < count($pieces))){
              if( $pieces[$k] == $mainText[($j+$k)]){ // проверяем на равенство элементы user и элементы текста
                $check++;
                $k++;
                if($check == count($pieces)){
                    for($n = 1; $n < count($pieces); $n++){
                        $mainText[$j] = $mainText[$j] . " " . $mainText[($j+$n)];
                    }
                    $mainText[$j] = preg_replace("/$mainText[$j]/", "<mark>$mainText[$j]</mark>", $mainText[$j]);
                    for ($n = 1; $n < count($pieces); $n++){
                        unset($mainText[($j+$n)]);
                    }
                }
            } else {
               break;
            }
            }
        }
    } else { // если кавычек нет
        if($userText[$i] == $mainText[$j]){
            $find[$i] = preg_replace("/$mainText[$j]/", "<mark>$mainText[$j]</mark>", $mainText[$j]);
            $mainText[$j] = $find[$i];
        }
    }
}
}
for ($k=0 ; $k<count($mainText);$k++){
$mainText[$k] = $mainText[$k] . " ";
echo $mainText[$k]; 
}
}
    ?>
</body>
</html>