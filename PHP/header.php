<style>
    * {
        padding: 0;
        margin: 0;
    }
    body {
        background-color: #e0e0e0;
    }
    #header {
        background-color: white;
        position: absolute;
        top: 0;
        left: 0;
        width: 100vw;
        height: 60px;
    }
    #header a {
        display: inline-block;
        padding: 19px 16px;
        font: 22px arial,sans-serif;
        line-height: 22px;
        height: 22px !important;
        color: black;
        text-decoration: none;
    }
    
    #header a.active {
        padding: 19px 16px 15px 16px;
        border-bottom: 4px solid #dd0000;
    }
    #search_bar_container {
        text-align: center;
        width: 100vw;
        height: 204px;
        position: absolute;
        top: 60px;
        left: 0px;
        background-image: URL('pic5.jpg');
        background-size: cover ;
        background-position: 50% 50%;
    }
    
    #search_bar_container #main_input {
        width: calc(95vw - 10px);
        max-width: 600px;
        font: 20px arial,sans-serif;
        line-height: 54px;
        height: 54px !important;
        padding: 5px 15px;
        margin-top: 70px;
        transition: 0.5s all;
        border: 0px;
    }
    #search_bar_container .search {
        line-height: 54px;
        height: 54px !important;
        font: 20px arial,sans-serif;
        padding: 5px;
        border-radius: 4px;
        border: 0;
        width: 200px;
        height: 54px;
        transition: 0.5s all;
    }
</style>
<div id="header">
    <a href="#" class="<? if ($page == 'movie')  echo 'active'; ?>">Movie Lookup</a>
    <a href="#" class="<? if ($page == 'find')  echo 'active'; ?>">Find Movies</a>
    <a href="#" class="<? if ($page == 'stat')  echo 'active'; ?>">Statistics Tool</a>
    <a href="#" class="<? if ($page == 'fav')  echo 'active'; ?>">Favorites</a>
    <a href="#" style="float: right;">Sign In</a>
</div>
<div id="search_bar_container">
    <nobr><input type="text" id="main_input" placeholder="<? echo $placeholder; ?>">
        <input type="button" value="Search" class="search" onclick="loadAnswer()"></nobr>
</div>