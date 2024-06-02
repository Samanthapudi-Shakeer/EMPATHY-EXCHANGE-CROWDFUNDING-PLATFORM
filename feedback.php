<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="icon" type="image/x-icon" href="./logo.ico">
    <style>
        body {
            margin: 0;
            background: black;
            font-family: 'Roboto', sans-serif;
        }

        h1 {
            position: relative;
            color: #fff;
            opacity: 0;
            transition: .8s ease-in-out;
        }

        #progress {
            position: absolute;
            background: url(H.png);
            background-position-x: 8%;
            box-sizing: border-box;
            height: 100vh;
            width: 0;
            transition: width 0.2s ease-in-out;
        }

        .center {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /******
  Form
 ******/

        #register {
            background: blueviolet;
            position: relative;
            width: 410px;
            padding: 2px 15px 20px 15px;
            box-shadow: 0 16px 24px 2px rgba(0, 0, 0, 0.14), 0 6px 30px 5px rgba(0, 0, 0, 0.12), 0 8px 10px -5px rgba(0, 0, 0, 0.3);
            transition: transform .1s ease-in-out;
        }

        #register.close {
            width: 0;
            padding: 0;
            overflow: hidden;
            transition: .8s ease-in-out;
            box-shadow: 0 16px 24px 2px rgba(0, 0, 0, 0);
        }

        .next {
            position: absolute;
            right: 20px;
            bottom: 10px;
            font-size: 40px;
            color: whitesmoke;
            float: right;
            cursor: pointer;
        }

        .next:hover {
            color: #333
        }

        .wrong .next {
            color: #ff2d26
        }

        .close .next {
            color: #fff
        }

        #inputContainer {
            position: relative;
            opacity: 0;
            width: 350px;
            margin-top: 25px;
            transition: opacity .3s ease-in-out;
        }

        #inputContainer input {
            width: 100%;
            padding: 0 5px;
            border: none;
            font-size: 20px;
            font-weight: bold;
            outline: 0;
            background: transparent;
            box-shadow: none;
        }

        #inputLabel {
            position: absolute;
            pointer-events: none;
            top: 0;
            left: 0;
            font-size: 20px;
            font-weight: bold;
            padding: 0 5px;
            transition: .2s ease-in-out;
        }

        #inputContainer input:valid+#inputLabel {
            top: -15px;
            font-size: 11px;
            font-weight: normal;
            color: #9e9e9e;
        }

        #inputProgress {
            position: absolute;
            border-bottom: 2px solid #25a3ff;
            padding: 3px 0;
            width: 0;
            transition: width .6s ease-in-out;
        }

        .wrong #inputProgress {
            border-color: #ff2d26;
        }
    </style>
</head>

<body>
    <div id="progress"></div>
    <div class="center">
        <div id="register">

            <i id="progressButton" class="ion-android-arrow-forward next"></i>

            <div id="inputContainer">
                <input id="inputField" required autofocus />
                <label id="inputLabel"></label>
                <div id="inputProgress"></div>
            </div>

        </div>
    </div>
    <br>
    <script>
        var questions = [
            { question: "Feedback on UI" },
            { question: "Feedback on UX" },
            { question: "UI Rating", pattern: /^[0-5]$/ },
            { question: "UX Rating", pattern: /^[0-5]$/ },
            { question: "Overall Rating", pattern: /^[0-5]$/ }
            //fetch ui ux feedback 
        ]

            ; (function () {

                var tTime = 100  // transition transform time from #register in ms
                var wTime = 200  // transition width time from #register in ms
                var eTime = 1000 // transition width time from inputLabel in ms

                // init
                // --------------
                var position = 0

                putQuestion()

                progressButton.addEventListener('click', validate)
                inputField.addEventListener('keyup', function (e) {
                    transform(0, 0) // ie hack to redraw
                    if (e.keyCode == 13) validate()
                })

                // functions
                // --------------

                // load the next question
                function putQuestion() {
                    inputLabel.innerHTML = questions[position].question
                    inputField.value = ''
                    inputField.type = questions[position].type || 'text'
                    inputField.focus()
                    showCurrent()
                }

                // when all the questions have been answered
                function done() {

                    // remove the box if there is no next question
                    register.className = 'close'
                    var progressElement = document.getElementById("progress");
                    if (progressElement) {
                        progressElement.style.background = "black";
                    }
                    // add the h1 at the end with the welcome text
                    var h1 = document.createElement('h1')
                    //'Hello ' + inputValue + '!<br>Helping Hands are better than praying hands.'
                    h1.appendChild(document.createTextNode('Hello  ' + questions[0].value + ' !\nHelping Hands are better than praying hands'))
                    document.body.backgroundColor = "black";
                    document.body.color = "white";
                    document.write("<a href='form.html' text-decoration:none>Get back to Home</a>");
                    setTimeout(function () {
                        register.parentElement.appendChild(h1)
                        setTimeout(function () { h1.style.opacity = 1 }, 50)
                    }, eTime)

                }

                // when submitting the current question
                function validate() {

                    // set the value of the field into the array
                    questions[position].value = inputField.value

                    // check if the pattern matches
                    if (!inputField.value.match(questions[position].pattern || /.+/)) wrong()
                    else ok(function () {

                        // set the progress of the background
                        progress.style.width = ++position * 100 / questions.length + 'vw'

                        // if there is a new question, hide current and load next
                        if (questions[position]) hideCurrent(putQuestion)
                        else hideCurrent(done)

                    })

                }

                // helper
                // --------------

                function hideCurrent(callback) {
                    inputContainer.style.opacity = 0
                    inputProgress.style.transition = 'none'
                    inputProgress.style.width = 0
                    setTimeout(callback, wTime)
                }

                function showCurrent(callback) {
                    inputContainer.style.opacity = 1
                    inputProgress.style.transition = ''
                    inputProgress.style.width = '100%'
                    setTimeout(callback, wTime)
                }

                function transform(x, y) {
                    register.style.transform = 'translate(' + x + 'px ,  ' + y + 'px)'
                }

                function ok(callback) {
                    register.className = ''
                    setTimeout(transform, tTime * 0, 0, 10)
                    setTimeout(transform, tTime * 1, 0, 0)
                    setTimeout(callback, tTime * 2)
                }

                function wrong(callback) {
                    register.className = 'wrong'
                    for (var i = 0; i < 6; i++) // shaking motion
                        setTimeout(transform, tTime * i, (i % 2 * 2 - 1) * 20, 0)
                    setTimeout(transform, tTime * 6, 0, 0)
                    setTimeout(callback, tTime * 7)
                }

            }())
    </script>
</body>

</html>
<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "sampledb";

// creating a connection
$con = mysqli_connect($host, $username, $password, $dbname);

// to ensure that the connection is made
if (!$con) {
    die("Connection failed!" . mysqli_connect_error());
}

?>