    // Back to Top

    function toggleTopContainerVisibility(){
        const topContainer = document.getElementById('top-container');
        if(window.scrollY >= 500){
            topContainer.classList.add('show');
        }else{
            topContainer.classList.remove('show');
        }
    }

    window.addEventListener('scroll', toggleTopContainerVisibility);

    document.getElementById('scroll-to-top').addEventListener('click', function (event){
        event.preventDefault();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
    
    toggleTopContainerVisibility();
    
    // Show Password

    function showPassword(){
        var x = document.getElementById("password");
        if(x.type == "password"){
            x.type = "text";
        }else{
            x.type = "password";
        }
    }

    function showRegPassword(){
        var x = document.getElementById("regpassword");
        if(x.type == "password"){
            x.type = "text";
        }else{
            x.type = "password";
        }
    }

    // Toggle Login & Register Form

    function showRegisterForm(){
        var loginForm = document.getElementById("login");
        var registerForm = document.getElementById("register");
        loginForm.style.display = "none";
        registerForm.style.display = "block";
    }

    function showLoginForm(){
        var loginForm = document.getElementById("login");
        var registerForm = document.getElementById("register");
        loginForm.style.display = "block";
        registerForm.style.display = "none";
    }