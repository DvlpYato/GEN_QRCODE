<!DOCTYPE html>
<html lang="en">

<script src="http://code.jquery.com/jquery-3.4.1.min.js"></script>
<link rel="icon" href="favicon.ico">
<head>
<style>
div.a {
  font-size: 200px;
  font-weight: bold;
  
}
table {
  border-collapse: collapse;
}

table, td, th {
  border: 1px solid black;
}


</style>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1" />
</head>

<body>
    <h1>โปรแกรม Gen QRCode</h1>

    <form method="POST" class="form-inline">
        <input autocomplete="off" type=" text" class="form-control" placeholder="ใส่ข้อความ" id="title" name="title" size="20"/>
        &nbsp
        <input autocomplete="off" type="number" class="form-control" placeholder="จำนวน" id="row" name="row" min="1" max="100000000" />
        <br><br>
        &nbsp
        <button class="btn btn-primary form-success" id="add" name="add" >Generate </button>


        <?php 
        if (isset($_POST["add"]))
        {
        ?>

        &nbsp
        <button class="btn btn-secondary" id="clear" name="clear" >Clear</button>

        &nbsp
        <button class="btn btn-warning" onclick="location.href='images/png.zip'" type="button">
        PNG</button>

        
        &nbsp
        <button class="btn btn-warning" onclick="location.href='images/svg.zip'" type="button">
        SVG</button>        
        <?php 
   }
   ?>

    </form>



    <br><br><br>

    <?php 


    $folder_path = "images"; 
    $files = glob($folder_path.'/*');  
    foreach($files as $file) { 
        if(is_file($file))  
            unlink($file);  
    } 


    $directory = 'images/';
    $files = glob($directory . '*.png');

    if ( $files !== false )
    {
        $filecount = count( $files );
        ?> 
            <script>
                console.log("PNG file = "+<?php echo $filecount; ?>);
            </script>
        <?php
    }
    else
    {
        ?> 
            <script>
                console.log("Count file = 0");
            </script>
        <?php
    }
    
    ?> 
    <?php 

    include('phpqrcode/qrlib.php');
   if (isset($_POST["add"]))
   {
    if ($_POST['title'] != ""&&$_POST['row'] != "") {
      
        $maxcols = 1; 
        $maxid = $_POST["row"];
        $title = $_POST["title"];
        $startid = 1;

        echo "<table id='table1'>\n";
        for ($i = 1;$i<=ceil($maxid/$maxcols);$i++) {

            echo "<tr>\n";
        for ($j=1;$j<=$maxcols;$j++)
            if ($startid <= $maxid){


                if($startid<"10"){

                 if (!is_dir('images')) {
                    mkdir('images');
                }

                $tempDir = "images/";    
                $codeContents = $title."-0".$startid;

                $fileName = $codeContents.'.svg';
                $fileName2 = $codeContents.'.png';

                $pngAbsoluteFilePath = $tempDir.$fileName;
                $urlRelativeFilePath = 'images/'.$fileName;

                $pngAbsoluteFilePath2 = $tempDir.$fileName2;
                $urlRelativeFilePath2 = 'images/'.$fileName2;

                QRcode::svg($codeContents, $pngAbsoluteFilePath, QR_ECLEVEL_L, 4); 
                
                QRcode::png($codeContents, $pngAbsoluteFilePath2, QR_ECLEVEL_L, 4);  


                   ?>

                <td><div class="a" ><?php echo $title."-0".$startid; ?><a href="<?php echo $urlRelativeFilePath; ?>" download="<?php echo $pngAbsoluteFilePath; ?>"><img src= "<?php echo $urlRelativeFilePath; ?>" width="300" height="300"/></a>  <a href="<?php echo $urlRelativeFilePath2; ?>" download="<?php echo $pngAbsoluteFilePath2; ?>"><img src= "<?php echo $urlRelativeFilePath2; ?>" width="300" height="300"/></a> </div></td>
                
                   
                <?php
                    
                }else{
                    $tempDir = "images/";    
                $codeContents = $title."-".$startid;
                $fileName = $codeContents.'.svg';
                $fileName2 = $codeContents.'.png';

                $pngAbsoluteFilePath = $tempDir.$fileName;
                $urlRelativeFilePath = 'images/'.$fileName;

                $pngAbsoluteFilePath2 = $tempDir.$fileName2;
                $urlRelativeFilePath2 = 'images/'.$fileName2;

                QRcode::svg($codeContents, $pngAbsoluteFilePath, QR_ECLEVEL_L, 4); 
                
                QRcode::png($codeContents, $pngAbsoluteFilePath2, QR_ECLEVEL_L, 4);  
                    ?>

<td><div class="a" ><?php echo $title."-".$startid; ?><a href="<?php echo $urlRelativeFilePath; ?>" download="<?php echo $pngAbsoluteFilePath; ?>"><img src= "<?php echo $urlRelativeFilePath; ?>" width="300" height="300"/></a>  <a href="<?php echo $urlRelativeFilePath2; ?>" download="<?php echo $pngAbsoluteFilePath2; ?>"><img src= "<?php echo $urlRelativeFilePath2; ?>" width="300" height="300"/></a> </div></td>
                       
                    <?php
                }
                
                $startid = $startid+1;              
            
            }else{ 
                echo "  <td> </td>\n";
            }
        echo "</tr>\n<tr>\n";
            for ($j=1;$j<=$maxcols;$j++)
                echo "<td></td>\n";

    echo "</tr>\n";
}

echo "</table>\n";
   }else{

    

    ?>

    <script>
        window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function(){
            $(this).remove(); 
        });
        }, 2000);
    </script>
       
        <div class="alert alert-warning" role="alert">
        <strong>Warning!</strong> โปรดกรอกข้อมูล
        </div>
    <?php
   }
   }

?>
<?php
    //if (isset($_POST["AllPNG"])){


        $zip = new ZipArchive;
        if ($zip->open('images/png.zip', ZipArchive::CREATE) === TRUE) {
            $zip->addGlob("images/*.png");
            $zip->close();
            //echo 'ok';
        } else {
            //echo 'failed';
        }
    
    //}

    //if (isset($_POST["AllSVG"])){


        $zip = new ZipArchive;
        if ($zip->open('images/svg.zip', ZipArchive::CREATE) === TRUE) {
            $zip->addGlob("images/*.svg");
            $zip->close();
            //echo 'ok';
        } else {
            //echo 'failed';
        }
    
    //}
    

    if (isset($_POST["clear"])){
        $folder_path = "images"; 
        $files = glob($folder_path.'/*');  
        foreach($files as $file) { 
            if(is_file($file))  
                unlink($file);  
        } 
    }
?>

<br><br><br><br><br>
</body>
<footer>
<br><br><br><br><br>
</footer>