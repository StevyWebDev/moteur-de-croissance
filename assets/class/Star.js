export default function star() {
    const stars = document.querySelectorAll('.la-star')
    const note = document.querySelector('#company_notice_form_star')
    const yellow = "rgb(238, 215, 6)"
    

    for(star of stars) {
        star.addEventListener("mouseover", function() {
            resetStar()
            this.style.color = yellow
            this.classList.add("las")
            this.classList.remove("lar")

            let previousStar = this.previousElementSibling;

            while(previousStar){
                // On passe l'étoile qui précède en rouge
                previousStar.style.color = yellow;
                previousStar.classList.add("las");
                previousStar.classList.remove("lar");
                // On récupère l'étoile qui la précède
                previousStar = previousStar.previousElementSibling;
            }
        })

        // On écoute le clic
        star.addEventListener("click", function(){
            note.value = this.dataset.value;
        });

        star.addEventListener("mouseout", function(){
            resetStar(note.value);
        });
    }
    
    function resetStar(note = 0) {
        for(star of stars){
            if(star.dataset.value > note){
                star.style.color = yellow;
                star.classList.add("lar");
                star.classList.remove("las");
            }else{
                star.style.color = yellow;
                star.classList.add("las");
                star.classList.remove("lar");
            }
        }
    }

    const averageStarsValue = document.querySelector('#input-stars')
    const averageStars = document.querySelector('#stars')

    averageStars.style.width = averageStarsValue.value * 20+"%"
}

