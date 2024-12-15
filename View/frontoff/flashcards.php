
<?php
// Git commands and their scenarios
$gitScenarios = [
    [
        'level' => 1,
        'scenario' => "You've just started a new project. Initialize a git repository.",
        'command' => 'git init',
        'hints' => ['This command creates a new Git repository', 'It starts with "git i"'],
        'success_message' => "Great! You've initialized a new Git repository.",
        'points' => 10
    ],
    [
        'level' => 2,
        'scenario' => "Add your changes to the staging area.",
        'command' => 'git add .',
        'hints' => ['This command stages all changes', 'Use "." to add all files'],
        'success_message' => "Perfect! All changes are now staged.",
        'points' => 15
    ],
    [
        'level' => 3,
        'scenario' => "Commit your changes with the message 'Initial commit'",
        'command' => 'git commit -m "Initial commit"',
        'hints' => ['Use -m to add a commit message', 'Don\'t forget the quotes'],
        'success_message' => "Excellent! Changes committed successfully.",
        'points' => 20
    ],
    [
        'level' => 4,
        'scenario' => "Check the status of your repository",
        'command' => 'git status',
        'hints' => ['This command shows the working tree status', 'Starts with "git s"'],
        'success_message' => "Good! Now you can see the status of your files.",
        'points' => 15
    ],
    [
        'level' => 5,
        'scenario' => "Create a new branch called 'feature'",
        'command' => 'git checkout -b feature',
        'hints' => ['Use checkout with -b flag', 'This creates and switches to a new branch'],
        'success_message' => "Branch created and switched successfully!",
        'points' => 25
    ],
    [
        'level' => 6,
        'scenario' => "Switch back to the main branch",
        'command' => 'git checkout main',
        'hints' => ['Use checkout without -b', 'The default branch is usually called main'],
        'success_message' => "Successfully switched to main branch!",
        'points' => 20
    ],
    [
        'level' => 7,
        'scenario' => "Merge the 'feature' branch into 'main'",
        'command' => 'git merge feature',
        'hints' => ['You should be on main branch', 'Use the merge command'],
        'success_message' => "Feature branch merged successfully!",
        'points' => 30
    ],
    [
        'level' => 8,
        'scenario' => "View the commit history",
        'command' => 'git log',
        'hints' => ['This command shows commit logs', 'Starts with "git l"'],
        'success_message' => "Now you can see all commits!",
        'points' => 15
    ],
    [
        'level' => 9,
        'scenario' => "Add a remote repository called 'origin'",
        'command' => 'git remote add origin',
        'hints' => ['Use remote add command', 'The default remote name is origin'],
        'success_message' => "Remote repository added!",
        'points' => 25
    ],
    [
        'level' => 10,
        'scenario' => "Push your changes to the remote repository",
        'command' => 'git push origin main',
        'hints' => ['Use push command', 'Specify remote and branch names'],
        'success_message' => "Changes pushed to remote!",
        'points' => 30
    ],
    [
        'level' => 11,
        'scenario' => "Pull latest changes from the remote repository",
        'command' => 'git pull origin main',
        'hints' => ['Similar to push, but pulls instead', 'Gets changes from remote'],
        'success_message' => "Successfully pulled latest changes!",
        'points' => 25
    ],
    [
        'level' => 12,
        'scenario' => "Discard changes in working directory",
        'command' => 'git checkout -- .',
        'hints' => ['Use checkout with --', 'The dot means all files'],
        'success_message' => "Changes discarded successfully!",
        'points' => 35
    ]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Git Command Learning Game</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --primary-color: #2C24CE;
            --secondary-color: #4A43E2;
            --success-color: #28a745;
            --error-color: #dc3545;
            --background-color: #f8f9fa;
            --text-color: #333;
        }
        .back-button {
        position: fixed;
        top: 20px;
        left: 20px;
        z-index: 1000;
    }

    .back-button .btn {
        background-color: var(--secondary-color);
        color: white;
        padding: 10px 20px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }

    .back-button .btn:hover {
        background-color: var(--primary-color);
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }

    .back-button .fas {
        font-size: 14px;
    }
    
        body {
            font-family: 'Arial', sans-serif;
            background-color: var(--background-color);
            margin: 0;
            padding: 20px;
            color: var(--text-color);
        }

        .game-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }

        .terminal {
            background: #1e1e1e;
            color: #fff;
            padding: 20px;
            border-radius: 10px;
            font-family: monospace;
            margin: 20px 0;
            position: relative;
        }

        .terminal-header {
            display: flex;
            gap: 5px;
            margin-bottom: 10px;
        }

        .terminal-button {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #ff5f56;
        }

        .terminal-button:nth-child(2) {
            background: #ffbd2e;
        }

        .terminal-button:nth-child(3) {
            background: #27c93f;
        }

        .prompt {
            color: #27c93f;
        }

        .command-input {
            width: 100%;
            background: transparent;
            border: none;
            color: white;
            font-family: monospace;
            font-size: 16px;
            outline: none;
            margin-top: 10px;
        }

        .scenario {
            background: var(--primary-color);
            color: white;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .controls {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn-submit {
            background: var(--primary-color);
            color: white;
        }

        .btn-hint {
            background: var(--secondary-color);
            color: white;
        }

        .feedback {
            margin-top: 20px;
            padding: 15px;
            border-radius: 5px;
            display: none;
        }

        .feedback.success {
            background: var(--success-color);
            color: white;
        }

        .feedback.error {
            background: var(--error-color);
            color: white;
        }

        .score-board {
            text-align: right;
            font-size: 1.2em;
            margin-bottom: 20px;
        }

        .progress-bar {
            height: 10px;
            background: #ddd;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .progress {
            height: 100%;
            background: var(--primary-color);
            border-radius: 5px;
            width: 0%;
            transition: width 0.3s ease;
        }

        .level-indicator {
            text-align: center;
            font-size: 1.2em;
            margin-bottom: 20px;
            color: var(--primary-color);
        }
    </style>
</head>
<body>
    <div class="game-container">
        <h1>Git Command Learning Game</h1>
        
        <div class="score-board">
            Score: <span id="score">0</span>
        </div>

        <div class="level-indicator">
            Level <span id="current-level">1</span>
        </div>
        <div class="back-button">
        <a href="catalogue.php" class="btn">
            <i class="fas fa-arrow-left"></i> Back to Catalogue
        </a>
    </div>
        <div class="progress-bar">
            <div class="progress" id="progress"></div>
        </div>

        <div class="scenario" id="scenario">
            <!-- Scenario text will be inserted here -->
        </div>

        <div class="terminal">
            <div class="terminal-header">
                <div class="terminal-button"></div>
                <div class="terminal-button"></div>
                <div class="terminal-button"></div>
            </div>
            <span class="prompt">$</span>
            <input type="text" class="command-input" id="command-input" placeholder="Type your git command here...">
        </div>

        <div class="controls">
            <button class="btn btn-submit" onclick="checkCommand()">
                <i class="fas fa-terminal"></i> Submit
            </button>
            <button class="btn btn-hint" onclick="showHint()">
                <i class="fas fa-lightbulb"></i> Hint
            </button>
        </div>

        <div class="feedback" id="feedback"></div>
    </div>

    <script>
        const gitScenarios = <?php echo json_encode($gitScenarios); ?>;
        let currentLevel = 0;
        let score = 0;
        let hintsUsed = 0;

        function initializeGame() {
            updateScenario();
            updateProgress();
        }

        function updateScenario() {
    if (currentLevel >= gitScenarios.length) {
        const finalScore = score;
        Swal.fire({
            title: 'Congratulations!',
            html: `
                <p>You've completed all levels!</p>
                <p>Final Score: ${finalScore}</p>
            `,
            icon: 'success',
            confirmButtonText: 'Play Again',
            showCancelButton: true,
            cancelButtonText: 'Back to Catalogue'
        }).then((result) => {
            if (result.isConfirmed) {
                // Reset game
                currentLevel = 0;
                score = 0;
                hintsUsed = 0;
                document.getElementById('score').textContent = '0';
                updateScenario();
                updateProgress();
            } else {
                // Go back to catalogue
                window.location.href = '../catalogue.php';
            }
        });
        return;
    }

    const scenario = gitScenarios[currentLevel];
    document.getElementById('scenario').textContent = scenario.scenario;
    document.getElementById('current-level').textContent = scenario.level;
    document.getElementById('command-input').value = '';
}

        function updateProgress() {
            const progress = ((currentLevel) / gitScenarios.length) * 100;
            document.getElementById('progress').style.width = `${progress}%`;
        }

        function showFeedback(message, isSuccess) {
            const feedback = document.getElementById('feedback');
            feedback.textContent = message;
            feedback.className = `feedback ${isSuccess ? 'success' : 'error'}`;
            feedback.style.display = 'block';

            setTimeout(() => {
                feedback.style.display = 'none';
            }, 3000);
        }

        function checkCommand() {
            const userCommand = document.getElementById('command-input').value.trim();
            const currentScenario = gitScenarios[currentLevel];

            if (userCommand.toLowerCase() === currentScenario.command.toLowerCase()) {
                score += currentScenario.points - (hintsUsed * 2);
                document.getElementById('score').textContent = score;
                showFeedback(currentScenario.success_message, true);
                currentLevel++;
                hintsUsed = 0;
                updateScenario();
                updateProgress();
            } else {
                showFeedback('Try again! That\'s not the correct command.', false);
            }
        }

        function showHint() {
            const currentScenario = gitScenarios[currentLevel];
            if (hintsUsed < currentScenario.hints.length) {
                showFeedback(currentScenario.hints[hintsUsed], true);
                hintsUsed++;
            } else {
                showFeedback('No more hints available!', false);
            }
        }

        // Handle Enter key press
        document.getElementById('command-input').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                checkCommand();
            }
        });

        // Initialize the game when the page loads
        window.onload = initializeGame;
    </script>
</body>
</html>