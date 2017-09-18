<?php

require_once("process.php");

$root = find_element($dom, 'header');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<!-- If you delete this meta tag, the ground will open and swallow you. -->
<meta name="viewport" content="width=device-width" />

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Holt Quick News</title>
        
</head>
 
<body bgcolor="#FFFFFF" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">

<table bgcolor="#3bb66c" marginheight="0" marginwidth="0" cellspacing=0 cellpadding=0 width="600">
    <tr>
        <td width="100%" align="left" height="91"><img src="http://afternet.org/images/pahs/holt_header.png" alt="Holt Elementary &nbsp;&nbsp;&nbsp; &nbsp;&nbsp; Quick News" border=none /></td>
    </tr>
</table>
<table cellpadding=0 cellspacing=0 width="600" marginheight="0">
    <tr style="background-color: #333333; color: #ffffff;" >
        <td color="#ffffff" align="center"><?=$root['content']?></td>
        <td color="#ffffff" align="center"><?=date("M jS, o")?></td>
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
                                 <td>
                                         <h4 style="margin-top: 0;"><?=wiki2html($story)?></h4>
                                        <?php foreach($story['children'] as $p) { ?>
                                            <?php if($p['type'] === 'hiddenimage') { continue; } ?>
                                            <?php if($p['type'] === 'empty') { continue; } ?>
                                            <p>
                                            <?=wiki2html($p)?>
                                            </p>
                                        <?php } ?>
                                 </td>
                         </tr>
             </table></div><!-- /content -->
<?php } ?>
        <!-- Calendar -->
        <td width="200" valign="top">
                <table>
                    <tr><td align="center"> <img src="http://afternet.org/images/pahs/mark-your-calendar.gif" alt="Mark Your Calendar"></td></tr>
                    <tr>
                        <td align="left">
                            <small>
                              <?php $calendar = find_element($dom, 'header', 'Calendar'); 
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
                    <?php $volunteer = find_element($dom, 'header', 'Volunteer'); 
                      if($volunteer) {
                    ?>
                    <tr>
                      <td align="center"> <img src="http://afternet.org/images/pahs/volunteer.gif" alt="Volunteer"></td></tr>
                      <tr><td>
                        <small>
                              <?php
                              //print_r($Volunteer);
                              foreach(find_elements($volunteer['children'], 'list') as $event) {
                                 ?>
                                 <?=wiki2html($event)?>
                                 <?php
                              }
                              ?>
                        </small>
                      </td>
                    </tr>
                    <tr><td align="center">
                       <small>
                       Please have your <a href="https://www.helpcounterweb.com/welcome/apply.php?district=eugene">background check</a> complete.
                       </small>
                    </td></tr>
                    <?php } ?>
                </table>
        </td>
         <!-- End Calendar -->

   </tr>
</table>
<!-- Columns -->

<!-- Non-column items -->
<table class="body-wrap" bgcolor="" width="600">
    <tr>
       <td class="container" align="left" bgcolor="#FFFFFF">


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
               Visit the <a href="http://holt.4j.lane.edu" style="color: #9999FF;">Bertha Holt Elementary School</a> Website or 
               <a href="https://www.facebook.com/pages/Bertha-Holt-Elementary-PAHS-Parents-at-Holt-School/144445578917319" style="color: #9999FF;">Parents at Holt School on Facebook</a> for up-to-date school information. To remove your name from our mailing list, email <a href="mailto:mackey@4j.lane.edu" style="color: #9999FF;">Katie Mackey</a>. For newsletter comments or submissions, email the <a href="mailto:PAHSBoard@gmail.com" style="color: #9999FF;">PAHS Board</a>.
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
