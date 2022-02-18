
<!-- Content Header (Page header) -->
<?php $__env->startSection('content'); ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"><?php echo e($title); ?></h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <?php echo $__env->make('admin.includes.breadcrumb',['breadcrumb'=>$breadcrumb], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-12 mb-3 text-center">
                <!-- <h3>Project Summary of last Week</h3> -->
            </div>
        </div>
        <!--<div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                <div class="completed-box">
                    <h4>Completed</h4>
                    <h5> </h5>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                <div class="completed-box">
                    <h4>Ongoing</h4>
                    <h5> </h5>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                <div class="completed-box">
                    <h4>Uninitiated</h4>
                    <h5> </h5>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-12 mt-4">
                <h3 class="over-all">Overall Project Rating </h3>
            </div>
        </div>-->
        
    </div>
    <!-- /.container-fluid -->
</section>
<?php $__env->stopSection(); ?>
<style>
    .margin {
    margin: 25px;
    }
    .multi-graph {
    width: 300px;
    height: 150px;
    position: relative;
    color: #333;
    font-size: 22px;
    font-weight: 600;
    display: flex;
    align-items: flex-end;
    justify-content: center;
    overflow: hidden;
    box-sizing: border-box;
    margin: 0 auto;
    }
    .multi-graph:before {
    content: "";
    width: 300px;
    height: 150px;
    border: 50px solid #019a5a;
    border-bottom: none;
    position: absolute;
    box-sizing: border-box;
    transform-origin: 50% 0%;
    border-radius: 300px 300px 0 0;
    left: 0;
    top: 0;
    }
    .multi-graph .graph {
    width: 300px;
    height: 150px;
    border: 50px solid var(--fill);
    border-top: none;
    position: absolute;
    transform-origin: 50% 0% 0;
    border-radius: 0 0 300px 300px;
    left: 0;
    top: 100%;
    z-index: 5;
    -webkit-animation: 1s fillGraphAnimation ease-in;
    animation: 1s fillGraphAnimation ease-in;
    transform: rotate(calc( 1deg * ( var(--percentage) * 1.8 ) ));
    box-sizing: border-box;
    cursor: pointer;
    }
    .multi-graph .graph:after {
    content: attr(data-name) " " counter(varible) "%";
    counter-reset: varible var(--percentage);
    background: var(--fill);
    box-sizing: border-box;
    border-radius: 2px;
    color: #fff;
    font-weight: 200;
    font-size: 12px;
    height: 20px;
    padding: 3px 5px;
    top: 0px;
    position: absolute;
    left: 0;
    transform: rotate(calc( -1deg * var(--percentage) * 1.8 )) translate(-30px, 0px);
    transition: 0.2s ease-in;
    transform-origin: 0 50% 0;
    opacity: 0;
    }
    .multi-graph .graph:hover {
    opacity: 0.8;
    }
    .multi-graph .graph:hover:after {
    opacity: 1;
    left: 30px;
    }
    @-webkit-keyframes fillAnimation {
    0% {
    transform: rotate(-45deg);
    }
    50% {
    transform: rotate(135deg);
    }
    }
    @keyframes  fillAnimation {
    0% {
    transform: rotate(-45deg);
    }
    50% {
    transform: rotate(135deg);
    }
    }
    @-webkit-keyframes fillGraphAnimation {
    0% {
    transform: rotate(0deg);
    }
    50% {
    transform: rotate(180deg);
    }
    }
    @keyframes  fillGraphAnimation {
    0% {
    transform: rotate(0deg);
    }
    50% {
    transform: rotate(180deg);
    }
    }
    .completed-box {
    background-color: #fff;
    padding: 30px 30px;
    text-align: center;
    border-radius: 4px;
    box-shadow: 0px 0px 5px 0px #d9cfcf;
    }
    .completed-box h5 {
    font-weight: 600;
    font-size: 30px;
    }
    .delayed h4 { text-align:right; font-size:20px; color:#f56526;}
    .Ontime h4 { text-align:center; font-size:20px; color:#000;}
    .Ontime h4 { text-align:left; font-size:20px; color:#2da40c;}
    .activites-list {
    background-color: #7b7a7a;
    padding: 15px 15px;
    display: block;
    float: left;
    width: 100%;
    border-radius: 10px;
	max-height: 400px;
	overflow-y: scroll;
    }
    .activites-list ul{ padding:0;}
    .activites-list ul li {
    list-style: none;
    display: block;
    width: 100%;
    float: left;
    padding: 8px 0;
    }
    .activites-list ul li h4 {
    color: #fff;
    font-size: 16px;
    display: block;
    float: left;
    text-align: center;
    padding-right: 15px;
    border-right: 1px solid #fff;
    }
    .activites-list ul li h4 span{ display:block;}
    .activites-list ul li h5{ color: #fff; font-size:16px; display:block; float:left; padding-left: 15px; display: block;
    float: left;
    text-align: left;}
    .activites-list ul li h5 span{ display:block;}
    .btn-create a {
    background-color: #d19351;
    color: #fff;
    font-size: 18px;
    border-radius: 4px;
    padding: 12px 80px;
    display: inline-block;
    margin: 30px 0;
    }
    .today-active { font-size:16px; text-align:left; color:#fff;}
    .all-active a{ font-size:16px; text-align:left; color:#7272F2; text-align:right; padding-bottom: 10px;
    display: block;}
    .grap-box {
    background-color: #1b262a;
    padding: 30px 30px;
    border-radius: 10px;
    }
    h3.total-project{ color:#333; padding-bottom: 20px;}
    .Project h4{ color:#333;}
    h3.over-all {
    padding: 30px 0;
    text-align: center;
    }

.today-active {
    color: #333;
    padding-bottom: 15px;
}



/* When the browser is at least 600px and above */

@media  screen and (min-width: 1024px) {
  .grap-box {
	  background-color:#fff;
	  border-radius: 0;
  }
}
	
	
	
</style>
<?php echo $__env->make('admin.layouts.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/tokatifc/staging.tokatif.com/resources/views/admin/dashboard/index.blade.php ENDPATH**/ ?>