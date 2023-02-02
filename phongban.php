<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>phòng ban</title>
</head>
<body>
<form action="#" method="post" enctype="multipart/form-data">   
<input type="text" placeholder="Thêm ban" name="ten_ban1">
<input type="submit" value="Thêm ban" name="nut_ban1"><br>
    
<?php
    include "sql.php";
    include "function.php";
    $kqP="";
    $k='';
    if(isset($_POST['nut_ban1'])){

    $sql4=mysqli_query($conn,ban());
    while($ten2=mysqli_fetch_assoc($sql4)){
        if($ten2['ten_ban']==$_POST['ten_ban1']){
            $k.="ten ban đã tồn tại<br>";
            
        }
    }
    $k.=($_POST['ten_ban1']=='')?"chưa ghi tên ban":"";
     if($k==""){
        $sql5="INSERT INTO ban 
                (mb, ten_ban,`level`) 
                VALUES (NULL,'".$_POST['ten_ban1']."',0);";
        if(mysqli_query($conn,$sql5)){
            $kqP='lưu thành công';
        }
     }   
    }
    echo $k;
    echo$kqP;
            $sql=mysqli_query($conn,ban());
            echo'
                <select name="ban" id="">';
            while($hien_ban=mysqli_fetch_assoc($sql)){
                echo'
                <option value="'.$hien_ban['mb'].'" >'.$hien_ban['ten_ban'].'</option>
                ';
            }
            echo'
            </select>';
?>
        <input type="text" placeholder="Thêm Phòng" name="phong">
        <input type="submit" value="Thêm Phòng" name="nut_phong">
    </form>
        <?php
        if(isset($_POST['nut_phong'])){
            $k=($_POST['phong']=='')?"bạn chưa ghi tên phòng":"";
                $sql2=mysqli_query($conn,phong());
                while($hien=mysqli_fetch_assoc($sql2)){
                if($_POST['phong']==$hien['ten_phong']){
                        $k.="Đã tồn tại";
                }
                }
            if($k==''){

                $sql1="INSERT INTO phong 
                (mp, ten_phong,m_ban,`level`) 
                VALUES (null,'".$_POST['phong']."','".$_POST['ban']."',1);";
                    if(mysqli_query($conn,$sql1)){
                        $kqP.= "lưu đã thành công";
                    }
                    else{
                        $kqP.= "loi";
                    }
            }
        }
        echo $k;
        echo $kqP; 
        ?>
        <?php
            $sql2=mysqli_query($conn,"SELECT * FROM ban ORDER BY `level`");
            echo'<ol style="list-style-type:upper-roman"">';
            while($hien=mysqli_fetch_assoc($sql2)){
                echo "<a href='doi.php?mb=".$hien['mb']."&mp='''><li>";
                if($hien["ten_ban"]==''){
                    echo "vui long thêm tên";
                }
                else{
                    echo $hien["ten_ban"];
                }
                echo"</a>";
                
                echo "<ol>";
                $sql3=mysqli_query($conn,phong());
                while($hien1=mysqli_fetch_assoc($sql3)){
                    if($hien['mb']==$hien1['m_ban'])
                    echo "<li><a href='doi.php?mb=".$hien['mb']."&mp=".$hien1['mp']."' >".$hien1['ten_phong']."</li>";


                }
                echo "</ol></li>";
            }
            echo '</ol>';
        ?>
</body>
</html>