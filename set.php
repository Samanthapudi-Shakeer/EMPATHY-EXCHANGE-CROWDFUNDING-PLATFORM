<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Error Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"> <!-- For icons -->
    <style>
        /* Basic styling for the error page */
        body {
            background-color: #f5f5f5;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            text-align: center;
        }
        .error-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.1);
        }
        .error-icon {
            font-size: 50px;
            color: #ff0000; /* Red to indicate an error */
            margin-bottom: 20px;
        }
        .error-image {
            max-width: 100px; /* Resize the image to fit */
            margin-bottom: 20px;
        }
        .error-message {
            font-size: 24px;
            color: #333;
        }
        .error-description {
            font-size: 16px;
            color: #666;
            margin-top: 10px;
        }
        .error-suggestion {
            font-size: 16px;
            color: #555;
            margin-top: 20px;
        }
        .error-suggestion a {
            color: #007BFF;
            text-decoration: none;
        }
        .error-suggestion a:hover {
            text-decoration: underline;
        }
        a:hover{
            color: red;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-icon">
            <i class="fas fa-exclamation-triangle"></i> <!-- Warning or error icon -->
        </div>
        <h1>: (</h1>
        <div class="error-message">Oops! Something Went Wrong</div>
        <div class="error-description">
            It looks like we hit a snag. Don't worry; let's figure it out together.
        </div>
        <div class="error-suggestion">
            Here are a few things you can try:
            <ul>
                <li>Check if the information you entered is correct.</li>
                <li>Ensure any uploaded files meet the format and size requirements.</li>
                <li>Go back to the <a href="dlsite.php" style="font-weight:bold;text-decoration:none">HOME</a> and try again.</li>
                <li>Contact support if the problem persists.</li>
            </ul>
        </div>
    </div>
</body>
</html>
