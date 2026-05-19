<?php

require_once "LeitorSQL.php";

if(!is_dir("model")){
    mkdir("model",0777,true);
}

$leitor = new LeitorSQL("framework.sql");

$tabelas = $leitor->getTabelas();
foreach ($tabelas as $tabela) {

    $listaAtributos = $leitor->getAtributos($tabela);

    $attr = "";
    $metodos="";

   foreach ($listaAtributos as $atributo => $chave) {
        $attr .= "   private $".$atributo.";\n";
        $metodos .= "function get".ucfirst($atributo)."(){\n";
        $metodos .= "return \$this->".$atributo.";\n }\n";
        $metodos .= "function set".ucfirst($atributo)."(\$arg){\n";
        $metodos .= " \$this->".$atributo."=\$arg;\n }\n";
    }

$nomeClasse=ucfirst($tabela);
$conteudo=<<<CLASS
<?php
class $nomeClasse {
  
$attr
  
$metodos
  
}
CLASS;

    file_put_contents("model/".$nomeClasse.".php",$conteudo);
}
?>
