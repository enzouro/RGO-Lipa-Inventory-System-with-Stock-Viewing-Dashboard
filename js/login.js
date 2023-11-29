// login.js
document.addEventListener("DOMContentLoaded", function () {
    const loginForm = document.forms.loginForm;

    loginForm.addEventListener("submit", function (e) {
        e.preventDefault();

        // Get form data
        const formData = new FormData(loginForm);
        const username = formData.get("username");
        const password = formData.get("password");

        // Check if fields are empty
        if (!username || !password) {
            Swal.fire({
                icon: "error",
                title: "Empty Fields",
                text: "Please enter both username and password.",
            });
            return; // Stop form submission if fields are empty
        }

        // AJAX request to login_process.php
        fetch("php/login_process.php", {
            method: "POST",
            body: formData,
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.status === "success") {
                    Swal.fire({
                        icon: "success",
                        title: "Login Successful!",
                        timer: 2000,
                        showConfirmButton: false,
                    }).then(() => {
                        // Redirect based on the user role
                        if (data.role === "admin") {
                            window.location.href = "admin.php";
                        } else if (data.role === "employee") {
                            window.location.href = "inventory.php";
                        } else if (data.role === "client") {
                            window.location.href = "client.php";
                        }
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Invalid Credentials",
                        text: "Please check your username and password.",
                    }).then(() => {
                        // Clear form fields on invalid credentials
                        loginForm.reset();
                    });
                }
            })
            .catch((error) => {
                console.error("Error:", error);
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Something went wrong. Please try again.",
                });
            });
    });
});
