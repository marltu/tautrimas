<?php echo View::factory('menu'); ?>
<?php echo Form::open('crawler/crawl') ?>

    <div class="form-group">
        <label for="form-url">Website's URL</label>
<!--        <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">-->
        <?php echo Form::input('url', null, array('type' => 'text', 'id' => 'form-url', 'class' => 'form-control', 'placeholder' => 'Enter URL here')); ?>
    </div>
    <?php echo Form::button('save', 'Start crawl', array('type' => 'submit', 'id' => 'form-submit', 'class' => 'btn btn-primary')); ?>

<?php echo Form::close() ?>
