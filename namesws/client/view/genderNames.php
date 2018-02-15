<?php
require_once('view/head.php');
?>
        <script type="text/javascript" src="js/ranking.js"></script>
    </head>
    <body>
        Ranking&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<a href="./searcher">Searcher</a><br><br>
        <input class="radiobtn" type="radio" name="gender" value="hombre"> Male <input class="radiobtn" type="radio" name="gender" value="mujer"> Female<br><br>
        <table id="list" cellspacing="10"></table><br><br>
        <button id="btnPrevious">Previous</button>
        <button id="btnNext">Next</button>
    </body>
</html>


