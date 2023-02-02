<?php
      include 'function.php';
      include 'sql.php';
  
      $ma=$_GET['mp'];
      $mb=$_GET['mb'];
      $in="";
      $sql3=mysqli_query($conn,ban()." where mb=".$mb."");
      if($ma==""){
        $ten_ban=mysqli_fetch_assoc($sql3);
        $in=$ten_ban['ten_ban'];
      }
      else{
        $sql9=mysqli_query($conn,"SELECT * from phong where `mp`=".$ma."");
        $ten_ban=mysqli_fetch_assoc($sql9);
        $in=$ten_ban['ten_phong'];
      }


?>
<form action="#" method="post" enctype="multipart/form-data">
    <input type="text" value="<?php 
    
    echo $in;?>" name="doi_Tban" >
    <select name="level" id="">
        <option value="0">0</option>
        <option value="1">1</option>
    </select>
<input type="submit" name="nut">
</form>
<?php

    // $sql1=mysqli_query($conn,phong());
    // $sql2=mysqli_query($conn,thuoc());
    // $sql3=mysqli_query($conn,ban());
    $kp='';
    $lock=false;

    if($ma==""){
      if(isset($_POST['nut'])){
            if($ten_ban['ten_ban']==$_POST['doi_Tban']){
              
            }
            elseif($_POST['doi_Tban']==''){
        
            }
            else{
              $code_sql="UPDATE `quanly`.`ban`  SET `ten_ban`='".$_POST['doi_Tban']."' WHERE  `mb`=".$mb."";
              $sql22=mysqli_query($conn,$code_sql);
              if(mysqli_query($conn,$sql22)){
                $kp.="Đã đổi thành công";
              }
            }
            
          
          if(isset($_POST['level'])==0){
            $kp.="ko thể thay đổi quyên";
            
          }  
          else{
            $sql1=mysqli_query($conn,"SELECT * from ban where `mb`=".$mb."");
            $hien_phong=mysqli_fetch_assoc($sql1);
            $sql4="UPDATE `quanly`.`ban` 
            SET `ten_ban`='' 
            WHERE  `mb`=".$mb." AND `level`=0;";
            $sql6=mysqli_query($conn,"SELECT * from phong where m_ban=".$mb."");
            
            $sql5="INSERT INTO `quanly`.`phong`(mp, ten_phong, m_ban,`level`)
            VALUES (null,'".$hien_phong['ten_ban']."',".$hien_phong['mb'].",1)";
              while($hien=mysqli_fetch_assoc($sql6)){
                  if($hien['ten_phong']==$hien_phong['ten_ban']){
                    $kp.="là tồn tại ban này";
                    $lock=true;
                  }
              }
            if($lock==false){
            if(mysqli_query($conn,$sql5)){
                if(mysqli_query($conn,$sql4)){
                    $kp.="đã đổi thành công";
                }
            }  
            }       
            
          }
          
        }
      }
    else{
        if(isset($_POST['nut'])){
          // if($ten_ban['ten_phong']==$_POST['doi_Tban']){
              
          // }
          // elseif($_POST['doi_Tban']==''){
      
          // }
          // else{
          //   $sql8=mysqli_query($conn,"UPDATE `quanly`.`phong`  SET `ten_phong`='".$_POST['doi_Tban']."' WHERE  `mp`=".$ma."");
          //   if(mysqli_query($conn,$sql8)){
          //     $kp.="Đã đổi thành công";
          //   }
          // }
        echo  $_POST['level'];
        
        if($_POST['level']==1){
          $kp.="ko thể thay đổi quyên";
        }  
        else{
          $sql13=mysqli_query($conn,"SELECT * from phong where `mp`=".$ma."");
          $hien_phong=mysqli_fetch_assoc($sql13);
          $sql10="DELETE from phong where mp=".$ma."";
          $sql14="DELETE from thuoc where mp=".$ma."";
          echo $hien_phong['ten_phong'];
          $sql11=mysqli_query($conn,"SELECT * from `ban`");
          
          $sql12="INSERT INTO `quanly`.`ban`(mb, ten_ban,`level`)
          VALUES (null,'".$hien_phong['ten_phong']."',0)";
            while($hien=mysqli_fetch_assoc($sql11)){
                if($hien['ten_ban']==$hien_phong['ten_phong']){
                  $kp.="là tồn tại ban này";
                  $lock=true;
                }
            }
          if($lock==false){
          if(mysqli_query($conn,$sql12)){
              if(mysqli_query($conn,$sql10)&&mysqli_query($conn,$sql14)){
                  $kp.="đã đổi thành công";
              }
          }  
          }       
          
        }
        
      }
          }
    echo $kp;
?>