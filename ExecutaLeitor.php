<?php

require_once "LeitorSQL.php";

$arquivo = $_FILES['arquivo'];
$arquivo_tmp = $arquivo['tmp_name'];
$arquivo_size = $arquivo['size'];
$arquivo_name = explode('.', $arquivo['name']);
$extensao = strtolower(end($arquivo_name));
echo "<br>";
if($extensao != "sql") {
  header("location: formUpload.php?erro=0");
} 
move_uploaded_file($arquivo_tmp, $arquivo['name']);

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

class $nomeClasse
{
    $attr
  
    $metodos
}
CLASS;

    file_put_contents("model/".$nomeClasse.".php",$conteudo);
}
?>
