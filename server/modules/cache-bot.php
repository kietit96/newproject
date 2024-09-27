<?php
  $cached = fopen($cachefile, 'w');
  fwrite($cached, miniHtml(ob_get_contents()));
  fclose($cached);
  ob_end_flush();
?>