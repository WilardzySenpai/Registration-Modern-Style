<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Error</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link href="styles.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <div class="particles">
        <!-- JavaScript will add particles here -->
    </div>
    <div class="navbar">
        ERROR
    </div>
    <div class="floating-blur blur-1"></div>
    <div class="floating-blur blur-2"></div>
    <div class="error-container">
        <div class="error-message">
            <i class="fas fa-exclamation-circle"></i> Authentication Failed
        </div>
        <center>
            <a href="index.php" class="back-link">
                <span>Return to Login</span>
            </a>
        </center>
    </div>

    <script>
		document.addEventListener('DOMContentLoaded', function() {
			const particlesContainer = document.querySelector('.particles');
			if (!particlesContainer) {
				console.error("Error: .particles element not found!");
				return;	
			}
			for (let i = 0; i < 50; i++) {
				const particle = document.createElement('div');
				particle.className = 'particle';
            	particle.style.left = Math.random() * 100 + 'vw';
            	particle.style.animationDelay = Math.random() * 4 + 's';
            	particle.style.opacity = Math.random();
            	particlesContainer.appendChild(particle);	
			}
		});
    </script>
</body>

</html>