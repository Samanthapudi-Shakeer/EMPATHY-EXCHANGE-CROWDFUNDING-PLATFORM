<?php

session_start();
$username = $_SESSION['username'];
?>
<head>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Trade+Winds&display=swap');

:root {
  --start-letter-anim-time: 1s;
  --full-title-anim-wait-time: calc(var(--start-letter-anim-time) + 1s);
  --final-anim-time: 2s;
}
div {
  background: black;
  margin: 0;
  padding: 0;
  color: white;
  font-family: 'Trade Winds', sans-serif;
  font-size: 5vmin;
  line-height: 1;
  
  display: grid;
  place-items: center;
  place-content: center;
}

h1 {
  position: relative;
  font-size: 5vmin;
  line-height: 1;
}

.the-e {
  animation: the-e-start-left var(--start-letter-anim-time) linear, the-e-for-title var(--final-anim-time) var(--full-title-anim-wait-time) linear forwards;
}

.three {
    color: blueviolet;
  animation: three-start-right var(--start-letter-anim-time) linear, the-three-final var(--final-anim-time) var(--full-title-anim-wait-time) linear forwards;
}

.the-e, .three {
  font-size: 50vmin;
  display: inline-block;
}

.rest-title {
  font-size: 14vmin;
  z-index: 1;
  color: blueviolet;
  position: absolute;
  top: 34%;
  left: 47%;
  
  display: flex;
  flex-direction: column;
  
  clip-path: polygon(0 0, 0 0, 0 100%, 0 100%);
  animation: the-qua-reveal var(--final-anim-time) var(--full-title-anim-wait-time) linear forwards;
}

.prefix {
  scale: 0.5;
  translate: -18% 35%;
}

@keyframes the-e-start-left {
  from {
    translate: 10% 0;
  }
  
  to {
    translate: 0 0;
    color: blueviolet;
  }
}

@keyframes three-start-right {
  from {
    translate: -10% 0;
  }
  
  to {
    translate: 0 0;
    color: blueviolet;
  }
}

@keyframes the-e-for-title {
  from {
    translate: 0 0;
    scale: 1;

  }
  
  to {
    /*translate: -22vmin 0;
    scale: 0.3;*/
    color: black;
  }
}

@keyframes the-three-final {
  from {
    color: white;
    translate: 0 0;
  }
  
  to {
    color: black;
    translate: -50% 0;
  }
}


@keyframes the-qua-reveal {
  from {
    clip-path: polygon(0 0, 0 0, 0 100%, 0 100%);
    translate: -60% -50%;
    opacity: 0;
  }
  
  to {
    clip-path: polygon(0 0, 100% 0, 100% 100%, 0 100%);
    translate: -50% -50%;
    opacity: 1;
  }
}

html
{
    background-color: black;
}
    </style>
</head>
<body>
<div style="margin-top: 0px; margin-left: 50px;">
    <h1 class="b1">
    <span class='the-e'>E</span><span class='three'>E</span>
    <span class="rest-title">
      <span class="prefix" style="color: white;">Empathy</span>
      <span class="rest">Exchange</span>
    </span>
    <h4>Helping hands are better than Praying lips</h4>
  </h1>
  <h6>Initiative by Shakeer</h6>
  
</div>
    <script>
        // Function to redirect after 10 seconds
        function redirect() {
            setTimeout(function() {
                window.location.href = 'main.html'; // Replace 'your-next-page.html' with the URL of the page you want to redirect to
            }, 10000); // 10kms = 1s
        }
    
        // Call the redirect function when the page loads
        window.onload = redirect;
    </script>
</body>

