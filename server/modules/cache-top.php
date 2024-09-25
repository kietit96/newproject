<?php
  $cachefile = 'cache/'.md5($_SERVER['QUERY_STRING']);
  if (file_exists($cachefile)) {
    include($cachefile);
    exit;
  }
  function miniHtml($b){return preg_replace(['/\>[^\S ]+/s','/[^\S ]+\</s','/(\s)+/s'],['>','<','\\1'],$b);}
  ob_start('miniHtml');
  if(!is_dir('cache')) mkdir('cache',0777,true);
?>