<html>
<head>
<style>
table td
{
  padding:10px;
}
</style>
</head>
<body>
<?php
function duplicate($d)
{
  global $darray;
  global $karray;
  global $root;
  if($dh=opendir($d))
  {
    while(($file=readdir($dh))!=false)
    {
      if($file=="." || $file=="..")
      {
        continue;
      }
      else if(is_dir($d.$file))
      {
        duplicate($d.$file."/");
      }
      else
      {
        $root[]=$d;
        $darray[]=$file;
        $karray[]=sha1_file($d.$file);
      }
    }
    closedir($dh);
  }
}
function findDuplicate($dir)
{
  duplicate($dir);
  $i=0;
  $j=0;
  $x=0;
  $duplicate="";
  $dup=array();
  global $darray;
  global $karray;
  global $root;
  if(count($karray)>1)
  {
    while($i<count($karray))
    {
      if(array_key_exists($karray[$i],$dup))
      {
        $dup[$karray[$i]].=$root[$i].$darray[$i]."|";
      }
      else
      {
        $dup[$karray[$i]]=$root[$i].$darray[$i]."|";
      }
      $i++;
    }
    $r=array();
    foreach($dup as $key => $value)
    {
      $ax=explode("|",$value);
      if(count($ax)>2)
      {
        $r[]=$value;
      }
    }
    return $r;
  }
}
$dir=$_SERVER['DOCUMENT_ROOT'].parse_url("http://localhost/Root/fCLOUD/User/Desktop/rahulr0047@gmail.com/",PHP_URL_PATH);
$dir=str_replace("\\","/",$dir);
$duplicateFiles=findDuplicate($dir);
//var_dump($duplicateFiles);
foreach($duplicateFiles as $value)
{
  echo "<hr>".$value."<hr>";
}
?>
</body>
</html>
