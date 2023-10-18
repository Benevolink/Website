<?php
if (! empty($_POST["upload"])) {
    if (is_uploaded_file($_FILES['userImage']['tmp_name'])) {
        $targetPath = "uploads/" . $_FILES['userImage']['name'];
        if (move_uploaded_file($_FILES['userImage']['tmp_name'], $targetPath)) {
            $uploadedImagePath = $targetPath;
        }
    }
}
?>
<html>
<head>
<title>Upload and Crop Image using PHP and jQuery</title>
<link rel="stylesheet" href="jquery.Jcrop.min.css" type="text/css" />
<script src="jquery.min.js"></script>
<script src="jquery.Jcrop.min.js"></script>

<style>
body {
    width: 550px;
    font-family: Arial;
}

.bgColor {
    width: 100%;
    height: 150px;
    background-color: #fff4be;
    border-radius: 4px;
    margin-bottom: 30px;
}

.inputFile {
    padding: 5px;
    background-color: #FFFFFF;
    border: #F0E8E0 1px solid;
    border-radius: 4px;
}

.btnSubmit {
    background-color: #696969;
    padding: 5px 30px;
    border: #696969 1px solid;
    border-radius: 4px;
    color: #FFFFFF;
    margin-top: 10px;
}

#uploadFormLayer {
    padding: 20px;
}

input#crop {
    padding: 5px 25px 5px 25px;
    background: lightseagreen;
    border: #485c61 1px solid;
    color: #FFF;
    visibility: hidden;
}

#cropped_img {
    margin-top: 40px;
}
</style>
</head>
<body>
<?php
$imagePath = "initial-image.jpeg";
if (! empty($uploadedImagePath)) {
    $imagePath = $uploadedImagePath;
}
?>
<div class="bgColor">
    <form id="uploadForm" action="" method="post"
        enctype="multipart/form-data">

        <div id="uploadFormLayer">
            <input name="userImage" id="userImage" type="file"
                class="inputFile"><br> <input type="submit"
                name="upload" value="Submit" class="btnSubmit">

        </div>
    </form>
</div>
<div>
    <img src="<?php echo $imagePath; ?>" id="cropbox" class="img" /><br />
</div>
<div id="btn">
    <input type='button' id="crop" value='CROP'>
</div>
<div>
    <img src="#" id="cropped_img" style="display: none;">
</div>
<script type="text/javascript">
$(document).ready(function(){
    var size;
    $('#cropbox').Jcrop({
      aspectRatio: 1,
      onSelect: function(c){
       size = {x:c.x,y:c.y,w:c.w,h:c.h};
       $("#crop").css("visibility", "visible");     
      }
    });
 
    $("#crop").click(function(){
        var img = $("#cropbox").attr('src');
        $("#cropped_img").show();
        $("#cropped_img").attr('src','image-crop.php?x='+size.x+'&y='+size.y+'&w='+size.w+'&h='+size.h+'&img='+img);
    });
});
</script>
</body>
</html>