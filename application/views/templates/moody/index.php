<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">

    <title>Josh Moody</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
    <meta name="description" content="husband, father, son, software developer, mac addict">
    <meta name="author" content="Josh Moody">
    
    <link href="//fonts.googleapis.com/css?family=Droid+Sans|Advent+Pro|Raleway" rel="stylesheet" type="text/css">
    <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.min.css" rel="stylesheet">

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/js/bootstrap.min.js"></script>
    <link href="<?=base_url('assets/themes/moody/style.min.css');?>" rel="stylesheet">

    
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
	    <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	
</head>

<body>
    <div class="navbar navbar-fixed-top">
        <div class="navbar-inner">
            <div class="container">
                <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
                </a>
                
                <a class="brand" href="<?=site_url('home/index');?>">{site_title}</a>

                <div class="nav-collapse collapse">
                    <p class="navbar-text pull-right hidden-phone">&raquo; Tagline</p>

                    <ul class="nav">
                        <li class="active">
                            <a href="#">Link</a>
                        </li>
                    </ul>
                    
                </div><!--/.nav-collapse -->
            </div>
        </div>
    </div>

    <div class="container-fluid clearfix" id="main-content">
        {body}
    </div><!--/.container -->
</body>
</html>
