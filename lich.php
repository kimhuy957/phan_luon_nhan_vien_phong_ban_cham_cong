<form action="#" method="post">
    <input type="submit" value="tích" name="tich">
</form>
<?php
    include 'function.php';
    include 'sql.php';
date_default_timezone_set('Asia/Ho_Chi_Minh');
$id_t=$_GET['id'];

if(isset($_POST['tich'])){  
    $dateday=date('Y-m-d');
    $datetime=date('H:i');
    $n='';
    $k='';
    $kq='';
    $lich=mysqli_query($conn,lich());
    while($co=mysqli_fetch_assoc($lich)){
        if($co['id_thuoc']==$id_t){
            $k.='đã tồn tại';
        }
    }
    if($k==''){

        if($datetime<='8:00'){
            $n="muộn";
            if($datetime>='10:00'){
            $sql="INSERT INTO `quanly`.`lich` 
            (`id_lich`, `date`, `time_di`,`tinh_trang`, `id_thuoc`) 
            VALUES (Null, '$dateday', '$datetime', '$n','$id_t');";
            if(mysqli_query($conn,$sql)){
                $kq.= "đi $n";
            }

        }
            if($datetime<='10:00'){
                $n="nghỉ";
                $sql="INSERT INTO `quanly`.`lich` 
                (`id_lich`, `date`, `time_di`,`tinh_trang`, `id_thuoc`) 
                VALUES (Null, '$dateday', '$datetime', '$n','$id_t');";
                if(mysqli_query($conn,$sql)){
                    $kq.= "$n";
                }
            }

        }
        if($datetime>='8:00'){
            $n="đúng h";
            $sql1="INSERT INTO `quanly`.`lich` 
            (`id_lich`, `date`, `time_di`,`tinh_trang`, `id_thuoc`) 
            VALUES (Null, '$dateday', '$datetime', '$n','$id_t');";
            if(mysqli_query($conn,$sql1)){
                $kq.= "đi $n";
            }
        }

    }
  echo $kq;
  echo $k;  
}
?>
<table border="1">

<?php
$a=date('Y-m-d');
$date = new DateTime("$a");
$z=15;
for($i=0;$i<=$z;$i++){
    $n=1;
    if($i==0){
    }
    else{
        $date->modify("$n day");   

    }
    
    $l=$date->format("l");
    $m=$date->format("Y-m-d");
    $sql2=mysqli_query($conn,'SELECT * from `lich` where id_thuoc='.$id_t.' and DATE="'.$m.'"');
    $hien1='';
    $hien2='';
    while($hien=mysqli_fetch_assoc($sql2)){
        $hien1=$hien['tinh_trang'];
        
        $hien2=$hien['date'];  
        
       
    }
    $l=$date->format("l");
    $tinh_trang='';

    echo $m."<br>";
    switch($l){
        case 'Monday':
        $tinh_trang=($hien2==$m)?''.$hien1.'':'';
        echo'
        <td>'.$m.'<br>thứ 2<br>
        '.$tinh_trang.'
        </td>';
        break;
        case 'Tuesday':
        $tinh_trang=($hien2==$m)?''.$hien1.'':'';
        echo'<td>'.$m.'<br>thứ 3<br>

       '.$tinh_trang.'
        </td>';
        break;
        case 'Wednesday':
        $tinh_trang=($hien2==$m)?''.$hien1.'':'';
        echo'<td>'.$m.'<br>thứ 4<br>
       '.$tinh_trang.'
        </td>';
        break;
        case 'Thursday':
        $tinh_trang=($hien2==$m)?''.$hien1.'':'';
        echo'<td>'.$m.'<br>thứ 5<br>
       '.$tinh_trang.'
        </td>';
        break;
        case 'Friday':
         $tinh_trang=($hien2==$m)?''.$hien1.'':'';
        echo'<td>'.$m.'<br>
        thứ 6<br>
       '.$tinh_trang.'
        </td>';
        break;
        case 'Saturday':
        $tinh_trang=($hien2==$m)?''.$hien1.'':'';
        echo'<td>'.$m.'<br> thứ7<br>
       '.$tinh_trang.'
        </td>';
        break;
        case 'Sunday':
        $tinh_trang=($hien2==$m)?''.$hien1.'':'';  
        echo'<td>'.$m.'<br>chủ nhật<br>
       '.$tinh_trang.'
        </td>';
        break;
        }
    }
// }
?>
</table>