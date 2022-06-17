const drawnImage = "/static/img/gambling/adminCard.png";
const opponentImages = "/static/img/gambling/blankCard.png"
const winImage = "/static/img/gambling/winning_icon.png";
const negPosCard = "/static/img/gambling/negPosCard.png";
const flipImage = "/static/img/gambling/rotate-512.png";
const volumeImg = "/static/img/gambling/volume.png";
const muteImg = "/static/img/gambling/mute.png";

var volume = 0.7;

function joined() {
    chatSocket.onopen = () => chatSocket.send(JSON.stringify({
        'event': "JOINED"
    }));
}

function createButton(id, buttonMsg) {
    var button = document.createElement('button');
    button.innerHTML = buttonMsg;
    button.classList.add("center");
    var style = "font-size:1rem;";
    style += "color:gold;";
    style += "border:1px solid gold;";
    style += "background-color: transparent;";
    style += "border-radius: 10px;";
    style += "padding: 5px;";
    style += "width: 100px;";
    button.style = style;
    button.id = id;
    return button;
}

function createImage(tag, locationTop, locationLeft) {
    var img = document.getElementById(tag);
    var created = false;
    if (img) {
        created = true;
    } else {
        img = document.createElement('img');
    }
    img.src = flipImage;
    img.id = tag;
    var style = "position: absolute;";
    style += "z-index:2;";
    style += "width:2.2%;";
    locationTop += 65;
    locationLeft += 12;
    style += "top:" + locationTop + "px;";
    style += "left:" + locationLeft + "px;";
    img.style = style;
    document.getElementById('game-board').appendChild(img);
    return created;
}

function addMessage(color, message, buttons) {
    var div = document.createElement('div');
    var span = document.createElement('p');
    div.classList.add("pazaak-msg-box");
    var style = "font-size:1.5rem;";
    style += "color:" + color + ";";
    style += "text-align:center;";
    span.style = style;
    span.innerHTML = message;
    div.id = "message-tag";
    span.id = "message-tag";
    div.appendChild(span);
    for (var i = 0; i < buttons.length; i++) {
        div.append(buttons[i]);
    }
    document.getElementById('game-board').appendChild(div);
}

function playSound(sound) {
    var audio = new Audio(sound);
    audio.volume = volume;
    audio.play();
}

function addButtonAction(tag, event, msg) {
    document.querySelector('#' + tag).onclick = function(e) {
        chatSocket.send(JSON.stringify({
            'event': event,
            'message': msg
        }));
    };
}

function removeButtonAction(tag) {
    var element = document.querySelector("#" + tag);
    if (element) {
        element.removeAttribute("onclick");
    }
}

function removeMessage() {
    var element = document.getElementById("message-tag");
    if (element) {
        element.parentNode.removeChild(element);
    }
    element = document.getElementById("message-button-tag");
    if (element) {
        element.parentNode.removeChild(element);
    }
}

function toggleMute() {
    var mute = document.getElementById("soundIcon");
    if (mute) {
        if (volume > 0) {
            volume = 0.0;
            mute.src = muteImg;
        } else {
            volume = 0.7;
            mute.src = volumeImg;
        }
    }
}

function addCardValue(value, locationTop, locationLeft) {
    var span = document.createElement('span');
    var style = "height:1px;";
    value = value.toString();
    style += "position: absolute;";
    style += "z-index:2;";
    style += "font-size:12px;";
    style += "color:white;";
    locationTop += 18;
    locationLeft += 16;
    if (value.length < 2) {
        value = "&nbsp" + value;
    }
    style += "top:" + locationTop + "px;";
    style += "left:" + locationLeft + "px;";
    span.id = "card-tag";
    span.style = style;
    span.innerHTML = value;
    document.getElementById('game-board').appendChild(span);
}

function addwin(imagePath, locationTop, locationLeft) {
    var img = document.createElement('img');
    var style = "position: absolute;";
    style += "z-index:2;";
    style += "top:" + locationTop + "px;";
    style += "left:" + locationLeft + "px;";
    img.id = "winicon-tag";
    img.style = style;
    img.src = imagePath;
    document.getElementById('game-board').appendChild(img);
}

function removewins() {
    var elements = document.getElementById("game-board").querySelectorAll("#winicon-tag");

    for (var i = 0; i < elements.length; i++) {
        var node = elements[i];
        node.parentNode.removeChild(node);
    }
}

function addCard(imagePath, locationTop, locationLeft) {
    var img = document.createElement('img');
    var style = "height:65px;";
    style += "position: absolute;";
    style += "z-index:1;";
    style += "top:" + locationTop + "px;";
    style += "left:" + locationLeft + "px;";
    img.id = "card-tag";
    img.style = style;
    img.src = imagePath;
    document.getElementById('game-board').appendChild(img);
}

function addPlayerCard(imagePath, tag, locationTop, locationLeft) {
    var button = document.getElementById(tag);
    var created = false;
    if (button) {
        created = true;
    } else {
        button = document.createElement('button');
    }

    var img = document.createElement('img');
    var style = "position: absolute;";
    style += "border:0px solid black;";
    style += "padding:0;";
    style += "background-color: transparent;";
    style += "z-index:1;";
    style += "top:" + locationTop + "px;";
    style += "left:" + locationLeft + "px;";
    button.id = tag;
    button.style = style;
    style = "height:65px;";
    img.id = "card-tag";
    img.style = style;
    img.src = imagePath;
    button.appendChild(img);
    document.getElementById('game-board').appendChild(button);
    return created;
}

function setScore(value, player) {
    value = value.toString();
    var span = document.getElementById(player)
    if (value.length < 2) {
        value = "&nbsp" + value;
    }
    span.innerHTML = value;
}

function cleanBoard() {
    var elements = document.getElementById("game-board").querySelectorAll("#card-tag");
    for (var i = 0; i < elements.length; i++) {
        var node = elements[i];
        node.parentNode.removeChild(node);
    }
}

function setPlayerName(tag, playerName) {
    var span = document.getElementById(tag);
    if (span) {
        span.innerHTML = playerName;
    }
}

function placeCards(cards) {
    if (cards == null) {
        return;
    }
    for (var i = 0; i < cards.length; i++) {
        var card = cards[i];
        var image = card['image'];
        if (image) {
            addCard(image, card['top'], card['left']);
        } else {
            addCard(drawnImage, card['top'], card['left']);
        }
        addCardValue(card['value'], card['top'], card['left']);
    }
}

function placePlayerCards(cards, opponent, turn) {
    if (cards == null) {
        return;
    }
    for (var i = 0; i < cards.length; i++) {
        var card = cards[i];
        if (card == null) {
            continue;
        }
        var actions = card['actions'];
        var flipped = card['flipped'];
        if (opponent) {
            addCard(opponentImages, card['top'], card['left']);
        } else {
            var buttonTag = "card-button-" + i;
            var added = false;
            var image = card['image'];
            if (image) {
                //this is causing a bug to not switch actions on cards
                if (flipped) {
                    added = addPlayerCard(negPosCard, buttonTag, card['top'], card['left']);
                } else {
                    added = addPlayerCard(card['image'], buttonTag, card['top'], card['left']);
                }

                if (actions) {
                    var msg = { 'index': i, 'action': 0 };
                    if (actions.length < 2) {
                        addCardValue(actions[0], card['top'], card['left']);
                    } else {
                        var flipTag = "flip-tag-" + i;
                        if (flipped) {
                            msg = { 'index': i, 'action': 1 };
                            addCardValue(actions[1], card['top'], card['left']);
                        } else {
                            addCardValue(actions[0], card['top'], card['left']);
                        }
                        var imgCreated = createImage(flipTag, card['top'], card['left']);
                        if (imgCreated == false) {
                            addButtonAction(flipTag, "PLAYERFLIPPED", msg);
                        }
                    }
                    if (added == false) {
                        addButtonAction(buttonTag, "PLAYERSELECTED", msg);
                    } else {
                        removeButtonAction(buttonTag);
                        addButtonAction(buttonTag, "PLAYERSELECTED", msg);
                    }
                }
            } else {
                addCard(opponentImages, card['top'], card['left']);
            }
        }


    }
}

function placeWinIcons(wins) {
    if (wins == null) {
        return;
    }
    for (var i = 0; i < wins.length; i++) {
        var win = wins[i];
        addwin(winImage, win['top'], win['left']);
    }
}

function updatePlayerTurn(tag, state) {
    var element = document.getElementById(tag);
    if (element) {
        if (state) {
            element.classList.remove("d-none");
        } else {
            element.classList.add('d-none');
        }
    }
}

function playSounds(sounds) {
    for (var i = 0; i < sounds.length; i++) {
        var sound = sounds[i];
        playSound(sound);
    }
}


function updatePlayerData(playerData, opponent) {
    var playerTag = "playerName";
    var scoreTag = "playerScore";
    var turnTag = "playerTurn";
    var turn = playerData['turn'];
    if (opponent) {
        playerTag = "opponentName";
        scoreTag = "opponentScore";
        turnTag = "opponentTurn";
    }

    setPlayerName(playerTag, playerData['name']);
    setScore(playerData['score'], scoreTag);
    placeCards(playerData['drawnCards']);
    placeWinIcons(playerData['wins']);
    placePlayerCards(playerData['hand'], opponent, turn);
    updatePlayerTurn(turnTag, turn);
}

function resetBoard() {
    cleanBoard();
    removewins();
    for (let i = 0; i < 9; i++) {
        var flipTag = "flip-tag-" + i;
        removeButtonAction(flipTag);
        var img = document.getElementById(flipTag);
        if (img != null) {
            img.parentNode.removeChild(img);
        }
    }
}

chatSocket.onmessage = function(e) {
    const data = JSON.parse(e.data);
    const event = data['event'];
    removeMessage();
    if (event == "NEWSET" || event == "NEWGAME") {
        resetBoard();
    }
    if (event == "WARNING") {
        addMessage("red", data['message'], []);
    } else if (event == "UPDATE") {
        cleanBoard();
        const message = data['message'];
        const playerData = message['player'];
        const opponentData = message['opponent'];
        const winner = message['winner'];
        const draw = message['draw'];
        const viewer = message['viewer'];
        const sounds = message['sounds'];
        if (winner == null) {
            playSounds(sounds);
        }

        if (playerData) {
            updatePlayerData(playerData);
        }
        if (opponentData) {
            updatePlayerData(opponentData, true);
        }
        if (winner != null) {
            var over = message['gameover'];
            var forfeit = message['forfeit'];
            var rematch = message['rematch']
            var msg = winner + " has won the set!";
            if (over) {
                if (rematch == null) {
                    msg = winner + " has won the round! Make your bets before the next.";
                } else {
                    msg = rematch + " wants a rematch.";
                }
                if (forfeit) {
                    msg = winner + " has won the round due to forfeit.";
                }
                buttons = [];
                if (viewer == false) {
                    var button2 = createButton("rematch-button", "REMATCH (Cost 50k)");
                    buttons.push(button2);
                    addMessage("white", msg, buttons);
                    addButtonAction("rematch-button", "NEWGAME", null);
                } else {
                    addMessage("white", msg, buttons);
                }
            } else {
                var buttons = [];
                if (viewer == false) {
                    var button = createButton("message-button-tag", "OK");
                    buttons.push(button)
                    addMessage("white", msg, buttons);
                    addButtonAction("message-button-tag", "NEWSET", null);
                } else {
                    addMessage("white", msg, buttons);
                }

            }

        } else if (draw != null) {
            var msg = "Set was a draw!";
            var buttons = [];
            if (viewer == false) {
                var button = createButton("message-button-tag", "OK");
                buttons.push(button);
                addMessage("white", msg, buttons);
                addButtonAction("message-button-tag", "NEWSET", null);
            } else {
                addMessage("white", msg, buttons);
            }
        }
    } else {
        chatSocket.send(JSON.stringify({
            'event': "GETUPDATE",
            'message': null
        }));
    }
};

chatSocket.onclose = function(e) {
    console.error('Chat socket closed unexpectedly');
};

if (document.querySelector('#endTurn') != null) {
    document.querySelector('#endTurn').onclick = function(e) {
        chatSocket.send(JSON.stringify({
            'event': "ENDTURN"
        }));
    };
}

if (document.querySelector('#stand') != null) {
    document.querySelector('#stand').onclick = function(e) {
        chatSocket.send(JSON.stringify({
            'event': "STAND"
        }));
    };
}

if (document.querySelector('#forfeit') != null) {
    document.querySelector('#forfeit').onclick = function(e) {
        chatSocket.send(JSON.stringify({
            'event': "FORFEIT"
        }));
    };
}

if (document.querySelector('#soundIcon') != null) {
    document.querySelector('#soundIcon').onclick = function(e) {
        toggleMute();
    };
}

joined();
