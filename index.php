<?php
require_once 'includes/autoloader.php';
require_once 'includes/logincheck.php';
session_start();
authenticated();
require_once 'includes/pageglobals.php';
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <title>Pazaak</title>
    <?php
    require_once 'includes/head.php';
    ?>
    <script src="pazaak/static/js/gambling/utils.js"></script>
    <script>
        function hider(id) {
            var elements = document.getElementById("decks-continer").querySelectorAll("#" + id);
            for (var i = 0; i < elements.length; i++) {
                var node = elements[i];
                if (node == null) {
                    return;
                }
                if (node.style.display === "none") {
                    node.style.display = "block";
                } else {
                    node.style.display = "none";
                }
            }
        }
    </script>
</head>
<div class='card'>
    <div class='card-header'>
        <div class="col-12 col-sm-12">
            <ul class="nav nav-tabs">
                <li class="nav-item justify-content-center border">
                    <a target="_blank" href="https://starwars.fandom.com/wiki/Pazaak/Legends#:~:text=Pazaak%2C%20a%20game%20dating%20back,players%20tied%20was%20not%20counted.">
                        <button type="button" class="btn btn-sm btn-secondary">
                            How To Play
                        </button></a>
                </li>
                <li class="nav-item justify-content-center border">
                    <a href="{% url 'gambling:pazaak-decks' %}">
                        <button type="button" class="btn btn-sm btn-secondary">
                            Decks
                        </button></a>
                </li>
                <li class="nav-item justify-content-center border">
                    <a href="{% url 'gambling:pazaak-cards' %}">
                        <button type="button" class="btn btn-sm btn-secondary">
                            Cards
                        </button></a>
                </li>
                <li class="nav-item justify-content-center border">
                    <a href="{% url 'gambling:pazaak-creategame' %}">
                        <button type="button" class="btn btn-sm btn-secondary">
                            Create Game
                        </button></a>
                </li>
                <li class="nav-item justify-content-center border">
                    <a href="{% url 'gambling:stats' %}">
                        <button type="button" class="btn btn-sm btn-secondary">
                            Gambling Stats
                        </button></a>
                </li>
            </ul>
        </div>
    </div>
    <div class='card-body' id="decks-continer">
        <div class='card border border-darker'>
            <div class='card-headder'>
                <div class="col-12 col-sm-12">
                    <h3>Pazaak:</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <p>Welcome to Pazaak! Pazaak is game dating back to Old Republic times, and
                            was a popular card game in which the goal was to come closest to 20
                            without going over. The player with the highest score less than or
                            equal to 20 wins the set, and the player who wins three sets wins
                            the match. A set in which the two players are tied is not counted.
                            If you would like more detail, please click the "How To Play" button above.</p>
                        <br>
                        <p>Because the house needs to keep the lights on, every game you play will cost
                            50,000 credits.
                            All credit lines will bottom out at {{limit|intcomma}} and once you reach that
                            limit you will
                            not be able to play anymore.
                            So, pay your bills and enjoy yoursef.
                        </p>
                        {%if access == False %}
                        <h4 style="color:red"> Item access is not enabled. If you go to any other location
                            any owned cards will be removed.</h4>
                        <a href="{% url 'profile:profile'%}">
                            <button type="button" class="btn btn-sm btn-danger">
                                Enable Inventry Access Now
                            </button></a>
                        {%endif%}
                        {%if debt <= limit%}
                        <h4 style="color:red"> You reached the credit Line limit and are now unable to play
                            or watch Pazaak games. </h4>
                        {%endif%}
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="card border border-darker">
                            <div class="card-header">
                                <h3>Stats:</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6 col-sm-3">
                                        <p>Wins: {{wins|intcomma}}</p>
                                        <p>Losses: {{loses|intcomma}}</p>
                                    </div>
                                    <div class="col-12 col-sm-9">
                                        <div class="row" style="padding:0px">
                                            <p style="margin: 8px;">&nbsp;&nbsp;Credit Line:&nbsp;</p>
                                            {%if debt <= limit%}
                                            <a href="{% url 'gambling:creditline-deposit'%}">
                                                <button type="button" class="btn btn-sm btn-danger">
                                                    {{debt|intcomma}}
                                                </button></a>
                                            <p style="color:red">
                                                {% elif debt > limit and debt < 0%}
                                                <a href="{% url 'gambling:creditline-deposit'%}">
                                                    <button type="button" class="btn btn-sm btn-warning">
                                                        {{debt|intcomma}}
                                                    </button></a>
                                                {%else%}
                                                <a href="{% url 'gambling:creditline-deposit'%}">
                                                    <button type="button" class="btn btn-sm btn-secondary">
                                                        {{debt|intcomma}}
                                                    </button></a>
                                                {%endif%}
                                                {%if debt < 0%}
                                                {%endif%}
                                        </div>
                                        <p>Total Games Played: {{totalGames|intcomma}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class='card border border-darker'>
            <div class='card-header'>
                <div class="col-12 col-sm-12">
                    <h3>Playable Games:</h3>
                </div>
            </div>
            <div class='card-body'>
                <div class="row">
                    {%if pgames %}
                    {%for game in pgames %}
                    <div class="col-12 col-sm-6 col-lg-4">
                        <div class="card border border-darker">
                            <button type="button" class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse-game-{{forloop.counter}}" aria-expanded="false" aria-controls="collapse-game-{{forloop.counter}}" onclick="hider('collapse-game-{{forloop.counter}}-hidden')">
                                <div class="card-header">
                                    <u>
                                        <h3>Name: {{game.name}}</h3>
                                    </u>
                                    <div style="display:block" id="collapse-game-{{forloop.counter}}-hidden">
                                        <div class="row">
                                            <div class="col-12 col-sm-6">
                                                <h4>Player 1: {{game.player1}}</h4>
                                            </div>
                                            <div class="col-12 col-sm-6">
                                                {%if game.player2 %}
                                                <h4>Player 2: {{game.player2}}</h4>
                                                {%else%}
                                                {%if game.joinable%}
                                                <h4>Player 2: Waiting for Player 2</h4>
                                                {%else%}
                                                <h4>Player 2: None</h4>
                                                {%endif%}
                                                {%endif%}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </button>
                            <div id="collapse-game-{{forloop.counter}}" class="collapse" aria-labelledby="headingOne">
                                <div class="card-body">
                                    <div class="col-12 col-sm-12">
                                        <div class="card border border-darker">
                                            <div class="card-header">
                                                <h4>Players:</h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <h4>Player 1: {{game.player1}}</h4>
                                                    </div>
                                                    <div class="col-12 justify-content-center">
                                                        <h5>Wins: {{game.player1.wins}}</h5>
                                                    </div>
                                                    <div class="col-12">
                                                        {%if game.player2 %}
                                                        <h4>Player 2: {{game.player2}}</h4>
                                                        {%else%}
                                                        {%if game.owner %}
                                                        <p>Player 2 has not joined yet. Use the link to get a game
                                                            link
                                                            for another player</p>
                                                        {%else%}
                                                        <p>Needs another player.</p>
                                                        {%endif%}
                                                        {%endif%}
                                                    </div>
                                                    {%if game.player2%}
                                                    <div class="col-12 justify-content-center">
                                                        <h5>Wins: {{game.player2.wins}}</h5>
                                                    </div>
                                                    {%endif%}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card border border-darker">
                                            <div class="card-header">
                                                <h4>State:</h4>
                                            </div>
                                            <div class="card-body">
                                                {%if not game.active %}
                                                <p>{{game.ready_to_start}}</p>
                                                {%else%}
                                                {%if game.ready%}
                                                {%if game.winner%}
                                                <p>{{game.winner}} won the last round</p>
                                                {%else%}
                                                {%if game.player1Joined and game.player2Joined%}
                                                <p>Current game is playing</p>
                                                {%else%}
                                                <p>Nobody is playing</p>
                                                {%endif%}
                                                {%endif%}
                                                {%else%}
                                                <p>Game has not started</p>
                                                {%endif%}
                                                {%endif%}
                                                <p>Rounds Played: {{game.round}}</p>
                                            </div>
                                        </div>
                                        <div class="card border border-darker">
                                            <div class="card-header">
                                                <h4>Links:</h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-3 col-sm-3">
                                                        {%if game.ready %}
                                                        <a href="{% url 'gambling:pazaak-playgame' game.pk %}">
                                                            <button type="button" class="btn btn-sm btn-secondary" title="Play Pazaak">
                                                                <i class="tim-icons icon-controller"></i>
                                                            </button>
                                                        </a>
                                                        {%else%}
                                                        <a href="{% url 'gambling:pazaak-gamesetup' game.pk %}">
                                                            <button type="button" class="btn btn-sm btn-secondary" title="Setup Pazaak">
                                                                <i class="tim-icons icon-settings-gear-63"></i>
                                                            </button></a>
                                                        {%endif%}
                                                    </div>
                                                    <div class="col-3 col-sm-3">
                                                        {%if game.owner %}
                                                        <a href="{% url 'gambling:pazaak-deletegame' game.pk %}">
                                                            <button type="button" class="btn btn-sm btn-secondary" title="Delete Game">
                                                                <i class="tim-icons icon-trash-simple"></i>
                                                            </button>
                                                        </a>
                                                        {%endif%}
                                                    </div>
                                                    <div class="col-12 col-sm-12">
                                                        {%if game.player2 == None%}
                                                        {%if game.owner %}
                                                        <button type="button" id="GameButton" class="btn btn-sm btn-secondary" onclick="CopyGameLink()" value="{{baseUrl}}{{game.get_game_link}}">
                                                            Copy opponent link
                                                        </button>
                                                        {%else%}
                                                        <p>Needs another player.</p>
                                                        {%endif%}
                                                        {%endif%}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="col-12 col-sm-12" id="collapse-game-{{forloop.counter}}-hidden" style="display:block">
                                    <div class="row">
                                        <div class="col-3 col-sm-3">
                                            {%if game.ready %}
                                            <a href="{% url 'gambling:pazaak-playgame' game.pk %}">
                                                <button type="button" class="btn btn-sm btn-secondary" title="Play Pazaak">
                                                    <i class="tim-icons icon-controller"></i>
                                                </button>
                                            </a>
                                            {%else%}
                                            <a href="{% url 'gambling:pazaak-gamesetup' game.pk %}">
                                                <button type="button" class="btn btn-sm btn-secondary" title="Setup Pazaak">
                                                    <i class="tim-icons icon-settings-gear-63"></i>
                                                </button></a>
                                            {%endif%}
                                        </div>
                                        <div class="col-3 col-sm-3">
                                            {%if game.owner %}
                                            <a href="{% url 'gambling:pazaak-deletegame' game.pk %}">
                                                <button type="button" class="btn btn-sm btn-secondary" title="Delete Game">
                                                    <i class="tim-icons icon-trash-simple"></i>
                                                </button>
                                            </a>
                                            {%endif%}
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-6">
                                            {%if game.player2 == None%}
                                            {%if game.owner %}
                                            <button type="button" id="GameButton" class="btn btn-sm btn-secondary" onclick="CopyGameLink()" value="{{baseUrl}}{{game.get_game_link}}">
                                                Copy opponent link
                                            </button>
                                            {%else%}
                                            <p>Needs another player.</p>
                                            {%endif%}
                                            {%endif%}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {%endfor%}
                    {%else%}
                    <div class="col-12 col-sm-12">
                        <h4>No games are currently available for you to play.</h4>
                    </div>
                    {%endif%}
                </div>
            </div>
        </div>
        <div class='card border border-darker'>
            <div class='card-header'>
                <div class="col-12 col-sm-12">
                    <h3>Watchable Games:</h3>
                </div>
            </div>
            <div class='card-body' id="decks-continer">
                <div class="row">
                    {%if wgames %}
                    {%for game in wgames %}
                    <div class="col-12 col-sm-6 col-lg-4">
                        <div class="card border border-darker">
                            <button type="button" class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse-watch-{{forloop.counter}}" aria-expanded="false" aria-controls="collapse-watch-{{forloop.counter}}" onclick="hider('collapse-watch-{{forloop.counter}}-hidden')">
                                <div class="card-header">
                                    <u>
                                        <h3>Name: {{game.name}}</h3>
                                    </u>
                                    <div style="display:block" id="collapse-game-{{forloop.counter}}-hidden">
                                        <div class="row">
                                            <div class="col-12 col-sm-6">
                                                <h4>Player 1: {{game.player1}}</h4>
                                            </div>
                                            <div class="col-12 col-sm-6">
                                                {%if game.player2 %}
                                                <h4>Player 2: {{game.player2}}</h4>
                                                {%else%}
                                                <h4>Player 2: None</h4>
                                                {%endif%}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </button>
                            <div id="collapse-watch-{{forloop.counter}}" class="collapse" aria-labelledby="headingOne">
                                <div class="card-body">
                                    <div class="col-12 col-sm-12">
                                        <div class="card border border-darker">
                                            <div class="card-header">
                                                <h4>Players:</h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <h4>Player 1: {{game.player1}}</h4>
                                                    </div>
                                                    <div class="col-12 justify-content-center">
                                                        <h5>Wins: {{game.player1.wins}}</h5>
                                                    </div>
                                                    <div class="col-12">
                                                        {%if game.player2%}
                                                        <h4>Player 2: {{game.player2}}</h4>
                                                        {%else%}
                                                        {%if game.joinable%}
                                                        <h4>Player 2:
                                                            <a href="{{game.get_game_link}}">
                                                                <button type="button" class="btn btn-sm btn-secondary">
                                                                    Click to join game
                                                                </button></a>
                                                        </h4>
                                                        {%else%}
                                                        <h5>Needs another player.</h5>
                                                        {%endif%}
                                                        {%endif%}
                                                    </div>
                                                    {%if game.player2%}
                                                    <div class="col-12 justify-content-center">
                                                        <h5>Wins: {{game.player2.wins}}</h5>
                                                    </div>
                                                    {%endif%}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card border border-darker">
                                            <div class="card-header">
                                                <h4>State:</h4>
                                            </div>
                                            <div class="card-body">
                                                {%if not game.active %}
                                                <p>{{game.ready_to_start}}</p>
                                                {%else%}
                                                {%if game.ready%}
                                                {%if game.winner%}
                                                <p>{{game.winner}} won the last round</p>
                                                {%else%}
                                                {%if game.player1Joined and game.player2Joined%}
                                                <p>Current game is playing</p>
                                                {%else%}
                                                <p>Nobody is playing</p>
                                                {%endif%}
                                                {%endif%}
                                                {%else%}
                                                <p>Game has not started</p>
                                                {%endif%}
                                                {%endif%}
                                                <p>Rounds Played: {{game.round}}</p>
                                            </div>
                                        </div>
                                        <div class="card border border-darker">
                                            <div class="card-header">
                                                <h4>Links:</h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="col-12">
                                                    {%if game.ready %}
                                                    <a href="{% url 'gambling:pazaak-playgame' game.pk %}">
                                                        <button type="button" class="btn btn-sm btn-secondary" title="Watch Pazaak">
                                                            Watch Game
                                                        </button>
                                                    </a>
                                                    {%else%}
                                                    <h5>A link will be available when the game is ready</h5>
                                                    {%endif%}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="col-12 col-sm-12 center" id="collapse-watch-{{forloop.counter}}-hidden" style="display:block">
                                    {%if game.ready %}
                                    <a href="{% url 'gambling:pazaak-playgame' game.pk %}">
                                        <button type="button" class="btn btn-sm btn-secondary" title="Watch Pazaak">
                                            Watch Game
                                        </button>
                                    </a>
                                    {%elif not game.player2%}
                                    {%if game.joinable%}
                                    <a href="{{game.get_game_link}}">
                                        <button type="button" class="btn btn-sm btn-secondary">
                                            Click to join the game.
                                        </button>
                                    </a>
                                    {%else%}
                                    <h4>A link will be available when the game is ready</h4>
                                    {%endif%}
                                    {%else%}
                                    <h4>A link will be available when the game is ready</h4>
                                    {%endif%}
                                </div>
                            </div>
                        </div>
                    </div>
                    {%endfor%}
                    {%else%}
                    <div class="col-12 col-sm-12">
                        <h4>No games are currently available to watch.</h4>
                    </div>
                    {%endif%}
                </div>
            </div>
        </div>
    </div>
</div>
</html>