<?php
include "sql.php";
include "function.php";
$sql=mysqli_query($conn,ten()." where mvn=".$_GET['mnv']."");
$ten=mysqli_fetch_assoc($sql);
$mnv=$ten['mvn'];
$tennv=$ten['tenvn'];
$email=$ten['email'];
$ngay_sinh=$ten['ngay_sinh'];
$ngay_vao=$ten['ngay_vao'];
$tinh_trang=$ten['tinh_trang'];
?>
<form action="#" method="post" enctype="multipart/form-data">
 <label>Mã sinh viên</label>
        <input type="text" value="<?php echo $mnv;?>" name="mvn"><br>
        <label>Họ tên nhân viên</label>
        <input type="text" value="<?php echo $tennv;?>" name="ten"><br>
        <label>Gmail nhân viên</label>
        <input type="email" value="<?php echo $email;?>" name="email"><br>
        <label>Ngày sinh</label>
        <input type="date" name="ngay_sinh" value="<?php echo $ngay_sinh;?>"><br>
        <label>Ngày vào</label>
        <input type="date" name="ngay_vao" value="<?php echo $ngay_vao;?>"><br>
        <label>Tinh trạng</label>
        <input type="text" name="Tinh_trang" value="<?php echo $tinh_trang?>"><br>
        <label>Các phòng ban đã chọn</label><br>
        <?php
            $sql_phong1=mysqli_query($conn,phong());
            $i=1;
            while($ten_phong1=mysqli_fetch_assoc($sql_phong1)){
                $sql_thuoc1=mysqli_query($conn,thuoc());
                // while($thuoc1=mysqli_fetch_assoc($sql_thuoc1)){
                    $sql4="SELECT  phong.ten_phong ,thuoc.id from thuoc 
                    LEFT JOIN phong on phong.mp=thuoc.mp 
                    LEFT JOIN ten on ten.mvn=thuoc.mnv 
                    WHERE phong.mp=".$ten_phong1['mp']." AND ten.mvn=".$mnv."
                    ";
                    $h_tp=mysqli_query($conn,$sql4);
                    while($hien_tphong=mysqli_fetch_assoc($h_tp)){
                        echo $hien_tphong['ten_phong']."\t";
                        echo"<input type='submit' name='xoa".$i."' value='Xóa'><br>";
                        if(isset($_POST['xoa'.$i.''])){

                            $sql10="DELETE from lich where id_thuoc=".$hien_tphong['id']."";
                            $sql14="DELETE from thuoc where mp=".$ten_phong1['mp']." AND mnv=".$mnv."";
                            if(mysqli_query($conn,$sql10)&&mysqli_query($conn,$sql14)){
                                echo "\t đã xóa thành công<br>";
                            }
                        }
                    }
                    $i++;
                }
            
        ?>
        <label>thêm phòng ban</label>
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
        <input type="submit" value="Sửa" name="them">
        <?php
        if(isset($_POST['them'])){
            $kq.=($_POST['ten']=='')?"bạn chưa ghi tên<br>":"";
            $kq.=($_POST['email']=='')?"bạn chưa ghi email<br>":"";
            $kq.=($_POST['ngay_sinh']=='')?"bạn chưa chọn ngày sinh<br>":"";
            $kq.=($_POST['ngay_vao']=='')?"bạn chưa nhập ngày vào<br>":"";
            $kq.=($_POST['Tinh_trang']=='')?"bạn chưa ghii tình trạng nhân viên<br>":"";
            $sql_ten=mysqli_query($conn,ten());
        if($kq==''){
                $sql3="UPDATE `quanly`.`ten` 
                SET `tenvn`='".$_POST['ten']."', 
                `email`='".$_POST['email']."', 
                `ngay_sinh`='".$_POST['ngay_sinh']."', 
                `ngay_vao`='".$_POST['ngay_vao']."', 
                `tinh_trang`='".$_POST['Tinh_trang']."' 
                WHERE  `mvn`=".$mnv.";
                ";
                    if(mysqli_query($conn,$sql3)){
                        $sql_phong1=mysqli_query($conn,phong());
                            $values = $_POST['ban1'];
                            foreach ($values as $a){
                                
                                $sql_thuoc="INSERT INTO thuoc(id,mnv,mp) VALUES (NULL,$mnv,$a);";    
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
</form>