<?php
require_once('view/head.php');
?>
        <script type="text/javascript" src="js/searcher.js"></script>
    </head>
    <body>
        <a href="./">Ranking</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;Searcher<br><br>
        <input class="radiobtn" type="radio" name="gender" value="hombre"> Male <input class="radiobtn" type="radio" name="gender" value="mujer"> Female<br><br>
        <input type="text" id="inNames" /><br><br>
        <span id="names"></span>
    </body>
</html>