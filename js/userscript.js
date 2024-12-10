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