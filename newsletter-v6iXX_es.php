<?php

require_once("process.php");

$root = find_element($dom, 'header');

//setlocale(LC_TIME, "es_ES");
if(!setlocale(LC_TIME, "es_MX.UTF-8")) {
    die("setlocale failed Do you need to install the 'language-pack-es' package?");
}
//echo "DEBUG Set local\n";
#setlocale(LC_TIME, "Spanish_Mexican");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<!-- If you delete this meta tag, the ground will open and swallow you. -->
<meta name="viewport" content="width=device-width" />

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Noticias Rápidas de HOLT</title>
        
</head>
 
<body bgcolor="#FFFFFF" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">

<table bgcolor="#3bb66c" marginheight="0" marginwidth="0" cellspacing=0 cellpadding=0 width="600">
    <tr>
        <td width="100%" align="left" height="91"><img src="http://afternet.org/images/pahs/holt_header_es.png" alt="Noticias Rápidas de Holt Elementary" border=none /></td>
    </tr>
</table>
<table cellpadding=0 cellspacing=0 width="600" marginheight="0">
    <tr style="background-color: #333333; color: #ffffff;" >
        <td color="#ffffff" align="center"><?=$root['content']?></td>
        <td color="#ffffff" align="center"><?=strftime("%e de %B, %Y")?></td>
    </tr>
</table>

<!-- Columns -->
<table class="body-wrap" bgcolor="" width="600">
    <tr>
       <td class="container" valign="top" align="" bgcolor="#FFFFFF">
       <p></p>
             <!-- Left Column -->
<?php 
      foreach(find_elements($root['children'], 'header') as $story) {
?>
             <!-- content -->
             <div class="content"><table bgcolor="">
                         <tr>
                                 <?php $img = find_element($story['children'], 'hiddenimage') ?>
                                 <td class="small" width="75" style="vertical-align: top; padding-right:10px;"><img src="http://afternet.org/images/pahs/<?=$img['content']?>" /></td>
                                 <td valign="top">
                                         <h4><?=wiki2html($story)?></h4>
                                        <?php foreach($story['children'] as $p) { ?>
                                            <?php if($p['type'] === 'hiddenimage') { continue; } ?>
                                            <?php if($p['type'] === 'empty') { continue; } ?>
                                            <p>
                                            <?=wiki2html($p)?>
                                            </p>
                                        <?php } ?>
                                 </td>
                         </tr>
             </table></div>
             <!-- /content -->
<?php } ?>
        </td> <!-- left column -->
        <td width="200" valign="top" align="center">
                <table>
                    <tr><td align="center"> <img src="http://afternet.org/images/pahs/es-tome-nota.png"></td></tr>
                    <tr>
                        <td align="left">
                            <small>
                              <?php $calendar = find_element($dom, 'header', 'Calendario');
                              //print_r($calendar);
                              foreach(find_elements($calendar['children'], 'list') as $event) {
                                 ?>
                                 <?=wiki2html($event)?>
                                 <?php
                              }
                              ?>

                            </small>
                        </td>
                    </tr>
                    <tr><td>&nbsp;</td></tr>
                    <?php $volunteer = find_element($dom, 'header', 'voluntario');
                      if($volunteer) {
                    ?>
                    <tr>
                      <td align="center"> <img src="http://afternet.org/images/pahs/volunteer.gif" alt="Volunteer"></td></tr>
                      <tr><td>
                        <small>
                              <?php
                              //print_r($Volunteer);
                              foreach(find_elements($volunteer['children'], 'listitem') as $event) {
                                 ?>
                                 <li><?=wiki2html($event)?></li>
                                 <?php
                              }
                              ?>
                        </small>
                      </td>
                    </tr>
                    <tr><td align="center">
                       <small>
                       Les recordamos que si se anota usted necesita tener sus <a href="https://www.helpcounterweb.com/welcome/apply.php?district=eugene">antecedentes completos</a> en la oficina.
                       </small>
                    </td></tr>
                    <?php } ?>
                </table>
        </td>
   </tr>
</table> <!-- Columns -->

<!-- Non-column items -->
<table class="body-wrap" bgcolor="" width="600">
    <tr>
       <td class="container" align="left" bgcolor="#FFFFFF">

<!-- empty -->


      </td>
   </tr>
</table>

<!-- FOOTER -->
<table class="footer-wrap" style="color: #FFFFFF; background-color: #333333" width="600">
   <tr>
      <td></td>
      <td class="container">
               
         <!-- content -->
         <div class="content">
         <font color="#FFFFFF">
         <table>
         <tr>
            <td align="center">
               <font color="#FFFFFF">
               <p>
               Visite el sitio web de Holt en <a href="http://holt.4j.lane.edu" style="color: #9999FF;">Bertha Holt Elementary School</a>
               o a <a href="https://www.facebook.com/pages/Bertha-Holt-Elementary-PAHS-Parents-at-Holt-School/144445578917319" style="color: #9999FF;">Parents at Holt School en Facebook</a>
               para información de dia al dia.
               Para remover su nombre de nuestra lista de correo mande un correo electrónico a <a href="mailto:mackey@4j.lane.edu" style="color: #9999FF;">Katie Mackey</a>. 
               
               Para someter una sugerencias o 
               comentarios a nuestra hoja informativa favor de mandar un correo 
               electrónico a <a href="mailto:PAHSBoard@gmail.com" style="color: #9999FF;">AL COMITÉ DE PADRES DE HOLT</a>.
               </p>
               </font>
            </td>
         </tr>
         </table>
         </font>
         </div><!-- /content -->
                       
      </td>
      <td></td>
   </tr>
</table><!-- /FOOTER -->

</body>
</html>
