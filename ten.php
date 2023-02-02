<!DOCTYPE html>
<?php
include "sql.php";
include "function.php";
date_default_timezone_set('Asia/Ho_Chi_Minh');

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xem tên </title>
</head>
<body>
    <form action="#" method="post" enctype="multipart/form-data">
        <label>Mã sinh viên</label>
        <input type="text" placeholder="Mã nhân viên" name="mvn"><br>
        <label>Họ tên nhân viên</label>
        <input type="text" placeholder="Họ và tên" name="ten"><br>
        <label>Gmail nhân viên</label>
        <input type="email" placeholder="ghi địa chỉ email " name="email"><br>
        <label>Ngày sinh</label>
        <input type="date" name="ngay_sinh"><br>
        <select name="ban1[]" multiple >
        <?php          
            $sql5=mysqli_query($conn,ban());
            while($hien_ban=mysqli_fetch_assoc($sql5)){
                echo'
                <optgroup label="'.$hien_ban['ten_ban'].'">';
                $sql_phong2=mysqli_query($conn,"SELECT * FROM phong WHERE m_ban=".$hien_ban['mb']."");
                while($ten_phong=mysqli_fetch_assoc($sql_phong2)){
                    echo'
                    <option value="'.$ten_phong['mp'].'">'.$ten_phong['ten_phong'].'</option>';
                }  
                 echo $_POST['ban1'];
                 }
                echo'
                </optgroup>
                ';
        ?>
              </select>
        <?php
          $kq="";
        ?>
        <br>
        <input type="submit" value="Thêm" name="them">
        <?php
        if(isset($_POST['them'])){
            $time_ht=date('d/m/Y');
            $kq.=($_POST['mvn']=='')?"bạn chưa mã nhân viên<br>":"";
            $kq.=($_POST['ten']=='')?"bạn chưa ghi tên<br>":"";
            // echo $time_ht;
            $sql_ten=mysqli_query($conn,ten());
        while($ten1=mysqli_fetch_assoc($sql_ten)){
         if($ten1['mvn']==$_POST['mvn']){
                $kq.="mã nhân viên đã tồn tại<br>";

            }
        }
        if($kq==''){
                $sql3="INSERT INTO `quanly`.`ten` 
                (`mvn`, `tenvn`,`email`,`ngay_sinh`, `ngay_vao`, `tinh_trang`) 
                VALUES ('".$_POST['mvn']."', '".$_POST['ten']."','".$_POST['email']."','".$_POST['ngay_sinh']."', '".date('Y-m-d')."', 'Đang Làm');";
                    if(mysqli_query($conn,$sql3)){
                        $mvn=$_POST['mvn'];
                        $sql_phong1=mysqli_query($conn,phong());
                            $values = $_POST['ban1'];
                            foreach ($values as $a){
                                $sql_thuoc="INSERT INTO thuoc(id,mnv,mp) VALUES (NULL,$mvn,$a);";    
                                if(mysqli_query($conn,$sql_thuoc)){
                                     $kq.= "lưu đã thành công 1<br>"; 
                                } 
                            }   
                            
                        }    
                        $kq.= "lưu đã thành công<br>";    
                    }
                    else{
                        $kq.= "loi<br>";
                    }
        }
        ?>
        <br>
        <table border="1">
            <tr>
                <td>STT</td>
                <td>Mã nhân viên</td>
                <td>Tên nhân viên</td>
                <td>Email nhân viên</td>
                <td>Ngày sinh</td>
                <td>Ngày vào làm</td>
                <td>Tình Trạng</td>
                <td>Các phòng bán đang làm</td>
                <td>Sửa</td>
                <td>xóa</td>
            </tr>
            <?php
                $sql_ten1=mysqli_query($conn,ten());
                $i=1;
                while($ten2=mysqli_fetch_assoc($sql_ten1)){
                    echo "<tr>
                    <td>$i</td>
                    <td>".$ten2['mvn']."</td>
                    <td>".$ten2['tenvn']."</td>
                    <td>".$ten2['email']."</td>
                    <td>".$ten2['ngay_sinh']."</td>
                    <td>".$ten2['ngay_vao']."</td>
                    <td>".$ten2['tinh_trang']."</td>
                    <td>";

                    $sql_phong1=mysqli_query($conn,phong());
                    while($ten_phong1=mysqli_fetch_assoc($sql_phong1)){
                        $sql_thuoc1=mysqli_query($conn,thuoc());
                        // while($thuoc1=mysqli_fetch_assoc($sql_thuoc1)){
                            $sql4="SELECT  phong.ten_phong ,thuoc.id from thuoc 
                            LEFT JOIN phong on phong.mp=thuoc.mp 
                            LEFT JOIN ten on ten.mvn=thuoc.mnv 
                            WHERE phong.mp=".$ten_phong1['mp']." AND ten.mvn=".$ten2['mvn']."
                            ";
                            $h_tp=mysqli_query($conn,$sql4);
                            while($hien_tphong=mysqli_fetch_assoc($h_tp)){
                                echo "<a href='lich.php?id=".$hien_tphong['id']."'>".$hien_tphong['ten_phong']."</a><br>";
                                
                            }

                    // }
                        }
                    echo "</td>";
                    echo '<td><a href="sua.php?mnv='.$ten2['mvn'].'">sửa</a></td>';
                    echo"<td><input type='submit' name='xoa".$i."' value='Xóa'></td>";
                    if(isset($_POST['xoa'.$i.''])){
                        $sql14="DELETE from thuoc where mnv=".$ten2['mvn']."";
                        $sql10="DELETE from ten where mvn=".$ten2['mvn']."";
                        if(mysqli_query($conn,$sql14)&&mysqli_query($conn,$sql10)){
                            echo "\t đã xóa thành công<br>";
                        }
                    }
                    echo "</tr>
                    ";
                    $i++;
                }
            ?>
            
        </table>
        <br>
        <?php
            $sql5=mysqli_query($conn,ban());
            echo'
                <select name="ban" id="">';
            while($hien_ban=mysqli_fetch_assoc($sql5)){
                echo'
                <option value="'.$hien_ban['mb'].'" >'.$hien_ban['ten_ban'].'</option>
                ';
            }
            echo'
            </select>';
        ?>

        <input type="text" placeholder="Thêm Phòng" name="phong">
        <input type="submit" value="Thêm Phòng" name="nut_phong">
        <?php
        $kqP="";
        if(isset($_POST['nut_phong'])){
            $kqP=($_POST['phong']=='')?"bạn chưa ghi tên phòng":"";
            if($kqP==''){

                $sql2="INSERT INTO phong 
                (mp, ten_phong,m_ban) 
                VALUES (null,'".$_POST['phong']."','".$_POST['ban']."');";
                    if(mysqli_query($conn,$sql2)){
                        $kqP.= "lưu đã thành công";
                    }
                    else{
                        $kqP.= "loi";
                    }
            }
        } 
   
        echo $kqP;
        ?>
    </form>
    <a href="phongban.php">Sửa phòng ban </a>
</body>
</html>