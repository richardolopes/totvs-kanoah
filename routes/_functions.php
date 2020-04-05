<?php

use \Kanoah\Model\Rotina;

function retornarRotinas($modulo)
{
    if (isset($modulo))
    {
        $rotinas = Rotina::retornarRotinas($modulo);

        foreach ($rotinas as $key)
        {
            echo "<option value='$key'>" . $key . "</option>";
        }
    }
}
