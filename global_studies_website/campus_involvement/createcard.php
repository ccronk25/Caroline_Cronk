    <div class="card">
        <div id="img<?php echo $section . $id;?>" class="cardimg card<?php echo $id;?>"></div>
        <div class="content">
        <h2><?php echo $name;?></h2>
        <p><?php echo $description;?></p> 
        </div>
            <a class="more"></a> 
    </div>

    <script>
        changeImg(<?php echo "\"img" .$section . $id."\", \"" .$imgsrc. "\"";?>); 
    </script>
