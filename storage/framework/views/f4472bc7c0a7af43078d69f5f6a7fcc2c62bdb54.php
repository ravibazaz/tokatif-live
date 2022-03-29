<?php echo $__env->make('include/head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php if(session('id')!='' && session('role')=='1'): ?>
    <?php echo $__env->make('include/student-dashboard-header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php elseif(session('id')!='' && session('role')=='2'): ?>
    <?php echo $__env->make('include/teacher-dashboard-header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php else: ?>
    <?php echo $__env->make('include/header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?>


<?php 
$getVisitorCountry = getVisitorCountry();
?>




<section id="terms-page" class="bg-snow wide-70 inner-page-hero terms-section division">
	<div class="container">


		<!-- TERMS CONTENT -->
		<div class="row justify-content-center">	
			<div class="col-lg-10">


				<!-- TERMS TITLE -->
				<div class="terms-title text-center">

					<!-- Title -->
					<h2 class="h2-md">Our terms and conditions</h2>


				</div>


				<!-- DIVIDER LINE -->
				<hr class="divider">

				<!-- TERMS BOX -->
				<div class="terms-box">

					<?php $__currentLoopData = $terms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<h5 class="h5-xl"><?php echo e($val->title); ?></h5>
					
					<p class="p-lg"><?php echo e($val->description); ?></p>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					
					

				</div>	<!-- END TERMS BOX -->


			</div>	<!-- END TERMS CONTENT -->


		</div>     <!-- End row -->		
	</div>	    <!-- End container -->
</section>



<?php echo $__env->make('include/footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>








<?php /**PATH /home/tokatifc/public_html/resources/views/terms/list.blade.php ENDPATH**/ ?>