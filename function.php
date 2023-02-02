<?php


function ten(){
    $sql="SELECT * from ten";
    return $sql;
}
function phong(){
    $sql="SELECT * from phong";
    return $sql;
}
function thuoc(){
    $sql="SELECT * from thuoc";
    return $sql;
}
function lich(){
    $sql="SELECT * from lich";
    return $sql;
}
function ban(){
    $sql="SELECT * from ban";
    return $sql;
}
// function in_phong(){
//     include 'sql.php';
//     $phong=mysqli_query($conn,phong());
//     $hien=mysqli_fetch_assoc($phong);
//     return $hien;
// } 
// function in_phong1($a){
//     include 'sql.php';
// } 
?>