<?php
require_once("../includes/initialize.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<title><?php echo isset($title) ? $title . ' | Monbela Tourist Inn' :  'Monbela Tourist Inn' ; ?></title>
 
    
<link rel="stylesheet" type="text/css" href="<?php echo WEB_ROOT; ?>style.css">  
<link rel="stylesheet" type="text/css" href="<?php echo WEB_ROOT; ?>css/responsive.css">    

<link rel="stylesheet" type="text/css" href="<?php echo WEB_ROOT; ?>css/bootstrap.css">  

<link rel="stylesheet" type="text/css" href="<?php echo WEB_ROOT; ?>fonts/css/font-awesome.min.css"> 

<link rel="stylesheet" type="text/css" href="<?php echo WEB_ROOT; ?>css/custom-navbar.min.css"> 

<!-- DataTables CSS -->
<!-- <link href="<?php echo WEB_ROOT; ?>css/dataTables.bootstrap.css" rel="stylesheet"> -->
 
 <link href="<?php echo WEB_ROOT; ?>css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
 <link href="<?php echo WEB_ROOT; ?>css/datepicker.css" rel="stylesheet" media="screen">

 <link href="<?php echo WEB_ROOT; ?>css/galery.css" rel="stylesheet" media="screen">
 <link href="<?php echo WEB_ROOT; ?>css/ekko-lightbox.css" rel="stylesheet">
</head>
<body onload="window.print();">
<div class="wrapper">
  
  <?php 

  require_once("../includes/initialize.php");
 $query ="SELECT g.`GUESTID`, `G_FNAME`, `G_LNAME`, `G_ADDRESS`,`CONFIRMATIONCODE`, `TRANSDATE`, `ARRIVAL`, `DEPARTURE`, `RPRICE` FROM `tblguest` g ,`tblreservation` r WHERE g.`GUESTID`=r.`GUESTID` and `CONFIRMATIONCODE` ='".$_POST['code']."'";
  $mydb->setQuery($query);
 $res = $mydb->loadsingleResult();


     ?>
    <form action="<?php echo WEB_ROOT;; ?>guest/readprint.php?>" method="POST" target="_blank">
    <!-- Main content -->
    <section class="invoice">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-globe"></i> Monbela Tourist Inn
            <small class="pull-right">Date: <?php echo date('m/d/Y'); ?></small>
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
          From
          <address>
            <strong>Monbela </strong><br>
            795 Folsom Ave, Suite 600<br>
            San Francisco, CA 94107<br>
            Phone: (804) 123-5432<br>
            Email: info@almasaeedstudio.com
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          To
          <address>
            <strong><?php echo $res->G_FNAME . ' ' .$res->G_LNAME; ?>
            </strong><br>
            <?php echo $res->G_ADDRESS; ?> 
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
        <br/>
        <br/>
          <!-- <b>Invoice #007612</b><br>
          <br> -->
          <b>Confirmation ID:</b> <p style="background-color:blue;color:white"> <?php echo $res->CONFIRMATIONCODE; ?></p> 
          <input type="hidden" name="code" value="<?php echo $res->CONFIRMATIONCODE; ?>">
<br>
          <b>Transaction Date:</b> <?php echo  Date($res->TRANSDATE); ?>
<br>
          <b>Account:</b> <?php echo $res->GUESTID; ?>

        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
  <?php 
 
 $query ="SELECT * FROM `tblaccomodation` A,`tblroom`  RM, `tblreservation` RS  WHERE  A.`ACCOMID`=RM.`ACCOMID` AND RM.`ROOMID`=RS.`ROOMID`  and `CONFIRMATIONCODE` ='".$_POST['code']."'";
  $mydb->setQuery($query);
 $res = $mydb->loadResultList(); 


     ?>
      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 table-responsive">
          <table class="table table-striped">
            <thead>
            <tr>
              <th>Room</th>
              <th>Description</th>
              <th>Price</th>
              <th>Arrival</th>
              <th>Departure</th>
              <th>Night(s)</th>
              <th>Subtotal</th>
            </tr>
            </thead>
            <tbody>
            <?php   foreach ($res as $result) {
          $days =  dateDiff(date($result->ARRIVAL),date($result->DEPARTURE));
             ?>

            <tr> 
              <td><?php echo $result->ACCOMODATION . ' [' .$result->ROOM.']' ;?></td>
              <td><?php echo $result->ROOMDESC . ' <br/> Person: ' .  $result->NUMPERSON;?></td>
              <td> &#8377; <?php echo $result->PRICE;?></td>
              <td><?php echo date_format(date_create($result->ARRIVAL),'m/d/Y');?></td>
              <td><?php echo date_format(date_create($result->DEPARTURE),'m/d/Y');?></td>
              <td><?php echo ($days==0) ? '1' : $days;?></td>
              <td> &#8377; <?php echo $result->RPRICE;?></td>
            </tr>
            
            
            <?php 
              @$tot += $result->RPRICE;
            } ?>
            </tbody>
          </table>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <div class="row">
        <!-- accepted payments column -->
        <div class="col-xs-6">
         
        </div>
        <!-- /.col -->
        <div class="col-xs-6">
          <p class="lead">Total Amount</p>

          <div class="table-responsive">
            <table class="table">
              <tr>
                <th style="width:50%">Total:</th>
                <td> &#8377 <?php echo @$tot ; ?></td>
              </tr>
         
            </table>
          </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- this row will not appear when printing -->
      <div class="row no-print">
        <div class="col-xs-12">
          <!-- <a href="<?php echo WEB_ROOT; ?>guest/readprint.php?>" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a> -->
          
        </div>
      </div>
    </section>
    </form>
    <!-- /.content -->
    <div class="clearfix"></div>
 
</div>
<!-- ./wrapper -->
</body>
</html>