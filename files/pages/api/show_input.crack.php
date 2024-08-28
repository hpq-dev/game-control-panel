<?php 

if(!isset($_POST['ID']) || !isset($_POST['val'])) return;

$i = $_POST['ID'];
$val = $_POST['val'];

echo '
<div class="mt-0 mb-1 mt-2">
	<div class="input-group" id="input-notice" style="margin-top:20px">
        <input type="text" class="form-control" id="notice-data-'.$i.'" placeholder="introdu notita la acest cont" value="'.$val.'">
        <div class="input-group-append">
        	<button class="btn btn-primary" type="button" id="save-notice" data-id="'.$i.'">SAVE</button>
        	'.Token::Create().'
       	</div>
    </div>
</div>';
?>