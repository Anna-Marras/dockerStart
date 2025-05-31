document.addEventListener("DOMContentLoaded", () => {
    const registerForm = document.getElementById("registerForm");
    if (registerForm) {
        registerForm.addEventListener("submit", async function(e) {
            e.preventDefault(); 

            const submitButton = this.querySelector("button[type='submit']");
            submitButton.disabled = true;

            const formData = new FormData(this);
            const data = {};
            formData.forEach((value, key) => {
                data[key] = value;
            });

            const response = await fetch("?page=register", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(data)
            });
            
            const result = await response.json(); 
            

            document.getElementById("responseMessage").innerHTML = `
                <div class="${result.success ? 'text-green-700 bg-green-100' : 'text-red-700 bg-red-100'} border px-4 py-3 rounded">
                    ${result.message}
                </div>`;

                if (result.success) {
                    setTimeout(() => {
                        window.location.href = "?page=profil";
                    }, 1000);
                }
        });
    }
});



document.addEventListener("DOMContentLoaded", () => {

    const loginForm = document.getElementById("loginForm");
    if (loginForm) {
        loginForm.addEventListener("submit", async function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const data = {};
            formData.forEach((value, key) => {
                data[key] = value;
            });

            const response = await fetch("?page=login", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(data)
            });

            const result = await response.json();
            document.getElementById("loginMessage").innerHTML = `
                <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded">
                    ${result.message}  
                </div>`;
                
                if (result.success) {
                    setTimeout(() => {
                        window.location.href = "/boutique-en-ligne/?page=home";
                    }, 1000);
                }
                
        });
    }
});
