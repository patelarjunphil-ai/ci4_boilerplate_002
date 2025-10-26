<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Notifications</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
        }
        .alert {
            padding: 15px;
            margin: 10px 0;
            border-radius: 5px;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .form-group {
            margin: 15px 0;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            background: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Test Notifications</h1>
    
    <!-- SUCCESS/ERROR MESSAGES -->
    <?php if (session('success')): ?>
        <div class="alert alert-success">
            <?= session('success') ?>
        </div>
    <?php endif; ?>
    
    <?php if (session('error')): ?>
        <div class="alert alert-error">
            <?= session('error') ?>
        </div>
    <?php endif; ?>
    
    <h2>Test Registration</h2>
    <form method="post" action="/register">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" value="testuser_<?= time() ?>" required>
        </div>
        
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="testuser_<?= time() ?>@example.com" required>
        </div>
        
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" value="password123" required>
        </div>
        
        <div class="form-group">
            <label for="password_confirm">Confirm Password:</label>
            <input type="password" name="password_confirm" id="password_confirm" value="password123" required>
        </div>
        
        <button type="submit">Test Registration</button>
    </form>
    
    <h2>Test Email</h2>
    <form method="post" action="/test-email">
        <div class="form-group">
            <label for="test_email">Test Email Address:</label>
            <input type="email" name="test_email" id="test_email" value="test@example.com" required>
        </div>
        
        <button type="submit">Send Test Email</button>
    </form>
</body>
</html>
