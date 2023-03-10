<div class="card">
      <div id="img<?php echo $id;?>" class="cardimg card<?php echo $id;?>"></div>
      <h2><?php echo $name;?></h2> 
      <p><?php echo $description;?></p>
    </div>
    
<script>
    changeImg(<?php echo "\"img" . $id."\", \"" .$imgsrc. "\"";?>);
</script>
