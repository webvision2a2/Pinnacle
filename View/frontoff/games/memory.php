<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Security Guardian - Memory Game</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            color: #fff;
            margin: 0;
            padding: 20px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .game-container {
            max-width: 800px;
            margin: 20px auto;
            text-align: center;
        }

        .memory-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            margin: 20px 0;
        }

        .card {
            aspect-ratio: 1;
            background: #2a2a4a;
            border-radius: 8px;
            cursor: pointer;
            transition: transform 0.3s ease;
            position: relative;
            transform-style: preserve-3d;
        }

        .card:hover {
            transform: scale(1.05);
        }

        .card.flipped {
            transform: rotateY(180deg);
        }

        .card-front, .card-back {
            position: absolute;
            width: 100%;
            height: 100%;
            backface-visibility: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2em;
            border-radius: 8px;
        }

        .card-front {
            background: #2a2a4a;
            border: 2px solid #4a4a6a;
        }

        .card-back {
            background: #3a3a5a;
            transform: rotateY(180deg);
            border: 2px solid #5a5a7a;
            padding: 10px;
            font-size: 0.9em;
            text-align: center;
            word-wrap: break-word;
        }

        .stats {
            display: flex;
            justify-content: space-around;
            margin: 20px 0;
            padding: 15px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
        }

        .stat-item {
            text-align: center;
        }

        .controls {
            margin: 20px 0;
        }

        button {
            background: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            margin: 0 10px;
            transition: background 0.3s ease;
        }

        button:hover {
            background: #45a049;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background: #2a2a4a;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="game-container">
        <h1>Security Guardian - Memory Game</h1>
       
        <div class="stats">
            <div class="stat-item">
                <h3>Temps</h3>
                <p id="timer">0:00</p>
            </div>
            <div class="stat-item">
                <h3>Coups</h3>
                <p id="moves">0</p>
            </div>
            <div class="stat-item">
                <h3>Score</h3>
                <p id="score">0</p>
            </div>
            <div class="controls">
           
            <button onclick="window.location.href='../catalogue.php'">Retour au Catalogue</button>
        </div>

        </div>
        <div class="memory-grid" id="grid"></div>
        <div class="controls">
            <button onclick="resetGame()">Nouvelle Partie</button>
            <button onclick="showRules()">Règles</button>
        </div>
    </div>

    <div class="modal" id="winModal">
        <div class="modal-content">
            <h2>Félicitations !</h2>
            <p>Vous avez terminé le jeu en <span id="finalTime"></span> avec <span id="finalMoves"></span> coups !</p>
            <p>Score final : <span id="finalScore"></span></p>
            <button onclick="resetGame()">Rejouer</button>
        </div>
    </div>

    <script>
       const cyberSecurityTerms = [
            { term: 'Phishing', def: 'Technique frauduleuse pour voler des données personnelles' },
            { term: 'Malware', def: 'Logiciel malveillant conçu pour nuire à un système' },
            { term: 'Firewall', def: 'Barrière de sécurité filtrant le trafic réseau' },
            { term: 'VPN', def: 'Réseau privé virtuel pour une connexion sécurisée' },
            { term: 'Ransomware', def: 'Logiciel qui prend vos données en otage' },
            { term: 'Antivirus', def: 'Logiciel qui protège contre les virus informatiques' },
            { term: 'Cryptage', def: 'Processus de protection des données sensibles' },
            { term: 'Hacker', def: 'Personne qui exploite les failles de sécurité' }
        ];
        
       
        let cards = [];
        let flippedCards = [];
        let matchedPairs = 0;
        let moves = 0;
        let score = 0;
        let timer = 0;
        let timerInterval;
        let canFlip = true;

        function createBoard() {
            const grid = document.getElementById('grid');
            // Créer des paires de cartes (terme + définition)
            const gameCards = [];
            cyberSecurityTerms.forEach(item => {
                gameCards.push({ content: item.term, type: 'term', match: item.term });
                gameCards.push({ content: item.def, type: 'def', match: item.term });
            });
            cards = shuffle(gameCards);

            grid.innerHTML = '';
            cards.forEach((card, index) => {
                const cardElement = document.createElement('div');
                cardElement.className = 'card';
                cardElement.innerHTML = `
                    <div class="card-front">?</div>
                    <div class="card-back">${card.content}</div>
                `;
                cardElement.dataset.index = index;
                cardElement.dataset.match = card.match;
                cardElement.addEventListener('click', () => flipCard(cardElement));
                grid.appendChild(cardElement);
            });
        }

        function shuffle(array) {
            let currentIndex = array.length;
            let temporaryValue, randomIndex;

            while (currentIndex !== 0) {
                randomIndex = Math.floor(Math.random() * currentIndex);
                currentIndex -= 1;
                temporaryValue = array[currentIndex];
                array[currentIndex] = array[randomIndex];
                array[randomIndex] = temporaryValue;
            }

            return array;
        }

        function flipCard(card) {
            if (!canFlip || flippedCards.includes(card) || card.classList.contains('matched')) {
                return;
            }

            card.classList.add('flipped');
            flippedCards.push(card);

            if (flippedCards.length === 2) {
                moves++;
                document.getElementById('moves').textContent = moves;
                canFlip = false;
                checkMatch();
            }
        }

        function checkMatch() {
            const [card1, card2] = flippedCards;
            const match = card1.dataset.match === card2.dataset.match;

            if (match) {
                card1.classList.add('matched');
                card2.classList.add('matched');
                matchedPairs++;
                score += 100;
                document.getElementById('score').textContent = score;

                if (matchedPairs === cyberSecurityTerms.length) {
                    endGame();
                }
            } else {
                setTimeout(() => {
                    card1.classList.remove('flipped');
                    card2.classList.remove('flipped');
                }, 1000);
                score = Math.max(0, score - 10);
                document.getElementById('score').textContent = score;
            }

            setTimeout(() => {
                flippedCards = [];
                canFlip = true;
            }, 1000);
        }


        function updateTimer() {
            const minutes = Math.floor(timer / 60);
            const seconds = timer % 60;
            document.getElementById('timer').textContent = 
                `${minutes}:${seconds.toString().padStart(2, '0')}`;
            timer++;
        }

        function endGame() {
            clearInterval(timerInterval);
            const modal = document.getElementById('winModal');
            document.getElementById('finalTime').textContent = document.getElementById('timer').textContent;
            document.getElementById('finalMoves').textContent = moves;
            document.getElementById('finalScore').textContent = score;
            modal.style.display = 'flex';
        }

        function resetGame() {
            clearInterval(timerInterval);
            timer = 0;
            moves = 0;
            score = 0;
            matchedPairs = 0;
            flippedCards = [];
            document.getElementById('timer').textContent = '0:00';
            document.getElementById('moves').textContent = '0';
            document.getElementById('score').textContent = '0';
            document.getElementById('winModal').style.display = 'none';
            createBoard();
            timerInterval = setInterval(updateTimer, 1000);
         
        }

       
        function showRules() {
            alert(`Règles du jeu Memory Security Guardian :
            
1. Retournez deux cartes à la fois pour associer un terme avec sa définition
2. Chaque paire correcte rapporte 100 points
3. Chaque erreur fait perdre 10 points
4. Le but est de trouver toutes les paires le plus rapidement possible
5. Apprenez les termes de cybersécurité en jouant !`);
        }


        // Initialisation du jeu
        resetGame();
    </script>
</body>
</html>
