<?php echo View::factory('menu'); ?>
<main xmlns="http://www.w3.org/1999/html">
    <table class="table page-list">
        <thead>
            <tr><th>URL</th><th>Language</th></tr>
        </thead>
        <tbody>
            <?php
            /** @noinspection PhpUndefinedVariableInspection */
            foreach ($pages as $page) {
                ?>
                <tr>
                    <td>
                        <a href="<?php echo HTML::chars($page->url); ?>">
                            <?php echo HTML::chars($page->url); ?>
                        </a>
                        <br/>
                        <?php echo HTML::chars(substr($page->body, 0, 100)); ?>
                    </td>
                    <td>
                        <?php echo HTML::chars($page->lang); ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody
    </table>
</main>
