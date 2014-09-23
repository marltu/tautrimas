
<nav class="navbar navbar-default" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="<?php echo(URL::site('crawler/index')) ?>"><span class="glyphicon glyphicon-flash"></span> <strong>Revive Me</strong></a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li><a href="<?php echo(URL::site('crawler/index')) ?>"><span class="glyphicon glyphicon-th-list"></span> All pages</a></li>
                <li><a href="<?php echo(URL::site('crawler/recent')) ?>"><span class="glyphicon glyphicon-time"></span> Recent pages</a></li>
                <li><a href="<?php echo(URL::site('crawler/crawl')) ?>"><span class="glyphicon glyphicon-upload"></span> Crawl page</a></li>
            </ul>
        </div>
    </div>
</nav>
