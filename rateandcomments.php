<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: 'Verdana';
            background-image: url(bg12.jpg);
            background-size: cover;
        }

        .container {
            font-family: tahoma;
            font-weight: bold;
            max-width: 500px;
            margin: 0 auto;
            border: 1px solid #dee2e6;
            background-color: cyan;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .navbar {
            background-color: skyblue;
        }

        .navbar-brand {
            font-size: 2.8rem;
            font-weight: bold;
            font-family: 'comics';
        }

        .average-rating {
            font-size: 18px;
            margin-bottom: 15px;
            color: blue;
        }

        .comments {
            margin-bottom: 15px;
        }

        .comment {
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 8px;
            margin-bottom: 8px;
        }

        .comment p {
            margin: 0;
        }

        .btn-success {
            background-color: skyblue;
            border-color: blue;
        }

        .btn-success:hover {
            background-color: yellowgreen;
            border-color: blue;
        }

        .text-primary {
            color: #007bff;
        }
        .exit-btn {
            position: absolute;
            top: 30px;
           left: 410px;
            color: #ffffff;
           background-color:blue;
        }
    </style>
    <title>Product Rating and Comments</title>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color:blue">
        <a class="navbar-brand" href="#" style="color: #fff;">Service Ratings</a>
        <div class="float-right">
    </div>

<div class="exit-btn">
            <button type="button" style="color:white;" class="btn btn-outline-danger" data-toggle="modal" data-target="#exitModal">Exit</button>
        </div>
    
        <!-- Exit Modal -->
        <div class="modal fade" id="exitModal" tabindex="-1" role="dialog" aria-labelledby="exitModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exitModalLabel">Confirmation</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to exit?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <a href="home.htm" class="btn btn-danger">Exit</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    </nav>

    <div class="container mt-3" style="background-color: #f5f5f5; border-radius: 10px; padding: 15px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        <h1 class="mb-3" style="color: #343a40;">Valet Parking Services</h1>

        <!-- Display average rating -->
        <div class="average-rating mb-3" style="color: #007bff;">
            Average Rating: <?php echo calculateAverageRating(); ?>
        </div>

        <!-- Display existing comments -->
        <div class="comments">
            <?php displayComments(); ?>
        </div>

        <!-- Rating form -->
        <form action="submit.php" method="post">
            <div class="form-row">
                <div class="col-md-4 mb-2">
                    <label for="rating" style="color: #343a40;">Rate our services:</label>
                    <select class="form-control" name="rating" id="rating" required>
                        <option value="5">5</option>
                        <option value="4">4</option>
                        <option value="3">3</option>
                        <option value="2">2</option>
                        <option value="1">1</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
    <label for="comment" style="color: #343a40;">Leave a comment:</label>
    <textarea class="form-control" name="comment" id="comment" rows="3"></textarea>
</div>

<button type="submit" class="btn btn-success" style="background-color: blue; border-color: #4caf50;">
    <a href="home.htm" style="color: white; text-decoration: none;">Submit</a>
</button>
</form>

    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <?php
    function calculateAverageRating() {
        return 4.5;
    }

    function displayComments() {
        $comments = [
            ['user' => 'User1', 'comment' => 'Best sevice!'],
            ['user' => 'User2', 'comment' => 'Excellent services!'],
            ['user' => 'User3', 'comment' => 'I love it!'],
        ];

        foreach ($comments as $comment) {
            echo '<div class="comment">';
            echo '<p><strong>' . $comment['user'] . ':</strong> ' . $comment['comment'] . '</p>';
            echo '</div>';
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $rating = $_POST['rating'];
        $comment = $_POST['comment'];

        echo '<div class="comment">';
        echo '<p><strong>New Rating:</strong> ' . $rating . ' stars</p>';
        echo '<p><strong>New Comment:</strong> ' . $comment . '</p>';
        echo '</div>';
    }
    ?>
</body>
</html>
