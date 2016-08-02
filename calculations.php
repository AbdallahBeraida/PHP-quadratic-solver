<?php
#Half these comments are for my own sanity, I apologise if some are useless
#ax^2+bx+c
    $standardForm = '-792633x^2+8785896x+146177125';  
    function breakApart($quadratic)
    {
        $aRaw = strstr($quadratic, 'x^2', TRUE);
        $aInverse = strstr($quadratic, 'x^2', FALSE);
        $removal = str_replace('x^2','', $aInverse);
        $bRaw = strstr($removal, 'x', TRUE);
        #C would be the inverse, but since we've reached
        #The end there is no need to.
        $cRaw = strstr($removal, 'x', FALSE);
        #remove all plus signs, they are irrelevant now
        #Minus will be kept as it is essential
        $badChars = array('x' => 'x', '+' => '+');
        $a = str_replace('+', '', $aRaw);
        $b = str_replace('+', '', $bRaw);
        $c = str_replace($badChars, '', $cRaw);
        $quadArray = array('a' => $a, 'b' => $b, 'c' => $c);
        return $quadArray;
    }
    $values = breakApart($standardForm);
    function quadraticSolve($a, $b, $c) 
    {
        $bInverse = ($b * '-1');
        $sqrtSimp = $b * $b - '4'*$a*$c;
        $root = sqrt($sqrtSimp);
        $solvePlus = $bInverse + $root;
        $solveMinus = $bInverse - $root;
        $finalPlus = $solvePlus / '2';
        $finalMinus = $solveMinus / '2';
        $answers = array('plus' => $finalPlus, 'minus' => $finalMinus);
        return $answers;
    }
    $answersQuad = quadraticSolve($values['a'], $values['b'], $values['c']);
    #Sometimes answers give a jumble of weird characters
    #Reminds me of a messed up Baud Rate, probably coincedental
    function determinePoints($answers)
    #This is an entirely optional function, it's helpful if you plan on graphing though
    {
        #range is from -3 to 3
        #I'll probably add a custom range, it shouldn't be too bad
        #$values = array('1' => '-3', '2' => '-2', '3' => '4', '5' => '0', '6' => '7', '8' => '2', '9' => '3');
        session_start();
        $x = '1';
        while($x < '8')
        {
            $values = array('1' => '-3', '2' => '-2', '3' => '-1', '4' => '0', '5' => '1', '6' => '2', '7' => '3');
            $a = $answers['a']; 
            $b = $answers['b'];
            $c = $answers['c'];
            #$plug = ($a*($values["$x"]*$values["$x"]))+($b*$values["$x"])+$c;
            $plug1 = $a * ($values["$x"]*$values["$x"]);
            $plug2 = $b * $values["$x"];
            $plugFinal = $plug1 + $plug2 + $c;
            $_SESSION[$x] = $plugFinal;
            #Session survives the loop
            #Probably not the best way
            $x++;
            if($x === '7')
            {
                #When the auto-incrememnt reaches the end, return to global scope
                return;
            }
            
        }
        
    }
    determinePoints($values);
    #var_dump($_SESSION);
    #session_destroy();