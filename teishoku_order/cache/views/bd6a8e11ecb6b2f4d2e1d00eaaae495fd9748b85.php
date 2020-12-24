

<?php $__env->startSection('title', 'ログインページ'); ?>

<?php echo $__env->make('layout/header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->startSection('content'); ?>
<p>ログインIDとパスワードを入力してください。</p>
<form method="POST" action="index.php?action=top">
    <div>
        <input type="text" name="user_id">
    </div>
    <div>
        <input type="password" name="password">
    </div>
    <div>
        <input type="submit" value="submit">
    </div>
</form>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout/template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\entry-repository\teishoku_order\view/login.blade.php ENDPATH**/ ?>