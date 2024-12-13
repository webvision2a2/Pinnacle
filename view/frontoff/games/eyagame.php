<?php
session_start();

// Initialize variables
if (!isset($_SESSION['score'])) {
    $_SESSION['score'] = 0;
}
if (!isset($_SESSION['asked_questions'])) {
    $_SESSION['asked_questions'] = [];
}
$message = ''; // Initialize message variable

// Database of programming questions
function getProgrammingQuestions() {
    return [
        
        [
            'question' => "What does HTML stand for?",
            'options' => [
                "Hyper Text Markup Language",
                "High Tech Modern Language",
                "Hyper Transfer Markup Language",
                "Hybrid Text Making Language"
            ],
            'correct_answer' => 0,
            'explanation' => "HTML (Hyper Text Markup Language) is the standard markup language for creating web pages."
        ],
        [
            'question' => "Which of these is not a programming language?",
            'options' => [
                "Python",
                "Java",
                "Chrome",
                "Ruby"
            ],
            'correct_answer' => 2,
            'explanation' => "Chrome is a web browser, not a programming language."
        ],
        [
            'question' => "What is the purpose of SQL?",
            'options' => [
                "To style web pages",
                "To manage and query databases",
                "To create mobile apps",
                "To design user interfaces"
            ],
            'correct_answer' => 1,
            'explanation' => "SQL (Structured Query Language) is used to manage and query relational databases."
        ],
        [
            'question' => "Which data structure uses LIFO (Last In, First Out)?",
            'options' => [
                "Queue",
                "Stack",
                "Array",
                "Linked List"
            ],
            'correct_answer' => 1,
            'explanation' => "A Stack uses LIFO - the last element added is the first one to be removed."
        ],
        [
            'question' => "Which of these is a version control system?",
            'options' => [
                "Docker",
                "Jenkins",
                "Git",
                "Maven"
            ],
            'correct_answer' => 2,
            'explanation' => "Git is a distributed version control system for tracking changes in source code."
        ],
        [
            'question' => "What is the main purpose of a firewall?",
            'options' => [
                "To speed up internet connection",
                "To protect against unauthorized access",
                "To compress data",
                "To encrypt emails"
            ],
            'correct_answer' => 1,
            'explanation' => "A firewall monitors and controls incoming/outgoing network traffic based on security rules."
        ],
        [
            'question' => "What does API stand for?",
            'options' => [
                "Application Programming Interface",
                "Automated Program Installation",
                "Advanced Programming Integration",
                "Application Process Integration"
            ],
            'correct_answer' => 0,
            'explanation' => "API (Application Programming Interface) allows different software applications to communicate with each other."
        ],
        [
            'question' => "Which symbol is used for single-line comments in most programming languages?",
            'options' => [
                "//",
                "##",
                "--",
                "**"
            ],
            'correct_answer' => 0,
            'explanation' => "// is the most common symbol for single-line comments in many programming languages."
        ],
        [
            'question' => "What does CSS stand for?",
            'options' => [
                "Computer Style System",
                "Cascading Style Sheets",
                "Creative Style Software",
                "Coding Style Syntax"
            ],
            'correct_answer' => 1,
            'explanation' => "CSS (Cascading Style Sheets) is a style sheet language used for describing the presentation of a document."
        ]
    ];
}
// Generate random question
function getRandomQuestion() {
    $questions = getProgrammingQuestions();
    $available_questions = array_diff_key($questions, array_flip($_SESSION['asked_questions']));
    
    // If all questions have been asked, reset the asked questions array
    if (empty($available_questions)) {
        $_SESSION['asked_questions'] = [];
        $available_questions = $questions;
    }
    
    $randomIndex = array_rand($available_questions);
    $_SESSION['asked_questions'][] = $randomIndex;
    
    $question = $questions[$randomIndex];
    $question['id'] = $randomIndex;
    return $question;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_GET['reset'])) {
    if (isset($_POST['answer']) && isset($_POST['correct_answer'])) {
        $questions = getProgrammingQuestions();
        $questionId = isset($_POST['question_id']) ? $_POST['question_id'] : 0;
        $currentQuestion = $questions[$questionId];
        
        if ((int)$_POST['answer'] === (int)$_POST['correct_answer']) {
            $_SESSION['score']++;
            $message = "<div class='correct'>Correct! 🎉 " . $currentQuestion['explanation'] . "</div>";
        } else {
            $message = "<div class='incorrect'>Wrong! 💻 " . $currentQuestion['explanation'] . "</div>";
        }
    }
}

// Generate new question
$problem = getRandomQuestion();

// Handle reset
if (isset($_GET['reset'])) {
    $_SESSION['score'] = 0;
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Programming Quiz</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            text-align: center;
            background-color: #f0f8ff;
        }
        .game-container {
            background-color: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            margin-top: 20px;
        }
        .question {
            font-size: 20px;
            margin: 20px 0;
            color: #2c3e50;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 10px;
        }
        .options {
            display: grid;
            gap: 10px;
            margin: 20px 0;
            padding: 0 20px;
        }
        .option-button {
            font-size: 16px;
            padding: 15px 20px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .option-button:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
        }
        .score {
            font-size: 24px;
            margin: 20px 0;
            color: #2c3e50;
            font-weight: bold;
        }
        .message {
            margin: 15px 0;
            font-size: 18px;
            padding: 10px;
            border-radius: 5px;
        }
        .correct {
            color: #27ae60;
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            padding: 10px;
            border-radius: 5px;
        }
        .incorrect {
            color: #e74c3c;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            padding: 10px;
            border-radius: 5px;
        }
        .reset-button {
            background-color: #e74c3c;
            margin-top: 20px;
        }
        .reset-button:hover {
            background-color: #c0392b;
        }
        h1 {
            color: #2c3e50;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        }
        
        .nav-container {
        width: 100%;
        text-align: center;  /* Changed from left to center */
        margin: 20px 0;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .back-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 12px 24px;
        background-color: #34495e;
        color: white;
        text-decoration: none;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        width: fit-content;  /* Added to ensure proper width */
    }

    .back-button:hover {
        background-color: #2c3e50;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }

    .back-button i {
        margin-right: 10px;
    }
    .fa-arrow-left {
        font-size: 16px;
    }
    </style>
</head>
<body>
    <h1>🖥️ Programming Quiz Game</h1>
    <div class="nav-container">
    <a href="../catalogue.php" class="back-button">
        <i class="fas fa-arrow-left"></i>
        Back to Catalogue
    </a>
</div>

    <div class="game-container">
        <div class="score">Score: <?php echo $_SESSION['score']; ?></div>
        
        <?php if ($message): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="question"><?php echo $problem['question']; ?></div>
            <div class="options">
                <?php foreach ($problem['options'] as $index => $option): ?>
                    <button type="submit" name="answer" value="<?php echo $index; ?>" class="option-button">
                        <?php echo $option; ?>
                    </button>
                <?php endforeach; ?>
            </div>
            <input type="hidden" name="correct_answer" value="<?php echo $problem['correct_answer']; ?>">
            <input type="hidden" name="question_id" value="<?php echo $problem['id']; ?>">
        </form>

        <p>Test your programming knowledge!</p>
        
        <form method="POST" action="?reset=true">
            <button type="submit" class="option-button reset-button">Reset Score</button>
        </form>
    </div>
</body>
</html>
