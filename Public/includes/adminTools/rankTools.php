<?php

    if($_POST) {
        header("Location: ../../rank.php");
    }

?>
<form method="post">
    <div class="rank_container d-flex justify-content-centers">
        <input value="Rank" type="submit" class="rank-button" name="rank">
    </div>
</form>