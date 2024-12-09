<?php
// picture_guessing_game.php

// Define words and their corresponding images
$pictureWords = [
    [
        'word' => 'Cat',
        'image' => 'https://via.placeholder.com/150?text=Cat',
    ],
    [
        'word' => 'Dog',
        'image' => 'https://via.placeholder.com/150?text=Dog',
    ],
    [
        'word' => 'Elephant',
        'image' => 'https://via.placeholder.com/150?text=Elephant',
    ],
];

shuffle($pictureWords); // Shuffle the images to randomize their positions
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Picture Guessing Game</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            text-align: center;
        }
        
        .score-board, .timer {
            font-size: 1.5em;
            margin-bottom: 20px;
            color: #007bff;
        }

        #game-board {
            display: flex; /* Use flexbox to arrange images horizontally */
            flex-wrap: wrap; /* Allow wrapping to the next line if necessary */
            gap: 10px; /* Space between images */
            justify-content: center; /* Center align items */
            margin-top: 20px; /* Space above the cards */
        }

        .image-card {
            width: 150px; /* Fixed width for cards */
            height: 150px; /* Fixed height for cards */
            border-radius: 10px; /* Rounded corners */
            overflow: hidden; /* Hide overflow */
            cursor: pointer;
            transition: transform 0.2s; /* Smooth transition for hover effect */
        }

        .image-card:hover {
            transform: scale(1.05); /* Scale up on hover */
        }

        img {
            width: 100%;
            height: auto;
        }

        .feedback {
            margin-top: 20px;
            font-weight: bold;
        }

        .correct {
            color: green;
        }

        .incorrect {
            color: red;
        }

        .restart-button {
            margin-top: 20px;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .restart-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<h1>Picture Guessing Game</h1>
<div id="score">Score: <span id="score-value">0</span></div>
<div id="timer">Time Left: <span id="time">30</span> seconds</div>

<div id="game-board">
    <!-- Image cards will be generated here -->
</div>

<button class="restart-button" onclick="restartGame()">Restart Game</button>

<audio id="correct-sound" src="sounds/correct.mp3" preload="auto"></audio>
<audio id="incorrect-sound" src="sounds/incorrect.mp3" preload="auto"></audio>

<script>
const pictureWords = <?php echo json_encode($pictureWords); ?>;

let score = 0;
let timeLeft = 30;

function startGame() {
    score = 0; // Reset score
    timeLeft = 30; // Reset timer
    document.getElementById('score-value').textContent = score; // Update score display
    document.getElementById('time').textContent = timeLeft; // Update timer display
    generateImageCards(); // Generate image cards
    startTimer(); // Start the timer
}

function startTimer() {
    const timer = setInterval(() => {
        timeLeft--;
        document.getElementById('time').textContent = timeLeft;

        if (timeLeft <= 0) {
           clearInterval(timer);
           alert("Time's up! Your score is: " + score);
           restartGame();
       }
   }, 1000);
}

function generateImageCards() {
    const gameBoard = document.getElementById('game-board');
    gameBoard.innerHTML = ''; // Clear previous cards

    pictureWords.forEach((item) => {
       const imageCard = document.createElement('div');
       imageCard.className = 'image-card';
       imageCard.onclick = () => guessWord(item.word); // Add click event to guess word

       const img = document.createElement('img');
       img.src = item.image;

       imageCard.appendChild(img);
       gameBoard.appendChild(imageCard);
   });
}

function guessWord(correctWord) {
   const userGuess = prompt("What is this?"); // Prompt user for their guess

   if (userGuess && userGuess.trim().toLowerCase() === correctWord.toLowerCase()) {
       alert("Good job!");
       document.getElementById('correct-sound').play(); // Play correct sound
       score++;
       document.getElementById('score-value').textContent = score; // Update score display
   } else {
       alert("Try again! The correct answer was " + correctWord + ".");
       document.getElementById('incorrect-sound').play(); // Play incorrect sound
   }
}

function restartGame() {
   score = 0; // Reset score to zero
   timeLeft = 30; // Reset timer to thirty seconds

   document.getElementById('score-value').textContent = score; // Update score display
   document.getElementById('time').textContent = timeLeft; // Update timer display

   startGame(); // Start a new game
}

// Start the game when the page loads
window.onload = startGame;

</script>

</body>
</html>