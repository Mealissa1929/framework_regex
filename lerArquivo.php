<?php
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
