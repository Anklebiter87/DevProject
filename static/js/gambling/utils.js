
function CopyGameLink() {
	    var copyText = document.getElementById('GameButton').value;
	    let textArea = document.createElement("textarea");
	    textArea.value = copyText;
	    textArea.style.position = "fixed";
	    textArea.style.left = "-999999px";
	    textArea.style.top = "-999999px";
	    document.body.appendChild(textArea);
	    textArea.focus();
	    textArea.select();
	    alert("A link has been copied to your clipboard. Share it with the person you wish to join your game");
	    return new Promise((res, rej) => {
		            document.execCommand('copy') ? res() : rej();
		            textArea.remove();
		        });
}

