<?php
//inserer les données
function insert($bd,$db_table,$db_column,$db_inconnu,$post_values)
    {
        $req = $bd->prepare(
            "INSERT INTO
            ".$db_table."
            (".$db_column.") 
            VALUES 
            (".$db_inconnu.")"
        );
    $req->execute($post_values);
    }

//afficher les données

function getData($bd,$db_select,$db_table)
    {
        $req = $bd->query
            ("SELECT
            ".$db_select."
        FROM ".$db_table." "
                    );
        $result = $req ->fetchAll();
        return $result;
    }
?>