function login() {
	var username = document.getElementById('username').value;
	var password = document.getElementById('password').value;

	// Admin credentials validation
	if (username === 'admin' && password === 'adminpassword') {
		alert('Welcome, Admin! Login successful.');
		// Redirect to admin dashboard or perform admin-specific actions
	} else {
		alert('Invalid credentials. Please try again.');
	}
}
