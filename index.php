<?php
include("criadorDeClasses.php");

if(!is_dir("model")){
    mkdir("model",0777,true);
}
$entidades = buscarTabelas($entidades);
foreach ($entidades as $entidade) {

    $listaAtributos = buscarAtributos($entidade);

    $attr = "";
    $metodos="";
    foreach ($listaAtributos as $atributo) {
        $attr .= "   private $".$atributo.";\n";
        $metodos .= "function get".ucfirst($atributo)."(){\n";
        $metodos .= "return \$this->".$atributo.";\n }\n";
        $metodos .= "function set".ucfirst($atributo)."(\$arg){\n";
        $metodos .= " \$this->".$atributo."=\$arg;\n }\n";
    }
$nomeClasse=ucfirst($entidade);
    $conteudo=<<<CLASS
<?php
class $nomeClasse {
$attr
$metodos
CLASS;

    file_put_contents("model/".$entidade.".php",$conteudo);
}
?>