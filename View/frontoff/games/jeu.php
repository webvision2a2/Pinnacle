<!DOCTYPE html>
<html>
<head>
    <title>Advanced Platformer</title>
    <style>
               #gameStats {
            position: absolute;
            top: 10px;
            left: 10px;
            color: white;
            padding: 10px;
            background: rgba(0,0,0,0.5);
            border-radius: 5px;
        }
        
        #backButton {
            position: absolute;
            top: 10px;
            right: 10px;
            padding: 10px 20px;
            background: rgba(0,0,0,0.5);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-family: 'Arial', sans-serif;
            transition: background 0.3s;
        }
        
        #backButton:hover {
            background: rgba(0,0,0,0.7);
        }
        canvas {
            border: 2px solid #333;
            box-shadow: 0 0 10px rgba(0,0,0,0.5);
        }
        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background: linear-gradient(to bottom, #87CEEB, #4682B4);
            font-family: 'Arial', sans-serif;
        }
        #gameStats {
            position: absolute;
            top: 10px;
            left: 10px;
            color: white;
            padding: 10px;
            background: rgba(0,0,0,0.5);
            border-radius: 5px;
        }
    </style>
</head>
<body>

<button id="backButton" onclick="window.location.href='../catalogue.php'">Back to Catalogue</button>    <div id="gameStats">
        Lives: <span id="lives">3</span> | Score: <span id="score">0</span> | Level: <span id="level">1</span>
    </div>
    <canvas id="gameCanvas" width="1000" height="600"></canvas>

    <script>
        const canvas = document.getElementById('gameCanvas');
        const ctx = canvas.getContext('2d');

        // Game state
        const gameState = {
            score: 0,
            lives: 3,
            level: 1,
            gameOver: false,
            paused: false,
            startTime: Date.now(),
            powerUpActive: false,
            powerUpTimer: 0
        };

        // Player object with enhanced properties
        const player = {
            x: 50,
            y: 200,
            width: 40,
            height: 40,
            speed: 5,
            jumpForce: 15,
            gravity: 0.5,
            velocityX: 0,
            velocityY: 0,
            isJumping: false,
            direction: 'right',
            frame: 0,
            frameCount: 8,
            animationSpeed: 5,
            animationCounter: 0,
            color: '#FF0000',
            invincible: false
        };

        // Enemy class
        class Enemy {
            constructor(x, y) {
                this.x = x;
                this.y = y;
                this.width = 30;
                this.height = 30;
                this.speed = 2;
                this.direction = 1;
                this.moveDistance = 0;
                this.maxDistance = 150;
            }

            update() {
                this.x += this.speed * this.direction;
                this.moveDistance += Math.abs(this.speed);
                
                if (this.moveDistance >= this.maxDistance) {
                    this.direction *= -1;
                    this.moveDistance = 0;
                }
            }

            draw() {
                ctx.fillStyle = '#FF4444';
                ctx.fillRect(this.x, this.y, this.width, this.height);
            }
        }

        // Power-up class
        class PowerUp {
            constructor(x, y, type) {
                this.x = x;
                this.y = y;
                this.width = 25;
                this.height = 25;
                this.type = type;
                this.collected = false;
                this.floating = 0;
                this.floatSpeed = 0.05;
            }

            update() {
                this.floating += this.floatSpeed;
                this.y += Math.sin(this.floating) * 0.5;
            }

            draw() {
                if (!this.collected) {
                    ctx.fillStyle = this.type === 'speed' ? '#00FF00' : '#0000FF';
                    ctx.beginPath();
                    ctx.arc(this.x + this.width/2, this.y + this.height/2, 
                           this.width/2, 0, Math.PI * 2);
                    ctx.fill();
                }
            }
        }

        // Game objects
        let platforms = [];
        let coins = [];
        let enemies = [];
        let powerUps = [];

        // Initialize level
        function initLevel() {
            platforms = [
                { x: 0, y: 550, width: 1000, height: 50, type: 'normal' },
                { x: 300, y: 450, width: 200, height: 20, type: 'normal' },
                { x: 100, y: 350, width: 200, height: 20, type: 'moving', 
                  startX: 100, endX: 300, direction: 1, speed: 2 },
                { x: 500, y: 250, width: 200, height: 20, type: 'normal' },
                { x: 700, y: 350, width: 200, height: 20, type: 'breaking' }
            ];

            coins = [];
            for (let i = 0; i < 10; i++) {
                coins.push({
                    x: 100 + i * 80,
                    y: 200 + Math.sin(i) * 100,
                    width: 20,
                    height: 20,
                    collected: false,
                    floating: i
                });
            }

            enemies = [
                new Enemy(400, 420),
                new Enemy(600, 220)
            ];

            powerUps = [
                new PowerUp(300, 200, 'speed'),
                new PowerUp(700, 300, 'jump')
            ];
        }

        // Event handlers
        const keys = {};
        document.addEventListener('keydown', (e) => {
            keys[e.key] = true;
            if (e.key === 'p') gameState.paused = !gameState.paused;
            if (e.key === 'r' && gameState.gameOver) resetGame();
        });

        document.addEventListener('keyup', (e) => {
            keys[e.key] = false;
        });

        function updatePlayer() {
            // Horizontal movement with momentum
            if (keys['ArrowLeft']) {
                player.velocityX = Math.max(player.velocityX - 0.5, -player.speed);
                player.direction = 'left';
            } else if (keys['ArrowRight']) {
                player.velocityX = Math.min(player.velocityX + 0.5, player.speed);
                player.direction = 'right';
            } else {
                player.velocityX *= 0.9; // Friction
            }

            // Apply movement
            player.x += player.velocityX;

            // Jumping
            if (keys['ArrowUp'] && !player.isJumping) {
                player.velocityY = -player.jumpForce;
                player.isJumping = true;
            }

            // Gravity
            player.velocityY += player.gravity;
            player.y += player.velocityY;

            // Animation
            player.animationCounter++;
            if (player.animationCounter >= player.animationSpeed) {
                player.frame = (player.frame + 1) % player.frameCount;
                player.animationCounter = 0;
            }

            // Platform collision
            platforms.forEach((platform, index) => {
                if (checkCollision(player, platform)) {
                    if (player.velocityY > 0) {
                        player.y = platform.y - player.height;
                        player.velocityY = 0;
                        player.isJumping = false;

                        if (platform.type === 'breaking') {
                            setTimeout(() => {
                                platforms.splice(index, 1);
                            }, 500);
                        }
                    }
                }
            });

            // Moving platforms
            platforms.forEach(platform => {
                if (platform.type === 'moving') {
                    platform.x += platform.speed * platform.direction;
                    if (platform.x <= platform.startX || platform.x >= platform.endX) {
                        platform.direction *= -1;
                    }
                }
            });

            // Collect coins
            coins.forEach(coin => {
                if (!coin.collected && checkCollision(player, coin)) {
                    coin.collected = true;
                    gameState.score += 10;
                    updateStats();
                }
            });

            // Enemy collision
            enemies.forEach(enemy => {
                if (!player.invincible && checkCollision(player, enemy)) {
                    handleDamage();
                }
            });

            // Power-up collection
            powerUps.forEach(powerUp => {
                if (!powerUp.collected && checkCollision(player, powerUp)) {
                    activatePowerUp(powerUp);
                }
            });

            // Keep player in bounds
            if (player.x < 0) player.x = 0;
            if (player.x + player.width > canvas.width) player.x = canvas.width - player.width;
            if (player.y < 0) player.y = 0;
            if (player.y + player.height > canvas.height) {
                handleDamage();
            }
        }
        class EducationalBubble {
    constructor(x, y, question, answers, correctAnswer) {
        this.x = x;
        this.y = y;
        this.width = 30;
        this.height = 30;
        this.question = question;
        this.answers = answers;
        this.correctAnswer = correctAnswer;
        this.collected = false;
        this.floating = 0;
        this.floatSpeed = 0.05;
    }

    update() {
        this.floating += this.floatSpeed;
        this.y += Math.sin(this.floating) * 0.5;
    }

    draw() {
        if (!this.collected) {
            ctx.fillStyle = '#9932CC'; // Purple color for educational bubbles
            ctx.beginPath();
            ctx.arc(this.x + this.width/2, this.y + this.height/2, 
                   this.width/2, 0, Math.PI * 2);
            ctx.fill();
            ctx.fillStyle = '#FFFFFF';
            ctx.font = '20px Arial';
            ctx.fillText('?', this.x + this.width/3, this.y + this.height/1.5);
        }
    }
}

        function handleDamage() {
            if (!player.invincible) {
                gameState.lives--;
                updateStats();
                player.invincible = true;
                setTimeout(() => {
                    player.invincible = false;
                }, 2000);

                if (gameState.lives <= 0) {
                    gameState.gameOver = true;
                } else {
                    resetPlayerPosition();
                }
            }
        }

        function activatePowerUp(powerUp) {
            powerUp.collected = true;
            gameState.powerUpActive = true;
            gameState.powerUpTimer = 300;

            if (powerUp.type === 'speed') {
                player.speed *= 1.5;
            } else if (powerUp.type === 'jump') {
                player.jumpForce *= 1.3;
            }

            setTimeout(() => {
                gameState.powerUpActive = false;
                player.speed = 5;
                player.jumpForce = 15;
            }, 5000);
        }

        function resetPlayerPosition() {
            player.x = 50;
            player.y = 200;
            player.velocityX = 0;
            player.velocityY = 0;
        }

        function updateStats() {
            document.getElementById('lives').textContent = gameState.lives;
            document.getElementById('score').textContent = gameState.score;
            document.getElementById('level').textContent = gameState.level;
        }

        function checkCollision(rect1, rect2) {
            return rect1.x < rect2.x + rect2.width &&
                   rect1.x + rect1.width > rect2.x &&
                   rect1.y < rect2.y + rect2.height &&
                   rect1.y + rect1.height > rect2.y;
        }

        function draw() {
            // Clear canvas
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            // Draw background
            ctx.fillStyle = '#87CEEB';
            ctx.fillRect(0, 0, canvas.width, canvas.height);

            // Draw platforms
            platforms.forEach(platform => {
                ctx.fillStyle = platform.type === 'breaking' ? '#FFA500' : 
                               platform.type === 'moving' ? '#8B4513' : '#228B22';
                ctx.fillRect(platform.x, platform.y, platform.width, platform.height);
            });

            // Draw coins with animation
            ctx.fillStyle = '#FFD700';
            coins.forEach(coin => {
                if (!coin.collected) {
                    coin.floating += 0.05;
                    const yOffset = Math.sin(coin.floating) * 5;
                    ctx.beginPath();
                    ctx.arc(coin.x + coin.width/2, coin.y + coin.height/2 + yOffset, 
                           coin.width/2, 0, Math.PI * 2);
                    ctx.fill();
                }
            });

            // Draw enemies
            enemies.forEach(enemy => enemy.draw());

            // Draw power-ups
            powerUps.forEach(powerUp => powerUp.draw());

            // Draw player with invincibility effect
            ctx.fillStyle = player.invincible ? 
                           `rgba(255,0,0,${Math.sin(Date.now()/100)})` : 
                           player.color;
            ctx.fillRect(player.x, player.y, player.width, player.height);

            // Draw game over screen
            if (gameState.gameOver) {
                ctx.fillStyle = 'rgba(0,0,0,0.7)';
                ctx.fillRect(0, 0, canvas.width, canvas.height);
                ctx.fillStyle = 'white';
                ctx.font = '48px Arial';
                ctx.textAlign = 'center';
                ctx.fillText('Game Over!', canvas.width/2, canvas.height/2);
                ctx.font = '24px Arial';
                ctx.fillText('Press R to restart', canvas.width/2, canvas.height/2 + 40);
            }

            // Draw pause screen
            if (gameState.paused) {
                ctx.fillStyle = 'rgba(0,0,0,0.5)';
                ctx.fillRect(0, 0, canvas.width, canvas.height);
                ctx.fillStyle = 'white';
                ctx.font = '48px Arial';
                ctx.textAlign = 'center';
                ctx.fillText('PAUSED', canvas.width/2, canvas.height/2);
            }
        }

        function resetGame() {
            gameState.score = 0;
            gameState.lives = 3;
            gameState.level = 1;
            gameState.gameOver = false;
            resetPlayerPosition();
            initLevel();
            updateStats();
        }

        function gameLoop() {
            if (!gameState.gameOver && !gameState.paused) {
                updatePlayer();
                enemies.forEach(enemy => enemy.update());
                powerUps.forEach(powerUp => powerUp.update());
            }
            draw();
            requestAnimationFrame(gameLoop);
        }

        // Initialize and start the game
        initLevel();
        gameLoop();
    </script>
</body>
</html>
