<!DOCTYPE html>
<html>
<head>
    <title>Code Bird - Learn Programming</title>
    
    <style>
        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            background: linear-gradient(45deg, #0f2027, #203a43, #2c5364);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: white;
        }

        .game-container {
            position: relative;
            margin: 20px;
            box-shadow: 0 0 30px rgba(0,0,0,0.3);
            border-radius: 15px;
            overflow: hidden;
        }

        canvas {
            display: block;
            border-radius: 15px;
            background: linear-gradient(180deg, #00c6fb 0%, #005bea 100%);
        }

        #score {
            position: absolute;
            top: 20px;
            right: 20px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(5px);
            padding: 10px 20px;
            border-radius: 15px;
            font-size: 1.2em;
            font-weight: bold;
        }

        .game-title {
            font-size: 2.5em;
            font-weight: bold;
            margin: 20px;
            background: linear-gradient(45deg, #00c6fb, #005bea);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        <!-- Ajout dans la section style du head -->
<style>
    /* ... styles existants ... */

    .navigation {
        position: absolute;
        top: 20px;
        left: 20px;
        z-index: 100;
    }

    .back-button {
        display: inline-block;
        padding: 10px 20px;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(5px);
        border-radius: 10px;
        color: white;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .back-button:hover {
        background: rgba(255, 255, 255, 0.2);
        transform: translateY(-2px);
    }
</style>
</head>
<body>
    <h1 class="game-title">Code Bird</h1>
    <!-- Ajout en haut du body, après l'ouverture de la balise -->
<body>
    <div class="navigation">
        <a href="../catalogue.php" class="back-button">← Retour au catalogue</a>
    </div>
   
</body>


    <div class="game-container">
        <canvas id="gameCanvas" width="800" height="400"></canvas>
        <div id="score">Score: 0</div>
    </div>

    <script>
        const canvas = document.getElementById('gameCanvas');
        const ctx = canvas.getContext('2d');
        const scoreElement = document.getElementById('score');

        // Programming concepts to catch
        const programmingConcepts = [
            { text: "Variables", color: "#FF6B6B" },
            { text: "Functions", color: "#4ECDC4" },
            { text: "Arrays", color: "#45B7D1" },
            { text: "Objects", color: "#96CEB4" },
            { text: "Loops", color: "#FFEEAD" },
            { text: "API", color: "#D4A5A5" },
            { text: "DOM", color: "#9ED2C6" },
            { text: "JSON", color: "#FFB6B9" },
            { text: "REST", color: "#957DAD" },
            { text: "HTML", color: "#E84A5F" }
        ];

        // Game variables
        let score = 0;
        let gameOver = false;
        let concepts = [];
        let obstacles = [];

        // Bird
        const bird = {
            x: 100,
            y: canvas.height/2,
            width: 40,
            height: 30,
            velocity: 0,
            gravity: 0.4,
            jump: -8
        };

        function createConcept() {
            const concept = programmingConcepts[Math.floor(Math.random() * programmingConcepts.length)];
            return {
                x: canvas.width,
                y: Math.random() * (canvas.height - 50) + 25,
                text: concept.text,
                color: concept.color,
                width: 80,
                height: 30,
                collected: false
            };
        }

        function createObstacle() {
            const height = Math.random() * (canvas.height/2) + 50;
            return {
                x: canvas.width,
                y: Math.random() * (canvas.height - height),
                width: 30,
                height: height
            };
        }

        function drawBird() {
            ctx.save();
            ctx.translate(bird.x + bird.width/2, bird.y + bird.height/2);
            ctx.rotate(bird.velocity * 0.05);

            // Body
            ctx.fillStyle = '#FFD700';
            ctx.beginPath();
            ctx.ellipse(0, 0, bird.width/2, bird.height/2, 0, 0, Math.PI * 2);
            ctx.fill();
            ctx.stroke();

            // Wing
            ctx.fillStyle = '#FFA500';
            ctx.beginPath();
            ctx.ellipse(-5, 0, bird.width/4, bird.height/3, 
                       Math.sin(Date.now() * 0.01) * 0.5, 0, Math.PI * 2);
            ctx.fill();
            ctx.stroke();

            // Eye
            ctx.fillStyle = '#000';
            ctx.beginPath();
            ctx.arc(bird.width/4, -bird.height/6, 3, 0, Math.PI * 2);
            ctx.fill();

            // Beak
            ctx.fillStyle = '#FF6B6B';
            ctx.beginPath();
            ctx.moveTo(bird.width/2, 0);
            ctx.lineTo(bird.width/2 + 10, -5);
            ctx.lineTo(bird.width/2 + 10, 5);
            ctx.closePath();
            ctx.fill();

            ctx.restore();
        }

        function drawConcepts() {
            concepts.forEach(concept => {
                if (!concept.collected) {
                    ctx.save();
                    // Glow effect
                    ctx.shadowColor = concept.color;
                    ctx.shadowBlur = 10;
                    
                    // Background
                    ctx.fillStyle = concept.color + '40'; // 40 = 25% opacity
                    ctx.fillRect(concept.x, concept.y, concept.width, concept.height);
                    
                    // Text
                    ctx.fillStyle = '#FFF';
                    ctx.font = 'bold 16px "Segoe UI"';
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'middle';
                    ctx.fillText(concept.text, 
                               concept.x + concept.width/2, 
                               concept.y + concept.height/2);
                    ctx.restore();
                }
            });
        }

        function drawObstacles() {
            ctx.fillStyle = '#2ecc71';
            obstacles.forEach(obstacle => {
                ctx.fillRect(obstacle.x, obstacle.y, obstacle.width, obstacle.height);
            });
        }

        function update() {
            if (gameOver) return;

            // Bird physics
            bird.velocity += bird.gravity;
            bird.y += bird.velocity;

            // Create new concepts
            if (Math.random() < 0.02) {
                concepts.push(createConcept());
            }

            // Create new obstacles
            if (Math.random() < 0.01) {
                obstacles.push(createObstacle());
            }

            // Update concepts
            concepts.forEach((concept, index) => {
                concept.x -= 3;
                
                // Check collision with bird
                if (!concept.collected && 
                    bird.x < concept.x + concept.width &&
                    bird.x + bird.width > concept.x &&
                    bird.y < concept.y + concept.height &&
                    bird.y + bird.height > concept.y) {
                    concept.collected = true;
                    score += 10;
                    scoreElement.textContent = `Score: ${score}`;
                }

                // Remove off-screen concepts
                if (concept.x + concept.width < 0) {
                    concepts.splice(index, 1);
                }
            });

            // Update obstacles
            obstacles.forEach((obstacle, index) => {
                obstacle.x -= 3;

                // Check collision with bird
                if (bird.x < obstacle.x + obstacle.width &&
                    bird.x + bird.width > obstacle.x &&
                    bird.y < obstacle.y + obstacle.height &&
                    bird.y + bird.height > obstacle.y) {
                    gameOver = true;
                }

                // Remove off-screen obstacles
                if (obstacle.x + obstacle.width < 0) {
                    obstacles.splice(index, 1);
                }
            });

            // Check boundaries
            if (bird.y + bird.height > canvas.height || bird.y < 0) {
                gameOver = true;
            }
        }

        function draw() {
            // Clear canvas
            ctx.fillStyle = '#87CEEB';
            ctx.fillRect(0, 0, canvas.width, canvas.height);

            drawObstacles();
            drawConcepts();
            drawBird();

            if (gameOver) {
                ctx.fillStyle = 'rgba(0, 0, 0, 0.5)';
                ctx.fillRect(0, 0, canvas.width, canvas.height);
                ctx.fillStyle = '#FFF';
                ctx.font = '48px "Segoe UI"';
                ctx.textAlign = 'center';
                ctx.fillText('Game Over!', canvas.width/2, canvas.height/2);
                ctx.font = '24px "Segoe UI"';
                ctx.fillText('Press Space to Restart', canvas.width/2, canvas.height/2 + 40);
            }
        }

        function gameLoop() {
            update();
            draw();
            requestAnimationFrame(gameLoop);
        }

        function resetGame() {
            bird.y = canvas.height/2;
            bird.velocity = 0;
            concepts = [];
            obstacles = [];
            score = 0;
            gameOver = false;
            scoreElement.textContent = `Score: ${score}`;
        }

        // Controls
        document.addEventListener('keydown', (e) => {
            if (e.code === 'Space') {
                e.preventDefault();
                if (gameOver) {
                    resetGame();
                } else {
                    bird.velocity = bird.jump;
                }
            }
        });

        canvas.addEventListener('click', () => {
            if (gameOver) {
                resetGame();
            } else {
                bird.velocity = bird.jump;
            }
        });

        // Start game
        resetGame();
        gameLoop();
    </script>
</body>
</html>